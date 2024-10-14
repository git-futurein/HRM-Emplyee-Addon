<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\Country;
use Addons\Employee\Models\Department;
use Addons\Employee\Models\Designation;
use Addons\Employee\Models\Employee;
use Addons\Employee\Models\JobCategory;
use Addons\Employee\Models\LeaveTable;
use Addons\Employee\Models\ProvidentFund;
use Addons\Employee\Models\Race;
use Addons\Employee\Models\WorkTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class EmployeeExportImportController extends Controller {
    /**
     * User data export.
     */

    // public function export() {
    //     // Clear the output buffer
    //     if ( ob_get_length() ) {
    //         ob_end_clean();
    //     }

    //     // Get users with their employees
    //     $users = User::withWhereHas( 'employee' )->get();

    //     // dd( $users );
    //     $csvFileName = 'users.csv';
    //     $handle      = fopen( 'php://output', 'w' );

    //     // Set headers for download
    //     header( 'Content-Type: text/csv' );
    //     header( 'Content-Disposition: attachment; filename="' . $csvFileName . '"' );
    //     header( 'Pragma: no-cache' );
    //     header( 'Expires: 0' );

    //     // Add CSV headers
    //     fputcsv( $handle, [
    //         'ID',
    //         'Employee ID',
    //         'Name',
    //         'Email',
    //         'Gender',
    //         'DOB',
    //         'NRIC',
    //         'Mobile',
    //         // 'Address Type',
    //         // 'House No',
    //         // 'Level No',
    //         // 'Unit No',
    //         // 'Address',
    //         // 'City',
    //         // 'State',
    //         // 'Postcode',
    //         // 'Country',
    //         // 'Comment',
    //         // 'Nationality',
    //         // 'Marital Status',
    //         // 'Home Telephone',
    //         // 'Work Telephone',
    //         // 'CPF No',
    //         // 'Join Date',
    //         // 'Alternate Email',
    //         // 'Race',
    //         // 'Tex no',
    //         // 'Probation From',
    //         // 'Probation To',
    //         // 'Date Left',
    //         // 'CPF Table',
    //         // 'Work Table',
    //         // 'Levy',
    //         // 'Leave Table',
    //         // 'Status',
    //         // 'Department',
    //         // 'Job Title',
    //         // 'Job Category',
    //         // 'Designation',
    //         // 'Basic Rate',
    //         // 'Pay Basis',
    //         // 'Salary Start Date',
    //         // 'Salary End Date',
    //         // 'Emergency Contact Name',
    //         // 'Emergency Contact Home Telephone',
    //         // 'Emergency Contact Mobile',
    //         // 'Emergency Contact Work Telephone',
    //         // 'Emergency Contact Email',
    //     ] );

    //     // Add data rows
    //     foreach ( $users as $user ) {

    //         fputcsv( $handle, [
    //             $user->id,
    //             $user->employee ? $user->employee->employee_id : '',
    //             $user->name,
    //             $user->email,
    //             $user->employee ? $user->employee->gender : '',
    //             $user->employee ? $user->employee->dob : '',
    //             $user->employee ? $user->employee->id_number : '',
    //             $user->employee ? $user->employee->phone : '',
    //             // $nric,
    //             // $mobile,
    //             // $user->employee ? $user->employee->address->type : '',
    //             // $user->employee ? $user->employee->address->house_no : '',
    //             // $user->employee ? $user->employee->address->level_no : '',
    //             // $user->employee ? $user->employee->address->unit_no : '',
    //             // $user->employee ? $user->employee->address->type : '',
    //             // $user->employee ? $user->employee->address->city : '',
    //             // $user->employee ? $user->employee->address->state : '',
    //             // $user->employee ? $user->employee->address->postcode : '',
    //             // $user->employee ? $user->employee->address->country : '',
    //             // $user->employee ? $user->employee->address->comment : '',
    //             // $user->employee ? $user->employee->nationality : '',
    //             // $user->employee ? $user->employee->marital_status : '',
    //             // $user->employee ? $user->employee->home_telephone : '',
    //             // $user->employee ? $user->employee->work_telephone : '',
    //             // $user->employee ? $user->employee->cpf_id : '',
    //             // $user->employee ? $user->employee->join_date : '',
    //             // $user->employee ? $user->employee->alternate_email : '',
    //             // $user->employee ? $user->employee->race : '',
    //             // $user->employee ? $user->employee->tax_no : '',
    //             // $user->employee ? $user->employee->probation_from : '',
    //             // $user->employee ? $user->employee->probation_to : '',
    //             // $user->employee ? $user->employee->date_left : '',
    //             // $user->employee ? $user->employee->cpf_table_id : '',
    //             // $user->employee ? $user->employee->work_table_id : '',
    //             // $user->employee ? $user->employee->levy : '',
    //             // $user->employee ? $user->employee->leave_table_id : '',
    //             // $user->employee ? $user->employee->status : '',
    //             // $user->employee ? $user->employee->department : '',
    //             // $user->employee ? $user->employee->job_title : '',
    //             // $user->employee ? $user->employee->job_category : '',
    //             // $user->employee ? $user->employee->designation : '',
    //             // $user->employee ? $user->employee->basic_rate : '',
    //             // $user->employee ? $user->employee->pay_basis : '',
    //             // $user->employee ? $user->employee?->salary_start_date : '',
    //             // $user->employee ? $user->employee?->salary_end_date : '',
    //             // $user->employee ? $user->employee?->emergency_contact_name : '',
    //             // $user->employee ? $user->employee?->emergency_contact_home_telephone : '',
    //             // $user->employee ? $user->employee?->emergency_contact_mobile_telephone : '',
    //             // $user->employee ? $user->employee?->emergency_contact_work_telephone : '',
    //             // $user->employee ? $user->employee?->emergency_contact_email : '',

    //         ] );
    //     }

    //     fclose( $handle );
    //     exit;
    // }

    public function export() {
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        // Set document properties
        $sheet->setShowGridlines( false );

        // Add headers
        $headers = [
            'ID',
            'Employee ID',
            'Name',
            'Email',
            'Gender',
            'DOB',
            'NRIC',
            'Mobile',
            'Address Type',
            'House No',
            'Level No',
            'Unit No',
            'Address',
            'City',
            'State',
            'Postcode',
            'Country',
            'Comment',
            'Nationality',
            'Marital Status',
            'Home Telephone',
            'Work Telephone',
            'CPF No',
            'Join Date',
            'Alternate Email',
            'Race',
            'Tax No',
            'Probation From',
            'Probation To',
            'Date Left',
            'CPF Table',
            'Work Table',
            'Levy',
            'Leave Table',
            'Status',
            'Department',
            'Job Title',
            'Job Category',
            'Designation',
            'Basic Rate',
            'Pay Basis',
            'Salary Start Date',
            'Salary End Date',
            'Emergency Contact Name',
            'Emergency Contact Home Telephone',
            'Emergency Contact Mobile',
            'Emergency Contact Work Telephone',
            'Emergency Contact Email',
        ];

        // Add headers to the spreadsheet
        $sheet->fromArray( $headers, NULL, 'A1' );

        // Style the header row
        $headerStyle = [
            'font'    => [
                'bold' => true,
            ],
            'fill'    => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF000000'],
                'color'      => ['argb' => 'FFCCCCCC'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN, // Change to BORDER_THIN for solid lines
                    'color' => ['argb' => 'FF000000'], // Black color
                ],
            ],

        ];

        $sheet->getStyle( 'A1:' . 'AV1' )->applyFromArray( $headerStyle );

        // Fetch users from the database
        $users = User::with( 'employee' )->get();

        // Add data rows
        $rowIndex = 2; // Start from row 2
        foreach ( $users as $user ) {
            $employee = $user->employee;

            $sheet->setCellValue( 'A' . $rowIndex, $user->id );
            $sheet->setCellValue( 'B' . $rowIndex, $employee ? $employee->employee_id : '' );
            $sheet->setCellValue( 'C' . $rowIndex, $user->name );
            $sheet->setCellValue( 'D' . $rowIndex, $user->email );
            $sheet->setCellValue( 'E' . $rowIndex, $employee ? $employee->gender : '' );
            $sheet->setCellValue( 'F' . $rowIndex, $employee ? $employee->dob : '' );
            $sheet->setCellValue( 'G' . $rowIndex, $employee ? $employee->id_number : '' );
            $sheet->setCellValue( 'H' . $rowIndex, $employee ? $employee->phone : '' );
            $sheet->setCellValue( 'I' . $rowIndex, $employee ? $employee->address_type : '' );
            $sheet->setCellValue( 'J' . $rowIndex, $employee ? $employee->house_no : '' );
            $sheet->setCellValue( 'K' . $rowIndex, $employee ? $employee->level_no : '' );
            $sheet->setCellValue( 'L' . $rowIndex, $employee ? $employee->unit_no : '' );
            $sheet->setCellValue( 'M' . $rowIndex, $employee ? $employee->address : '' );
            $sheet->setCellValue( 'N' . $rowIndex, $employee ? $employee->city : '' );
            $sheet->setCellValue( 'O' . $rowIndex, $employee ? $employee->state : '' );
            $sheet->setCellValue( 'P' . $rowIndex, $employee ? $employee->postcode : '' );
            $sheet->setCellValue( 'Q' . $rowIndex, $employee ? getCountryName( $employee->country_id ) : '' );
            $sheet->setCellValue( 'R' . $rowIndex, $employee ? $employee->comment_id : '' );
            $sheet->setCellValue( 'S' . $rowIndex, $employee ? getCountryNationality( $employee->country_id ) : '' );
            $sheet->setCellValue( 'T' . $rowIndex, $employee ? $employee->marital_status : '' );
            $sheet->setCellValue( 'U' . $rowIndex, $employee ? $employee->home_telephone : '' );
            $sheet->setCellValue( 'V' . $rowIndex, $employee ? $employee->work_telephone : '' );
            $sheet->setCellValue( 'W' . $rowIndex, $employee ? $employee->cpf_id : '' );
            $sheet->setCellValue( 'X' . $rowIndex, $employee ? $employee->join_date : '' );
            $sheet->setCellValue( 'Y' . $rowIndex, $employee ? $employee->alternate_email : '' );
            $sheet->setCellValue( 'Z' . $rowIndex, $employee ? $employee->race : '' );
            $sheet->setCellValue( 'AA' . $rowIndex, $employee ? $employee->tax_no : '' );
            $sheet->setCellValue( 'AB' . $rowIndex, $employee ? $employee->probation_from : '' );
            $sheet->setCellValue( 'AC' . $rowIndex, $employee ? $employee->probation_to : '' );
            $sheet->setCellValue( 'AD' . $rowIndex, $employee ? $employee->date_left : '' );
            $sheet->setCellValue( 'AE' . $rowIndex, $employee ? $employee->cpf_table_id : '' );
            $sheet->setCellValue( 'AF' . $rowIndex, $employee ? $employee->work_table_id : '' );
            $sheet->setCellValue( 'AG' . $rowIndex, $employee ? $employee->levy : '' );
            $sheet->setCellValue( 'AH' . $rowIndex, $employee ? getLeaveTable( $employee->leave_table_id ) : '' );
            $sheet->setCellValue( 'AI' . $rowIndex, $employee ? $employee->status : '' );
            $sheet->setCellValue( 'AJ' . $rowIndex, $employee ? getDepartmentName( $employee->department_id ) : '' );
            $sheet->setCellValue( 'AK' . $rowIndex, $employee ? $employee->job_title : '' );
            $sheet->setCellValue( 'AL' . $rowIndex, $employee ? $employee->job_category : '' );
            $sheet->setCellValue( 'AM' . $rowIndex, $employee ? getDesignationName( $employee->designation_id ) : '' );
            $sheet->setCellValue( 'AN' . $rowIndex, $employee ? $employee->basic_rate : '' );
            $sheet->setCellValue( 'AO' . $rowIndex, $employee ? $employee->pay_basis : '' );
            $sheet->setCellValue( 'AP' . $rowIndex, $employee ? $employee->salary_start_date : '' );
            $sheet->setCellValue( 'AQ' . $rowIndex, $employee ? $employee->salary_end_date : '' );
            $sheet->setCellValue( 'AR' . $rowIndex, $employee ? $employee->emergency_contact_name : '' );
            $sheet->setCellValue( 'AS' . $rowIndex, $employee ? $employee->emergency_contact_home_telephone : '' );
            $sheet->setCellValue( 'AT' . $rowIndex, $employee ? $employee->emergency_contact_mobile_telephone : '' );
            $sheet->setCellValue( 'AU' . $rowIndex, $employee ? $employee->emergency_contact_work_telephone : '' );
            $sheet->setCellValue( 'AV' . $rowIndex, $employee ? $employee->emergency_contact_email : '' );

            $rowIndex++;
        }

        // Remove borders from all cells
        $highestRow    = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $sheet->getStyle( 'A2:' . $highestColumn . $highestRow )->applyFromArray( [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN, // Change to BORDER_THIN for solid lines
                    'color' => ['argb' => 'FF000000'], // Black color
                ],
            ],
            'fill'    => [
                'fillType' => Fill::FILL_NONE, // No background fill
                'color' => ['argb' => 'FFFFFFFF'], // White color
            ],
        ] );

        $columnWidths = [
            'A' => 5, // ID
            'B' => 15, // Employee ID
            'C' => 30, // Name
            'D' => 25, // Email
            'E' => 10, // Email
            'F' => 10, // Email
            'G' => 10, // Email
            'H' => 25, // Email
            'I' => 25, // Email
            'J' => 25, // Email
            'K' => 25, // Email
            'L' => 25, // Email
            'M' => 25, // Email
            'N' => 25, // Email
            'O' => 25, // Email
            'P' => 25, // Email
            'Q' => 25, // Email
            'R' => 25, // Email
            'S' => 25, // Email
            'T' => 25, // Email
            'U' => 25, // Email
            'V' => 25, // Email
            'W' => 25, // Email
            'X' => 25, // Email
            'Y' => 25, // Email
            'Z' => 25, // Email
            'AA' => 25, // Email
            'AB' => 25, // Email
            'AC' => 25, // Email
            'AD' => 25, // Email
            'AE' => 25, // Email
            'AF' => 25, // Email
            'AG' => 25, // Email
            'AH' => 25, // Email
            'AI' => 25, // Email
            'AJ' => 25, // Email
            'AK' => 25, // Email
            'AL' => 25, // Email
            'AM' => 25, // Email
            'AN' => 25, // Email
            'AO' => 25, // Email
            'AP' => 25, // Email
            'AQ' => 25, // Email
            'AR' => 25, // Email
            'AS' => 25, // Email
            'AT' => 25, // Email
            'AU' => 25, // Email
            'AV' => 25, // Email

        ];

        // Set column widths
        // foreach ( range( 'A', $highestColumn ) as $columnID ) {
        //     $sheet->getColumnDimension( $columnID )->setAutoSize( true );
        // }

        foreach ( $columnWidths as $column => $width ) {
            $sheet->getColumnDimension( $column )->setWidth( $width );
        }

        // Create Excel file and download
        $writer      = new Xlsx( $spreadsheet );
        $csvFileName = 'employees.xlsx';
        // Set the right headers for downloading
        header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
        header( 'Content-Disposition: attachment; filename="' . $csvFileName . '"' );
        header( 'Cache-Control: max-age=0' );

        $writer->save( 'php://output' );
        exit;
    }

    /**
     * Import data from CSV file
     */
    public function importForm() {

        $view = 'Employee::import';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Employee::import' );
        }
    }

    /**
     * Import data from CSV file
     */
    public function importData( Request $request ) {
        $request->validate( ['file' => 'required|file|mimes:csv,txt,xlsx,xls'] );

        // Store the uploaded file in the public directory
        $fileName = time() . '.' . $request->file( 'file' )->getClientOriginalExtension();
        $request->file( 'file' )->move( public_path( 'uploads' ), $fileName ); // Save to public/uploads

        // Open and read the CSV file
        if ( ( $handle = fopen( public_path( 'uploads/' . $fileName ), 'r' ) ) !== FALSE ) {
            // Skip the header row if necessary
            fgetcsv( $handle );

            // dd( fgetcsv( $handle ) );

            try {
                DB::beginTransaction();

                while ( ( $data = fgetcsv( $handle ) ) !== FALSE ) {
                    // Log the data being processed
                    Log::info( 'Processing row: ', $data );

                    // Check if the user already exists based on id_no
                    $existingUser     = User::where( 'email', $data[3] )->first();
                    $lats_employee_id = Employee::latest( 'id' )->first();

                    if ( $existingUser ) {
                        // If user exists, log and optionally skip or update
                        Log::info( "User with id_no {$data[3]} already exists. Skipping." );
                        continue; // Skip to the next row
                    }

                    // Create User
                    $user = User::create( [
                        'name'        => $data[0] ?? null,
                        'first_name'  => $data[0] ?? null,
                        'gender'      => $data[1] ?? null,
                        'dob'         => $data[2] ?? null,
                        'email'       => $data[3] ?? null,
                        'employee_id' => $lats_employee_id ? $lats_employee_id->employee_id + 1 : 1,
                        'password'    => Hash::make( $data[4] ),
                        'id_no'       => $data[5] ? $data[5] : rand( 1000, 9999 ),
                        'phone'       => $data[6] ?? null,
                        'address'     => $data[11] ?? null,
                        'city'        => $data[12] ?? null,
                        'zip_code'    => $data[13] ?? null,
                        'country'     => $data[14] ? self::getCountryId( $data[14] ) : null,
                        'race_id'     => $data[26] ? self::getRaceId( $data[26] ) : null,
                    ] );

                    // Log created user ID
                    Log::info( "Created user with ID: " . $user->id );

                    // Create Employee
                    $employee                  = new Employee();
                    $employee->user_id         = $user->id;
                    $employee->auth_id         = auth()->user()->id;
                    $employee->name            = $data[0] ?? null;
                    $employee->gender          = strtolower( $data[1] );
                    $employee->dob             = $data[2] ?? null;
                    $employee->email           = $data[3] ?? null;
                    $employee->id_number       = $data[5] ? $data[5] : rand( 1000, 9999 );
                    $employee->phone           = $data[6] ?? null;
                    $employee->house_no        = $data[7] ?? null;
                    $employee->level_no        = $data[8] ?? null;
                    $employee->unit_no         = $data[9] ?? null;
                    $employee->employee_id     = $lats_employee_id ? $lats_employee_id->employee_id + 1 : 1;
                    $employee->street          = $data[10] ?? null;
                    $employee->address         = $data[11] ?? null;
                    $employee->city            = $data[12] ?? null;
                    $employee->state           = $data[13] ?? null;
                    $employee->zip_code        = $data[14] ?? null;
                    $employee->country_id      = $data[15] ? self::getCountryId( $data[15] ) : null;
                    $employee->nationality_id  = $data[16] ? self::getNationalityId( $data[16] ) : null;
                    $employee->marital_status  = $data[17] ?? null;
                    $employee->home_telephone  = $data[18] ?? null;
                    $employee->work_telephone  = $data[19] ?? null;
                    $employee->basic_rate      = $data[20] ?? null;
                    $employee->pay_basis       = $data[21] ?? null;
                    $employee->cpf_id          = $data[22] ? self::getCpfId( $data[22] ) : null;
                    $employee->work_table_id   = $data[23] ? self::getWorkTableId( $data[23] ) : null;
                    $employee->leave_table_id  = $data[24] ? self::getLeaveTableId( $data[24] ) : null;
                    $employee->join_date       = $data[25] ?? null;
                    $employee->race_id         = $data[26] ? self::getRaceId( $data[26] ) : null;
                    $employee->probation_from  = $data[27] ?? null;
                    $employee->probation_to    = $data[28] ?? null;
                    $employee->job_category_id = $data[29] ? self::getJobCategoryId( $data[29] ) : null;
                    $employee->department_id   = $data[30] ? self::getDepartmentId( $data[30] ) : null;
                    $employee->designation_id  = $data[31] ? self::getDesignationId( $data[31] ) : null;

                    // Log the employee data before saving
                    Log::info( "Saving employee data: ", $employee->toArray() );

                    // Save employee
                    $employee->save();
                }

                fclose( $handle );
                DB::commit(); // Commit transaction if all is good

                // Delete the uploaded file
                unlink( public_path( 'uploads/' . $fileName ) );

                return redirect()->back()->with( 'success', 'Employee data imported successfully.' );

            } catch ( \Illuminate\Database\QueryException $e ) {
                DB::rollback(); // Rollback transaction if something went wrong
                Log::error( 'Query error: ' . $e->getMessage() );
                return redirect()->back()->withErrors( ['error' => 'Failed to import data: ' . $e->getMessage()] );
            } catch ( \Exception $e ) {
                DB::rollback(); // Rollback for general exceptions
                Log::error( 'Failed to import data: ' . $e->getMessage() );
                return redirect()->back()->withErrors( ['error' => 'Failed to import data: ' . $e->getMessage()] );
            }
        }

        return redirect()->back()->withErrors( ['error' => 'Failed to open the uploaded file.'] );
    }

    /**
     * Download sample CSV file for import.
     */
    public function importSample() {

        $filePath = public_path( 'backend/assets/files/employee/sample/sample_employees.csv' );

        return response()->download( $filePath );
    }

    /**
     * Get race id.
     */
    public function getRaceId( $value ) {

        if ( $value ) {
            return Race::where( 'name', $value )->first()->id ?? null;
        } else {
            return null;
        }
    }

    /**
     * Get country id.
     */
    public function getCountryId( $value ) {

        if ( $value ) {
            return Country::where( 'name', $value )->first()->id ?? null;
        } else {
            return null;
        }
    }

    /**
     * Get nationality id.
     */
    public function getNationalityId( $value ) {

        if ( $value ) {
            return Country::where( 'nationality', $value )->first()->id ?? null;
        } else {
            return null;
        }
    }

    /**
     * Get CPF id.
     */
    public function getCpfId( $value ) {

        if ( $value ) {
            return ProvidentFund::where( 'title', $value )->first()->id ?? null;
        } else {
            return null;
        }
    }

    /**
     * Get work table id.
     */
    public function getWorkTableId( $value ) {

        if ( $value ) {
            return WorkTable::where( 'title', $value )->first()->id ?? null;
        } else {
            return null;
        }
    }

    /**
     * Get leave table id.
     */
    public function getLeaveTableId( $value ) {

        if ( $value ) {
            return LeaveTable::where( 'title', $value )->first()->id ?? null;
        } else {
            return null;
        }
    }

    /**
     * Get job category id.
     */
    public function getJobCategoryId( $value ) {

        if ( $value ) {
            return JobCategory::where( 'title', $value )->first()->id ?? null;
        } else {
            return null;
        }
    }

    /**
     * Get department id.
     */
    public function getDepartmentId( $value ) {

        if ( $value ) {
            return Department::where( 'name', $value )->first()->id ?? null;
        } else {
            return null;
        }
    }

    /**
     * Get department id.
     */
    public function getDesignationId( $value ) {

        if ( $value ) {
            return Designation::where( 'name', $value )->first()->id ?? null;
        } else {
            return null;
        }
    }

}
