<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\EmployeeDocument;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class EmployeeDocumentController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $documents = EmployeeDocument::where( 'user_id', Auth::id() )->whereNull( 'employee_unid' )->get();

        $view = 'Employee::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Employee::additional.document.index', compact( 'documents' ) );
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

        $data                = new EmployeeDocument();
        $data->d_title       = $request->d_title;
        $data->d_category    = $request->d_category;
        $data->d_start_date  = $request->d_start_date;
        $data->d_end_date    = $request->d_end_date;
        $data->d_expiry_date = $request->d_expiry_date;
        $data->d_remark      = $request->d_remark;
        if ( $request->d_file ) {
            $data->d_file = fileUpload( $request->d_file, 'backend/assets/files/employee/document', '' );
        }
        $data->user_id = Auth::id();
        $data->save();
        return response()->json( 'Document created successfully.' );
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

        $data = EmployeeDocument::find( $id );

        $view = 'Employee::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Employee::additional.document.edit', compact( 'data' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {

        $data                = EmployeeDocument::find( $id );
        $data->d_title       = $request->d_title;
        $data->d_category    = $request->d_category;
        $data->d_start_date  = $request->d_start_date;
        $data->d_end_date    = $request->d_end_date;
        $data->d_expiry_date = $request->d_expiry_date;
        $data->d_remark      = $request->d_remark;
        if ( $request->d_file ) {

            if ( $data->d_file ) {
                File::delete( $data->d_file );
            }
            $data->d_file = fileUpload( $request->d_file, 'backend/assets/files/employee/document', '' );
        }
        $data->user_id = Auth::id();
        $data->save();
        return response()->json( 'Document updated successfully.' );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {

        $data = EmployeeDocument::find( $id );

        if ( $data->d_file ) {
            File::delete( $data->d_file );
        }
        $data->delete();
        return response()->json( 'Contact deleted successfully.' );
    }
}
