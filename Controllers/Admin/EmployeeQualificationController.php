<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\EmployeeQualification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeQualificationController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $qualifications = EmployeeQualification::where( 'user_id', Auth::id() )->whereNull( 'employee_unid' )->get();

        $view = 'Employee::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Employee::additional.qualification.index', compact( 'qualifications' ) );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request ) {

        $data                = new EmployeeQualification();
        $data->q_institution = $request->q_institution;
        $data->q_level       = $request->q_level;
        $data->q_type        = $request->q_type;
        $data->q_start_date  = $request->q_start_date;
        $data->q_end_date    = $request->q_end_date;
        $data->q_expire_date = $request->q_expire_date;
        $data->q_comment     = $request->q_comment;
        $data->user_id       = Auth::id();

        $data->save();

        return response()->json( 'Qualification added successfully.' );
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

        $data = EmployeeQualification::find( $id );

        $view = 'Employee::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Employee::additional.qualification.edit', compact( 'data' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {

        $data                = EmployeeQualification::find( $id );
        $data->q_institution = $request->q_institution;
        $data->q_level       = $request->q_level;
        $data->q_type        = $request->q_type;
        $data->q_start_date  = $request->q_start_date;
        $data->q_end_date    = $request->q_end_date;
        $data->q_expire_date = $request->q_expire_date;
        $data->q_comment     = $request->q_comment;
        $data->user_id       = Auth::id();

        $data->save();

        return response()->json( 'Qualification update successfully.' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {
        $data = EmployeeQualification::find( $id );
        $data->delete();
        return response()->json( 'Qualification deleted successfully.' );
    }
}
