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
            'stream' => true,
            'verify' => false,
        ] );

        $tempFilePath = public_path( 'app/temp_addon.zip' );
        $fileHandle   = fopen( $tempFilePath, 'w' );

        if ( $fileHandle ) {
            while ( !$zipResponse->getBody()->eof() ) {
                fwrite( $fileHandle, $zipResponse->getBody()->read( 1024 ) );
            }
            fclose( $fileHandle );
            echo "File downloaded successfully to $tempFilePath";
        } else {
            echo "Failed to open file for writing.";
            return false;
        }

        $zip = new \ZipArchive;
        if ( $zip->open( $tempFilePath ) === TRUE ) {
            $targetPath = base_path( 'Addons/Employee' );

            // Ensure the target directory exists
            if ( !is_dir( $targetPath ) ) {
                mkdir( $targetPath, 0755, true );
            }

            // Iterate through the files in the zip
            for ( $i = 0; $i < $zip->numFiles; $i++ ) {
                $fileName = $zip->getNameIndex( $i );

                // Skip unwanted folders like .git or any directories
                if ( strpos( $fileName, '.git/' ) === 0 || substr( $fileName, -1 ) === '/' ) {
                    continue;
                }

                // Remove the main folder prefix
                $mainFolderName = 'git-futurein-HRM-Emplyee-Addon-8d35406/';
                if ( strpos( $fileName, $mainFolderName ) === 0 ) {
                    $relativePath = substr( $fileName, strlen( $mainFolderName ) );
                } else {
                    $relativePath = $fileName;
                }

                // Define the destination path
                $destinationPath = $targetPath . '/' . $relativePath;

                // Ensure the directory structure exists
                if ( !is_dir( dirname( $destinationPath ) ) ) {
                    mkdir( dirname( $destinationPath ), 0755, true );
                }

                // Extract the file to the target path
                $zip->extractTo( $targetPath, $fileName );
                rename( $targetPath . '/' . $fileName, $destinationPath );
            }
            $zip->close();

            // Clean up temporary files
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

    private function runAddonMigrations() {
        $migrationPath = base_path( 'Addons/Employee/migrations' );
        if ( File::exists( $migrationPath ) ) {
            Artisan::call( 'migrate', ['--path' => $migrationPath, '--force' => true] );
        }
    }
}
