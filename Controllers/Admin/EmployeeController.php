<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\Country;
use Addons\Employee\Models\Department;
use Addons\Employee\Models\Designation;
use Addons\Employee\Models\Employee;
use Addons\Employee\Models\EmployeeContact;
use Addons\Employee\Models\EmployeeDocument;
use Addons\Employee\Models\EmployeeQualification;
use Addons\Employee\Models\IdType;
use Addons\Employee\Models\JobCategory;
use Addons\Employee\Models\JobType;
use Addons\Employee\Models\LeaveTable;
use Addons\Employee\Models\ProvidentFund;
use Addons\Employee\Models\Race;
use Addons\Employee\Models\Relationship;
use Addons\Employee\Models\WorkTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\EmployeeCreateNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class EmployeeController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request ) {

        // $search = $request->search;
        // $employees = Employee::when( $search, function ( $query ) use ( $search ) {
        //     return $query->where( 'name', 'like', '%' . $search . '%' )
        //         ->orWhere( 'employee_id', 'like', '%' . $search . '%' )
        //         ->orWhere( 'email', 'like', '%' . $search . '%' );
        // } )->get();

        $request->validate( [
            'search'     => 'nullable|string|max:255',
            'department' => 'nullable|string|exists:departments,slug',
        ] );

        $search     = $request->search;
        $department = $request->department;

        $departments = Department::when( $department, function ( $query ) use ( $department ) {
            return $query->where( 'slug', $department );
        } )
            ->whereStatus( 'active' )
            ->withWhereHas( 'employees', function ( $query ) use ( $search ) {
                if ( $search ) {
                    $query->where( function ( $query ) use ( $search ) {
                        $query->where( 'name', 'like', '%' . $search . '%' )
                            ->orWhere( 'employee_id', 'like', '%' . $search . '%' )
                            ->orWhere( 'email', 'like', '%' . $search . '%' );
                    } );
                }
            } )
            ->withCount( 'employees' )
            ->paginate( 10 );

        $departmentFilter = Department::whereStatus( 'active' )->get();

        $view = 'Employee::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Employee::index', compact( 'departments', 'search', 'department', 'departmentFilter' ) );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {

        $idTypes         = IdType::where( 'status', 'active' )->select( 'id', 'name' )->get();
        $races           = Race::where( 'status', 'active' )->select( 'id', 'name' )->get();
        $countries       = Country::select( 'id', 'name', 'nationality' )->get();
        $provident_funds = ProvidentFund::where( 'status', 'active' )->select( 'id', 'title', 'details' )->get();
        $workTabls       = WorkTable::select( 'id', 'title' )->get();
        $leaveTables     = LeaveTable::select( 'id', 'title' )->get();
        $jobCategories   = JobCategory::where( 'status', 'active' )->select( 'id', 'title' )->get();
        $designations    = Designation::where( 'status', 'active' )->select( 'id', 'name' )->get();
        $departments     = Department::where( 'status', 'active' )->select( 'id', 'name' )->get();
        $relationships   = Relationship::where( 'status', 'active' )->select( 'id', 'name' )->get();
        $jobTypes        = JobType::where( 'status', 'active' )->select( 'id', 'name' )->get();

        $qualifications = EmployeeQualification::whereNull( 'employee_unid' )->get();
        $view           = 'Employee::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Employee::create', compact(

                'idTypes',
                'races',
                'countries',
                'provident_funds',
                'workTabls',
                'leaveTables',
                'jobCategories',
                'designations',
                'departments',
                'relationships',
                'jobTypes',
                'qualifications',

            ) );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request ) {

        try {
            DB::beginTransaction();
            $validated = $request->validate( [
                'name'           => 'required',
                'email'          => 'required|email|unique:users,email',
                'employee_id'    => 'required|unique:employees,employee_id',
                'id_number'      => 'required|unique:employees,id_number',
                'dob'            => 'required',
                'gender'         => 'required',
                'phone'          => 'required',
                'address'        => 'required',
                'password'       => 'required_if:autopassword,0|confirmed',
                'cpf_id'         => 'required',
                'work_table_id'  => 'required',
                'leave_table_id' => 'required',
                'basic_rate'     => 'required',
                'join_date'      => 'required',
            ], [
                'password.confirmed' => 'The password confirmation does not match.',
            ] );

            $autoPassword      = generateRandomPassword( 8 );
            $user              = new User();
            $user->name        = $request->name;
            $user->first_name  = $request->name;
            $user->email       = $request->email;
            $user->employee_id = $request->employee_id;
            $user->password    = $request->autopassword == 1 ? Hash::make( $autoPassword ) : Hash::make( $request->password );
            $user->type        = 0;
            $user->phone       = $request->phone;
            $user->address     = $request->address;
            $user->country     = $request->country;
            $user->city        = $request->city;
            $user->address     = $request->address;
            if ( $request->image ) {
                $user->image = imageUpload( $request->image, 400, 400, 'backend/assets/img/user/' );
            }
            $user->save();

            $employee                           = new Employee();
            $employee->auth_id                  = auth()->user()->id;
            $employee->user_id                  = $user->id;
            $employee->name                     = $request->name;
            $employee->email                    = $request->email;
            $employee->employee_id              = $request->employee_id;
            $employee->id_number                = $request->id_number;
            $employee->id_type_id               = $request->id_type_id;
            $employee->dob                      = format_date_only( $request->dob );
            $employee->gender                   = $request->gender;
            $employee->race_id                  = $request->race_id;
            $employee->phone                    = $request->phone;
            $employee->optional_email           = $request->optional_email;
            $employee->address_type             = $request->address_type;
            $employee->house_no                 = $request->house_no;
            $employee->level_no                 = $request->level_no;
            $employee->unit_no                  = $request->unit_no;
            $employee->street                   = $request->street;
            $employee->address                  = $request->address;
            $employee->city                     = $request->city;
            $employee->state                    = $request->state;
            $employee->zip_code                 = $request->zip_code;
            $employee->country_id               = $request->country_id;
            $employee->nationality_id           = $request->nationality_id;
            $employee->home_telephone           = $request->home_telephone;
            $employee->work_telephone           = $request->work_telephone;
            $employee->marital_status           = $request->marital_status;
            $employee->comment                  = $request->comment;
            $employee->bank_name                = $request->bank_name;
            $employee->bank_swift_code          = $request->bank_swift_code;
            $employee->bank_account             = $request->bank_account;
            $employee->role                     = $request->role;
            $employee->is_active                = $request->is_active;
            $employee->cpf_id                   = $request->cpf_id;
            $employee->cpf_full_paid            = $request->cpf_full_paid;
            $employee->pr_effective_date        = format_date_only( $request->pr_effective_date );
            $employee->cpf_no                   = $request->cpf_no;
            $employee->tax_no                   = $request->tax_no;
            $employee->work_table_id            = $request->work_table_id;
            $employee->leave_table_id           = $request->leave_table_id;
            $employee->cpf                      = $request->cpf;
            $employee->shg                      = $request->shg;
            $employee->us_attendance            = $request->us_attendance;
            $employee->max_pay_calculate        = $request->max_pay_calculate;
            $employee->food_allowance           = $request->food_allowance;
            $employee->mobile_allowance         = $request->mobile_allowance;
            $employee->ot_allowance             = $request->ot_allowance;
            $employee->trainer_fee_allowance    = $request->trainer_fee_allowance;
            $employee->transportation_allowance = $request->transportation_allowance;
            $employee->cdac_deduction           = $request->cdac_deduction;
            $employee->ecf_deduction            = $request->ecf_deduction;
            $employee->mbmf_deduction           = $request->mbmf_deduction;
            $employee->sinda_deduction          = $request->sinda_deduction;
            $employee->transportation_deduction = $request->transportation_deduction;
            $employee->job_title                = $request->job_title;
            $employee->job_category_id          = $request->job_category_id;
            $employee->designation_id           = $request->designation_id;
            $employee->pay_basis                = $request->pay_basis;
            $employee->basic_rate               = $request->basic_rate;
            $employee->start_date               = format_date_only( $request->start_date );
            $employee->end_date                 = format_date_only( $request->end_date );
            $employee->department_id            = $request->department_id;
            $employee->emplyee_status           = $request->emplyee_status;
            $employee->join_date                = format_date_only( $request->join_date );
            $employee->left_date                = format_date_only( $request->left_date );
            $employee->employee_type            = $request->employee_type;
            $employee->manager_id               = $request->manager_id;
            $employee->probation_from           = format_date_only( $request->probation_from );
            $employee->probation_to             = format_date_only( $request->probation_to );
            $employee->save();

            $employeeQualification = EmployeeQualification::where( 'user_id', Auth::id() )
                ->whereNull( 'employee_unid' )
                ->get();

            if ( $employeeQualification->isNotEmpty() ) {
                foreach ( $employeeQualification as $qualification ) {
                    $qualification->update( [
                        'employee_id'   => $employee->id,
                        'user_id'       => $user->id,
                        'employee_unid' => $request->employee_id,
                    ] );
                }
            }

            $employeeContact = EmployeeContact::where( 'user_id', Auth::id() )
                ->whereNull( 'employee_unid' )
                ->get();

            if ( $employeeContact->isNotEmpty() ) {
                foreach ( $employeeContact as $contact ) {
                    $contact->update( [
                        'employee_id'   => $employee->id,
                        'user_id'       => $user->id,
                        'employee_unid' => $request->employee_id,
                    ] );
                }
            }

            $employeeDocument = EmployeeDocument::where( 'user_id', Auth::id() )
                ->whereNull( 'employee_unid' )
                ->get();

            if ( $employeeDocument->isNotEmpty() ) {
                foreach ( $employeeDocument as $document ) {
                    $document->update( [
                        'employee_id'   => $employee->id,
                        'user_id'       => $user->id,
                        'employee_unid' => $request->employee_id,
                    ] );
                }
            }

            $tempPassword = $request->autopassword == 1 ? $autoPassword : $request->password;

            Notification::send( $user, new EmployeeCreateNotification( $user, $tempPassword, $employee ) );

            DB::commit();
            return redirect()->back()->with( [
                'success'       => 'Employee saved successfully!',
                'employee_unid' => $request->employee_id,
                'name'          => $user->name,
                'email'         => $user->email,
                'password'      => $request->autopassword == 1 ? $autoPassword : $request->password,

            ] );
        } catch ( \Exception $e ) {
            DB::rollBack();
            return redirect()->back()->withInput()->with( 'error', $e->getMessage() );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show( string $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( string $id ) {

        $employee        = Employee::with( 'contacts', 'qualifications', 'documents' )->find( $id );
        $idTypes         = IdType::where( 'status', 'active' )->select( 'id', 'name' )->get();
        $races           = Race::where( 'status', 'active' )->select( 'id', 'name' )->get();
        $countries       = Country::select( 'id', 'name', 'nationality' )->get();
        $provident_funds = ProvidentFund::where( 'status', 'active' )->select( 'id', 'title', 'details' )->get();
        $workTabls       = WorkTable::select( 'id', 'title' )->get();
        $leaveTables     = LeaveTable::select( 'id', 'title' )->get();
        $jobCategories   = JobCategory::where( 'status', 'active' )->select( 'id', 'title' )->get();
        $designations    = Designation::where( 'status', 'active' )->select( 'id', 'name' )->get();
        $departments     = Department::where( 'status', 'active' )->select( 'id', 'name' )->get();
        $relationships   = Relationship::where( 'status', 'active' )->select( 'id', 'name' )->get();
        $jobTypes        = JobType::where( 'status', 'active' )->select( 'id', 'name' )->get();

        $view = 'Employee::edit';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {

            return view( 'Employee::edit', compact(

                'idTypes',
                'races',
                'countries',
                'provident_funds',
                'workTabls',
                'leaveTables',
                'jobCategories',
                'designations',
                'departments',
                'relationships',
                'jobTypes',
                'employee'

            ) );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, $id ) {

        // dd( $request->all() );
        DB::beginTransaction();
        try {
            // Validate the incoming request
            $request->validate( [
                'name'           => 'required',
                'employee_id'    => 'required|unique:employees,employee_id,' . $id,
                'id_number'      => 'required|unique:employees,id_number,' . $id,
                'dob'            => 'required',
                'gender'         => 'required',
                'phone'          => 'required',
                'address'        => 'required',
                'cpf_id'         => 'required',
                'work_table_id'  => 'required',
                'leave_table_id' => 'required',
                'basic_rate'     => 'required',
                'join_date'      => 'required',
            ] );

            $employee = Employee::find( $id );

            // Retrieve the user and employee models
            $user = User::where( 'id', $employee->user_id )->firstOrFail();

            // Update user details
            $user->name    = $request->name;
            $user->phone   = $request->phone;
            $user->address = $request->address;
            if ( $request->image ) {
                $user->image = imageUpload( $request->image, 400, 400, 'backend/assets/img/user/' );
            }

            // Update password if provided
            if ( $request->filled( 'password' ) ) {
                $user->password = Hash::make( $request->password );
            }

            $user->save();

            // Update employee details

            $employee->name                     = $request->name;
            $employee->employee_id              = $request->employee_id;
            $employee->id_number                = $request->id_number;
            $employee->id_type_id               = $request->id_type_id;
            $employee->dob                      = format_date_only( $request->dob );
            $employee->gender                   = $request->gender;
            $employee->race_id                  = $request->race_id;
            $employee->phone                    = $request->phone;
            $employee->optional_email           = $request->optional_email;
            $employee->address_type             = $request->address_type;
            $employee->house_no                 = $request->house_no;
            $employee->level_no                 = $request->level_no;
            $employee->unit_no                  = $request->unit_no;
            $employee->street                   = $request->street;
            $employee->address                  = $request->address;
            $employee->city                     = $request->city;
            $employee->state                    = $request->state;
            $employee->zip_code                 = $request->zip_code;
            $employee->country_id               = $request->country_id;
            $employee->nationality_id           = $request->nationality_id;
            $employee->home_telephone           = $request->home_telephone;
            $employee->work_telephone           = $request->work_telephone;
            $employee->marital_status           = $request->marital_status;
            $employee->comment                  = $request->comment;
            $employee->bank_name                = $request->bank_name;
            $employee->bank_swift_code          = $request->bank_swift_code;
            $employee->bank_account             = $request->bank_account;
            $employee->role                     = $request->role;
            $employee->is_active                = $request->is_active;
            $employee->cpf_id                   = $request->cpf_id;
            $employee->cpf_full_paid            = $request->cpf_full_paid;
            $employee->pr_effective_date        = format_date_only( $request->pr_effective_date );
            $employee->cpf_no                   = $request->cpf_no;
            $employee->tax_no                   = $request->tax_no;
            $employee->work_table_id            = $request->work_table_id;
            $employee->leave_table_id           = $request->leave_table_id;
            $employee->cpf                      = $request->cpf;
            $employee->shg                      = $request->shg;
            $employee->us_attendance            = $request->us_attendance;
            $employee->max_pay_calculate        = $request->max_pay_calculate;
            $employee->food_allowance           = $request->food_allowance;
            $employee->mobile_allowance         = $request->mobile_allowance;
            $employee->ot_allowance             = $request->ot_allowance;
            $employee->trainer_fee_allowance    = $request->trainer_fee_allowance;
            $employee->transportation_allowance = $request->transportation_allowance;
            $employee->cdac_deduction           = $request->cdac_deduction;
            $employee->ecf_deduction            = $request->ecf_deduction;
            $employee->mbmf_deduction           = $request->mbmf_deduction;
            $employee->sinda_deduction          = $request->sinda_deduction;
            $employee->transportation_deduction = $request->transportation_deduction;
            $employee->job_title                = $request->job_title;
            $employee->job_category_id          = $request->job_category_id;
            $employee->designation_id           = $request->designation_id;
            $employee->pay_basis                = $request->pay_basis;
            $employee->basic_rate               = $request->basic_rate;
            $employee->start_date               = format_date_only( $request->start_date );
            $employee->end_date                 = format_date_only( $request->end_date );
            $employee->department_id            = $request->department_id;
            $employee->emplyee_status           = $request->emplyee_status;
            $employee->join_date                = format_date_only( $request->join_date );
            $employee->left_date                = format_date_only( $request->left_date );
            $employee->employee_type            = $request->employee_type;
            $employee->manager_id               = $request->manager_id;
            $employee->probation_from           = format_date_only( $request->probation_from );
            $employee->probation_to             = format_date_only( $request->probation_to );

            $employee->save();

            // Update qualifications, contacts, and documents
            $this->updateRelatedRecords( $user->id, $employee->id, $request->employee_id );

            DB::commit();
            return redirect()->back()->with( [
                'success'       => 'Employee updated successfully!',
                'employee_unid' => $request->employee_id,
                'name'          => $user->name,
                'email'         => $user->email,
            ] );
        } catch ( \Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }
    }

    private function updateRelatedRecords( $userId, $employeeId, $employeeUnid ) {
        // Update EmployeeQualification
        EmployeeQualification::where( 'user_id', $userId )
            ->whereNull( 'employee_unid' )
            ->update( [
                'employee_id'   => $employeeId,
                'employee_unid' => $employeeUnid,
            ] );

        // Update EmployeeContact
        EmployeeContact::where( 'user_id', $userId )
            ->whereNull( 'employee_unid' )
            ->update( [
                'employee_id'   => $employeeId,
                'employee_unid' => $employeeUnid,
            ] );

        // Update EmployeeDocument
        EmployeeDocument::where( 'user_id', $userId )
            ->whereNull( 'employee_unid' )
            ->update( [
                'employee_id'   => $employeeId,
                'employee_unid' => $employeeUnid,
            ] );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {
        $employee = Employee::find( $id );
        $employee->delete();
        return redirect()->back()->with( 'success', 'Employee deleted successfully!' );
    }

    /**
     * Get the qualification data.
     */
    public function getQualificationData( $id ) {

        $qualifications = EmployeeQualification::where( function ( $query ) use ( $id ) {
            $query->where( 'employee_id', $id )
                ->orWhere( function ( $subQuery ) {
                    $subQuery->where( 'user_id', auth()->id() )
                        ->where( 'employee_unid', null );
                } );
        } )->get();

        $view = 'Employee::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {

            return view( 'Employee::additional.qualification.index', compact( 'qualifications' ) );
        }
    }

    /**
     * Get the contact data.
     */
    public function getContactData( $id ) {

        $contacts = EmployeeContact::where( function ( $query ) use ( $id ) {
            $query->where( 'employee_id', $id )
                ->orWhere( function ( $subQuery ) {
                    $subQuery->where( 'user_id', auth()->id() )
                        ->where( 'employee_unid', null );
                } );
        } )->get();

        $view = 'Employee::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Employee::additional.contact.index', compact( 'contacts' ) );
        }
    }

    /**
     * Get the document data.
     */
    public function getDocumentData( $id ) {

        $documents = EmployeeDocument::where( function ( $query ) use ( $id ) {
            $query->where( 'employee_id', $id )
                ->orWhere( function ( $subQuery ) {
                    $subQuery->where( 'user_id', auth()->id() )
                        ->where( 'employee_unid', null );
                } );
        } )->get();

        $view = 'Employee::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Employee::additional.document.index', compact( 'documents' ) );
        }
    }

    /**
     * Display a listing of the delete resource.
     */
    public function indexTrash( Request $request ) {

        $search    = $request->search;
        $employees = Employee::when( $search, function ( $query ) use ( $search ) {
            return $query->where( 'name', 'like', '%' . $search . '%' )
                ->orWhere( 'employee_id', 'like', '%' . $search . '%' )
                ->orWhere( 'email', 'like', '%' . $search . '%' );
        } )->onlyTrashed()->get();

        $view = 'Employee::trash';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Employee::trash', compact( 'employees', 'search' ) );
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore( string $id ) {
        $employee = Employee::withTrashed()->find( $id );
        $employee->restore();
        return redirect()->back()->with( 'success', 'Employee restored successfully.' );
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete( string $id ) {
        $employee = Employee::withTrashed()->find( $id );
        $employee->forceDelete();
        return redirect()->back()->with( 'success', 'Employee deleted permanently.' );
    }

    /**
     * Delete all selected from storage.
     */
    public function deleteAll() {
        Employee::onlyTrashed()->forceDelete();
        return redirect()->back()->with( 'success', 'All Employee deleted permanently.' );
    }

    /**
     * Change password.
     */
    public function changePassword( Request $request, $id ) {
        try {
            DB::beginTransaction();
            $validated = $request->validate( [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'password.confirmed' => 'The password confirmation does not match.',
            ] );

            $user           = User::where( 'employee_id', $id )->firstOrFail();
            $user->password = Hash::make( $request->password );
            $user->save();

            DB::commit();
            return redirect()->back()->with( 'success', 'Password change successfully.' );
        } catch ( \Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }
    }

    /**
     * Change email.
     */
    public function changeEmail( Request $request, $id ) {
        try {
            DB::beginTransaction();
            $validated = $request->validate( [
                'newEmail' => ['required', 'email', 'unique:users,email'],
            ] );

            //change from user table
            $user        = User::where( 'employee_id', $id )->firstOrFail();
            $user->email = $request->newEmail;
            $user->save();

            //change from employee table
            $employee        = Employee::where( 'id', $id )->firstOrFail();
            $employee        = Employee::where( 'employee_id', $id )->firstOrFail();
            $employee->email = $request->newEmail;
            $employee->save();

            DB::commit();
            return redirect()->back()->with( 'success', 'Email change successfully.' );
        } catch ( \Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }
    }
}
