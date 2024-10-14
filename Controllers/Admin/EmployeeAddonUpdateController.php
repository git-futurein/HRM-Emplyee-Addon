<?php

namespace Addons\Employee\Controllers\Admin;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class EmployeeAddonUpdateController extends Controller {

    public function checkForUpdates() {
        // Get current version from version.json
        $versionPath = base_path( 'Addons/Employee/version.json' );

        // Safely read the current version
        $currentVersion = json_decode( File::get( $versionPath ), true )['version'] ?? '0.0.0';

        // Prepare to check GitHub for the latest release version
        $token  = env( 'GITHUB_TOKEN' ); // Use an environment variable for the token
        $client = new Client();

        try {
            $response = $client->get( 'https://api.github.com/repos/git-futurein/HRM-Emplyee-Addon/releases/latest', [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                    'Accept'        => 'application/vnd.github.v3+json',
                ],
            ] );

            // $response = $client->get( 'https://api.github.com/repos/nijwel1/employee_addon/releases/latest', [
            //     'verify' => false, // You can set this to false for testing, or set the correct certificate
            // ] );

            //https://codeload.github.com/nijwel1/employee_addon/zip/refs/tags/v1.0.1?token=AXASM2NZWRNNRNIA56UBH5THBJMTE

            // Check if the request was successful
            if ( $response->getStatusCode() === 200 ) {
                // Decode the response
                $latestRelease = json_decode( $response->getBody(), true );

                // Extract the latest version and download URL
                $latestVersion = $latestRelease['tag_name'] ?? '';
                $downloadUrl   = $latestRelease['zipball_url'] ?? '';

                // Compare versions and update if needed
                if ( version_compare( $latestVersion, $currentVersion, '>' ) ) {
                    $this->downloadAndUpdate( $downloadUrl, $versionPath, $latestVersion );
                }
            } else {
                Log::warning( 'Failed to retrieve the latest release: ' . $response->getReasonPhrase() );
            }
        } catch ( \Exception $e ) {
            // Handle exceptions (e.g., network issues, API errors)
            Log::error( 'Error checking for updates: ' . $e->getMessage() );
        }
    }

    public function downloadAndUpdate( $url, $versionPath, $latestVersion ) {
        $client = new Client();

        $zipResponse = $client->get( $url, [
            'stream' => true, // Stream the response
            'verify' => false, // Set according to your needs
        ] );

        $tempFilePath = public_path( 'app/temp_addon.zip' );
        $fileHandle   = fopen( $tempFilePath, 'w' );

        if ( $fileHandle ) {
            // Write the response body to the file
            while ( !$zipResponse->getBody()->eof() ) {
                fwrite( $fileHandle, $zipResponse->getBody()->read( 1024 ) ); // Read in chunks
            }
            fclose( $fileHandle );
            echo "File downloaded successfully to $tempFilePath";
        } else {
            echo "Failed to open file for writing.";
            return false; // Early return on failure
        }

        $zip = new \ZipArchive;
        if ( $zip->open( $tempFilePath ) === TRUE ) {
            // Extract to a temporary location first
            $tempExtractPath = public_path( 'app/temp_addon_extracted' );
            $zip->extractTo( $tempExtractPath );
            $zip->close();

            // Define the target path for the Employee addon
            $targetPath = base_path( 'Addons/Employee' );

            // Replace existing files in the target path
            $this->replaceContents( $tempExtractPath, $targetPath );

            // Clean up temporary files
            File::deleteDirectory( $tempExtractPath );
            unlink( $tempFilePath );

            // Update version.json with the new version
            File::put( $versionPath, json_encode( ['version' => $latestVersion] ) );

            // Run migrations and clear config cache
            $this->runAddonMigrations();
            Artisan::call( 'config:cache' );

            return true;
        } else {
            echo "Failed to open the zip archive.";
            return false;
        }
    }

    private function replaceContents( $source, $destination ) {
        // Ensure destination exists
        if ( !is_dir( $destination ) ) {
            mkdir( $destination, 0755, true );
        }

        // Remove existing files in the destination
        $files = scandir( $destination );
        foreach ( $files as $file ) {
            if ( $file === '.' || $file === '..' ) {
                continue;
            }

            $filePath = $destination . '/' . $file;
            if ( is_dir( $filePath ) ) {
                // Recursively delete directory
                File::deleteDirectory( $filePath );
            } else {
                // Delete file
                unlink( $filePath );
            }
        }

        // Copy new files from the source to the destination
        $this->copyFiles( $source, $destination );
    }

    // Function to copy files and directories
    private function copyFiles( $source, $destination ) {
        $files = scandir( $source );
        foreach ( $files as $file ) {
            if ( $file === '.' || $file === '..' ) {
                continue;
            }

            $srcFile = $source . '/' . $file;
            $dstFile = $destination . '/' . $file;

            if ( is_dir( $srcFile ) ) {
                // Create directory in the destination and copy recursively
                mkdir( $dstFile, 0755, true );
                $this->copyFiles( $srcFile, $dstFile );
            } else {
                // Copy file (will replace if it exists)
                copy( $srcFile, $dstFile );
            }
        }
    }

    private function runAddonMigrations() {
        $migrationPath = base_path( 'Addons/Employee/migrations' );
        if ( File::exists( $migrationPath ) ) {
            Artisan::call( 'migrate', ['--path' => $migrationPath, '--force' => true] );
        }
    }
}
