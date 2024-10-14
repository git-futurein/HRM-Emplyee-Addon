<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\EmployeeContact;
use Addons\Employee\Models\Relationship;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeContactController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $contacts = EmployeeContact::where( 'user_id', Auth::id() )->whereNull( 'employee_unid' )->get();

        $view = 'Employee::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Employee::additional.contact.index', compact( 'contacts' ) );
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

        $data                    = new EmployeeContact();
        $data->c_name            = $request->c_name;
        $data->c_gender          = $request->c_gender;
        $data->c_relationship_id = $request->c_relationship_id;
        $data->c_home_telephone  = $request->c_home_telephone;
        $data->c_mobile          = $request->c_mobile;
        $data->c_work_telephone  = $request->c_work_telephone;
        $data->c_email           = $request->c_email;
        $data->user_id           = Auth::id();

        $data->save();

        return response()->json( 'Contact create successfully.' );
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

        $data          = EmployeeContact::find( $id );
        $relationships = Relationship::where( 'status', 'active' )->select( 'id', 'name' )->get();
        $view          = 'Employee::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Employee::additional.contact.edit', compact( 'data', 'relationships' ) );
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {

        $data                    = EmployeeContact::find( $id );
        $data->c_name            = $request->c_name;
        $data->c_gender          = $request->c_gender;
        $data->c_relationship_id = $request->c_relationship_id;
        $data->c_home_telephone  = $request->c_home_telephone;
        $data->c_mobile          = $request->c_mobile;
        $data->c_work_telephone  = $request->c_work_telephone;
        $data->c_email           = $request->c_email;
        $data->user_id           = Auth::id();

        $data->save();

        return response()->json( 'Contact update successfully.' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {

        $data = EmployeeContact::find( $id );
        $data->delete();
        return response()->json( 'Contact deleted successfully.' );
    }
}
