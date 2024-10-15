<?php

namespace Addons\Employee\Controllers\Admin;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use ZipArchive;

class EmployeeAddonUpdateController extends Controller {

    public function downloadAndUpdate() {
=======
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class EmployeeAddonUpdateController extends Controller {

    public function checkForUpdates() {
>>>>>>> origin/master
        // Get current version from version.json
        $versionPath = base_path( 'Addons/Employee/version.json' );

        // Safely read the current version
        $currentVersion = json_decode( File::get( $versionPath ), true )['version'] ?? '0.0.0';

<<<<<<< HEAD
        $url = 'https://api.github.com/repos/git-futurein/HRM-Emplyee-Addon/releases/latest';

        // Make the request to the API
        $response = Http::withHeaders( ['Accept' => 'application/vnd.github.v3+json'] )->get( $url );

        // Check if the response is successful
        if ( $response->successful() ) {
            // Decode the JSON response
            $data = $response->json();

            // Get the version and zipball_url from the response
            $latestVersion = $data['tag_name'] ?? '';
            $zipballUrl    = $data['zipball_url'] ?? '';

            // Compare versions and update if needed
            if ( version_compare( $latestVersion, $currentVersion, '>' ) ) {
                // Make a request to download the ZIP file
                $zipResponse = Http::withHeaders( ['git-futurein' => 'HRM-Emplyee-Addon'] )
                    ->get( $zipballUrl, ['access_token' => env( 'GITHUB_TOKEN' )] );

                if ( $latestVersion ) {
                    $zipContent  = $zipResponse->body();
                    $zipFileName = "{$data['name']}.zip"; // or use $data['tag_name'] for versioned name
                    $filePath    = public_path( $zipFileName );

                    // Save the ZIP file to the public directory
                    file_put_contents( $filePath, $zipContent );

                    $zip = new ZipArchive;

                    if ( $zip->open( $filePath ) === TRUE ) {
                        // Extract the zip file to a temporary location
                        $extractPath = storage_path( 'app/temp' );
                        $zip->extractTo( $extractPath );
                        $zip->close();

                        // Move files to the appropriate directories
                        $this->moveFiles( $extractPath );

                        // Clean up the temporary directory
                        $this->deleteDirectory( $extractPath );

                        $this->runAddonMigrations();
                        Artisan::call( 'config:cache' );

                        return back()->with( 'success', 'Files imported successfully.' );
                    } else {
                        return back()->with( 'error', 'Failed to open zip file.' );
                    }
                }

                return response()->json( ['error' => 'Unable to download ZIP file'], 500 );
            }

            return response()->json( ['message' => 'No update needed, current version is up to date.'] );
        }

        // Handle error response
        return response()->json( ['error' => 'Unable to fetch release data'], 500 );
    }

    private function moveFiles( $extractPath ) {
        // Assuming the dynamic folder name is the only folder in the extract path
        $dynamicFolder = glob( $extractPath . '/*', GLOB_ONLYDIR );

        // If a dynamic folder is found, get its path
        if ( !empty( $dynamicFolder ) ) {
            $dynamicFolderPath = $dynamicFolder[0];

            // File mappings for known folders
            $fileMappings = [
                'controllers' => base_path( 'Addons/Employee/Controllers' ),
                'helpers'     => base_path( 'Addons/Employee/Helpers' ),
                'models'      => base_path( 'Addons/Employee/Models' ),
                'routes'      => base_path( 'Addons/Employee/routes' ),
                'views'       => base_path( 'Addons/Employee/resources/views' ),
                'vendor'      => base_path( 'Addons/Employee/vendor' ),
                'database'    => base_path( 'Addons/Employee/database' ),
            ];

            // Move files from known subfolders
            foreach ( $fileMappings as $folder => $destination ) {
                $sourcePath = $dynamicFolderPath . '/' . $folder; // Use dynamic folder path
                if ( is_dir( $sourcePath ) ) {
                    $this->copyFiles( $sourcePath, $destination );
                }
            }

            // Move EmployeeServiceProvider.php
            $providerSource = $dynamicFolderPath . '/EmployeeServiceProvider.php';
            if ( file_exists( $providerSource ) ) {
                $providerDestination = base_path( 'Addons/Employee/EmployeeServiceProvider.php' );
                copy( $providerSource, $providerDestination );
            }

            // Move version.json
            $versionSource = $dynamicFolderPath . '/version.json';
            if ( file_exists( $versionSource ) ) {
                $versionDestination = base_path( 'Addons/Employee/version.json' );
                copy( $versionSource, $versionDestination );
            }
        }
    }

    private function copyFiles( $sourcePath, $destination ) {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator( $sourcePath, \RecursiveDirectoryIterator::SKIP_DOTS ),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ( $files as $file ) {
            $relativePath    = $files->getSubPathName();
            $destinationPath = $destination . '/' . $relativePath;

            if ( $file->isDir() ) {
                if ( !file_exists( $destinationPath ) ) {
                    mkdir( $destinationPath, 0755, true );
                }
            } else if ( $file->isFile() ) {
                if ( !file_exists( dirname( $destinationPath ) ) ) {
                    mkdir( dirname( $destinationPath ), 0755, true );
                }
                copy( $file->getRealPath(), $destinationPath );
            }
        }
    }

    private function deleteDirectory( $dir ) {
        if ( !file_exists( $dir ) ) {
            return true;
        }

        if ( !is_dir( $dir ) ) {
            return unlink( $dir );
        }

        foreach ( scandir( $dir ) as $item ) {
            if ( $item == '.' || $item == '..' ) {
                continue;
            }

            if ( !$this->deleteDirectory( $dir . DIRECTORY_SEPARATOR . $item ) ) {
                return false;
            }
        }

        return rmdir( $dir );
=======
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
>>>>>>> origin/master
    }

    private function runAddonMigrations() {
        $migrationPath = base_path( 'Addons/Employee/migrations' );
        if ( File::exists( $migrationPath ) ) {
            Artisan::call( 'migrate', ['--path' => $migrationPath, '--force' => true] );
        }
    }
}
