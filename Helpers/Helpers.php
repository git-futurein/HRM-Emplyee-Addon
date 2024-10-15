<?php

use Addons\Employee\Models\Country;
use Addons\Employee\Models\Department;
use Addons\Employee\Models\Designation;
use Addons\Employee\Models\Employee;
use Addons\Employee\Models\LeaveTable;
use Addons\Employee\Models\WorkTable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

if ( !function_exists( 'employee_unid' ) ) {
    function employee_unid() {
        $data = Employee::orderBy( 'id', 'desc' )->first();
        return $data ? $data->employee_id + 1 : 1;
    }
}

if ( !function_exists( 'employee_addon' ) ) {
    function employee_addon() {

        return DB::table( 'addon_settings' )
            ->where( 'name', 'employee' )
            ->value( 'enabled' );
    }
}

if ( !function_exists( 'getCountryName' ) ) {
    function getCountryName( $value ) {
        return Country::where( 'id', $value )->first()->name ?? '';
    }
}

if ( !function_exists( 'getCountryNationality' ) ) {
    function getCountryNationality( $value ) {
        return Country::where( 'id', $value )->first()->nationality ?? '';
    }
}

if ( !function_exists( 'getLeaveTable' ) ) {
    function getLeaveTable( $value ) {
        return LeaveTable::where( 'id', $value )->first()->title ?? '';
    }
}

if ( !function_exists( 'getWorkTable' ) ) {
    function getWorkTable( $value ) {
        return WorkTable::where( 'id', $value )->first()->title ?? '';
    }
}

if ( !function_exists( 'getDesignationName' ) ) {
    function getDesignationName( $value ) {
        return Designation::where( 'id', $value )->first()->name ?? '';
    }
}

if ( !function_exists( 'getDepartmentName' ) ) {
    function getDepartmentName( $value ) {
        return Department::where( 'id', $value )->first()->name ?? '';
    }
}

if ( !function_exists( 'addonVersion' ) ) {
    function addonVersion() {
        // Get current version from version.json
        $versionPath = base_path( 'Addons/Employee/version.json' );

        // Safely read the current version
        $currentVersion = json_decode( File::get( $versionPath ), true )['version'] ?? '0.0.0';

        // Prepare to check GitHub for the latest release version
        $token  = env( 'GITHUB_TOKEN' ); // Use an environment variable for the token
        $client = new Client();

        try {
            $url = 'https://api.github.com/repos/git-futurein/HRM-Emplyee-Addon/releases/latest';

            // Make the request to the API
            $response = Http::withHeaders( ['Accept' => 'application/vnd.github.v3+json'] )->get( $url );

            // Check if the request was successful
            if ( $response->successful() ) {
                // Decode the response
                $latestRelease = $response->json();

                // Extract the latest version and download URL
                $latestVersion = $latestRelease['tag_name'] ?? '';

                // Compare versions and update if needed
                if ( version_compare( $latestVersion, $currentVersion, '>' ) ) {
                    return "
                        <div style='padding: 15px; border: 1px solid #f0ad4e; background-color: #fcf8e3; border-radius: 5px; margin-bottom: 15px;'>
                            <strong style='color: #f0ad4e;'>Update Available!</strong><br><br>
                            A new version <strong>'{$latestVersion}'</strong> of the Employee Addon is available.
                            Install it from <a href='" . route( 'employee.addon.update' ) . "' style='color: #d9534f; text-decoration: underline;'>here</a>.
                        </div>
                    ";
                }
            } else {
                Log::warning( 'Failed to retrieve the latest release: ' . $response->getReasonPhrase() );
            }
        } catch ( \Exception $e ) {
            // Handle exceptions (e.g., network issues, API errors)
            Log::error( 'Error checking for updates: ' . $e->getMessage() );
        }
    }
}