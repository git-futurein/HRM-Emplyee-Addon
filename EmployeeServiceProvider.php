<?php

namespace Addons\Employee;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class EmployeeServiceProvider extends ServiceProvider {

    public function boot() {

        $enabled = DB::table( 'addon_settings' )
            ->where( 'name', 'employee' )
            ->value( 'enabled' );

        if ( $enabled ) {
            $this->loadViewsFrom( __DIR__ . '/Views/admin/department', 'Department' );
            $this->loadViewsFrom( __DIR__ . '/Views/admin/designation', 'Designation' );
            $this->loadViewsFrom( __DIR__ . '/Views/admin/employee', 'Employee' );
            $this->loadViewsFrom( __DIR__ . '/Views/admin/id_type', 'IdType' );
            $this->loadViewsFrom( __DIR__ . '/Views/admin/job_category', 'JobCategory' );
            $this->loadViewsFrom( __DIR__ . '/Views/admin/job_type', 'JobType' );
            $this->loadViewsFrom( __DIR__ . '/Views/admin/leave_type', 'LeaveType' );
            $this->loadViewsFrom( __DIR__ . '/Views/admin/leave_table', 'LeaveTable' );
            $this->loadViewsFrom( __DIR__ . '/Views/admin/provident_fund', 'ProvidentFund' );
            $this->loadViewsFrom( __DIR__ . '/Views/admin/race', 'Race' );
            $this->loadViewsFrom( __DIR__ . '/Views/admin/relationship', 'Relationship' );
            $this->loadViewsFrom( __DIR__ . '/Views/admin/work_table', 'WorkTable' );
            $this->loadViewsFrom( __DIR__ . '/Views', 'Notification' );
            $this->loadMigrationsFrom( __DIR__ . '/Migrations' );
            $this->loadRoutesFrom( __DIR__ . '/routes/admin.php' );

            $this->loadHelpers();
            // $this->checkForUpdates();
        }

    }

    // public function boot() {

    //     $enabled = DB::table( 'addon_settings' )
    //         ->where( 'name', 'employee' )
    //         ->value( 'enabled' );

    //     if ( $enabled ) {
    //         $this->loadHelpers(); // Ensure helpers are loaded

    //         // Define your view paths
    //         $viewPaths = [
    //             'department'     => 'Department',
    //             'designation'    => 'Designation',
    //             'employee'       => 'Employee',
    //             'id_type'        => 'IdType',
    //             'job_category'   => 'JobCategory',
    //             'job_type'       => 'JobType',
    //             'leave_type'     => 'LeaveType',
    //             'leave_table'    => 'LeaveTable',
    //             'provident_fund' => 'ProvidentFund',
    //             'race'           => 'Race',
    //             'relationship'   => 'Relationship',
    //             'work_table'     => 'WorkTable',
    //             'notification'   => 'Notification',
    //         ];

    //         foreach ( $viewPaths as $path => $namespace ) {
    //             $fullPath = __DIR__ . "/Views/admin/{$path}";
    //             if ( is_dir( $fullPath ) ) {
    //                 $this->loadViewsFrom( $fullPath, $namespace );
    //             } else {
    //                 // Log or handle the missing view directory
    //                 return false;
    //             }
    //         }

    //         $this->loadMigrationsFrom( __DIR__ . '/Migrations' );
    //         $this->loadRoutesFrom( __DIR__ . '/routes/admin.php' );
    //     }
    // }

    public function register() {
        $this->app->make( 'Addons\Employee\Controllers\Admin\DepartmentController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\DesignationController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\EmployeeContactController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\EmployeeController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\EmployeeDocumentController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\EmployeeExportImportController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\EmployeeQualificationController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\IdTypeController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\JobCategoryController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\JobTypeController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\LeaveTypeController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\LeaveTableController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\ProvidentFundController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\RaceController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\RelationshipController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\WorkTableController' );
        $this->app->make( 'Addons\Employee\Controllers\Admin\EmployeeAddonUpdateController' );
    }

    public function loadHelpers() {
        $helpers = __DIR__ . '/Helpers/Helpers.php';

        if ( file_exists( $helpers ) ) {
            require_once $helpers;
        }
    }

    // private function checkForUpdates() {
    //     // Get current version from version.json
    //     $versionPath = base_path( 'Addons/Employee/version.json' );

    //     // Safely read the current version
    //     $currentVersion = json_decode( File::get( $versionPath ), true )['version'] ?? '0.0.0';

    //     // Prepare to check GitHub for the latest release version
    //     $token  = ''; // Use a secure way to manage tokens
    //     $client = new \GuzzleHttp\Client();

    //     try {
    //         $response = $client->get( 'https://api.github.com/repos/nijwel1/employee_addon/releases/latest', [
    //             'headers' => [
    //                 'Authorization' => "Bearer {$token}",
    //                 'Accept'        => 'application/vnd.github.v3+json',
    //             ],
    //         ] );

    //         // Decode the response
    //         $latestRelease = json_decode( $response->getBody(), true );

    //         dd( $latestRelease );

    //         // Extract the latest version and download URL
    //         if ( $latestRelease ) {
    //             $latestVersion = $latestRelease['tag_name'] ?? '';
    //             $downloadUrl   = $latestRelease['zipball_url'] ?? '';

    //             // Compare versions and update if needed
    //             if ( version_compare( $latestVersion, $currentVersion, '>' ) ) {
    //                 $this->downloadAndUpdate( $downloadUrl, $versionPath, $latestVersion );
    //             }
    //         }
    //     } catch ( \Exception $e ) {
    //         // Handle exceptions (e.g., network issues, API errors)
    //         Log::error( 'Error checking for updates: ' . $e->getMessage() );
    //     }
    // }

    // private function downloadAndUpdate( $url, $versionPath, $latestVersion ) {
    //     $tempFilePath = storage_path( 'app/temp_addon.zip' );
    //     file_put_contents( $tempFilePath, file_get_contents( $url ) );

    //     $zip = new \ZipArchive;
    //     if ( $zip->open( $tempFilePath ) === TRUE ) {
    //         // Extract new files to add-on directory
    //         $zip->extractTo( base_path( 'Addons/Employee' ) );
    //         $zip->close();
    //         unlink( $tempFilePath );

    //         // Update version.json with the new version
    //         File::put( $versionPath, json_encode( ['version' => $latestVersion] ) );

    //         // Run migrations and clear config cache
    //         $this->runAddonMigrations();
    //         Artisan::call( 'config:cache' );

    //         echo "Addon updated successfully!";
    //     } else {
    //         echo "Failed to extract addon.";
    //     }
    // }

    // private function runAddonMigrations() {
    //     $migrationPath = base_path( 'Addons/Employee/migrations' );
    //     if ( File::exists( $migrationPath ) ) {
    //         Artisan::call( 'migrate', ['--path' => $migrationPath, '--force' => true] );
    //     }
    // }
}