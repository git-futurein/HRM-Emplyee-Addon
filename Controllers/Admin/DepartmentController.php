<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\Department;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DepartmentController extends Controller {

    /**
     * Display a listing of the resource.
     */
    public function index() {

        $departments = Department::select( 'id', 'name', 'status' )->get();

        return view( 'Department::index', compact( 'departments' ) );

        $view = 'Department::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Department::index', compact( 'departments' ) );
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

        $validated = $request->validate( [
            'name' => 'required|unique:departments|max:255',
        ] );

        try {
            DB::beginTransaction();
            $department          = new Department();
            $department->auth_id = auth()->user()->id;
            $department->name    = $request->name;
            $department->slug    = Str::slug( $request->name );
            $department->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Department created successfully.' );
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
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

        $data = Department::find( $id );
        $view = 'Department::edit';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Department::edit', compact( 'data' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {

        $validated = $request->validate( [
            'name' => 'required|unique:departments,name,' . $id . '|max:255',
        ] );
        try {
            DB::beginTransaction();
            $department         = Department::find( $id );
            $department->name   = $request->name;
            $department->slug   = Str::slug( $request->name );
            $department->status = $request->status;
            $department->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Department updated successfully.' );
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {

        $department = Department::find( $id );
        $department->delete();
        return redirect()->back()->with( 'success', 'Department deleted successfully.' );
    }

    /**
     * Display a listing of the delete resource.
     */
    public function indexTrash() {

        $departments = Department::onlyTrashed()->get();
        $view        = 'Department::trash';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Department::trash', compact( 'departments' ) );
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore( string $id ) {
        $department = Department::withTrashed()->find( $id );
        $department->restore();
        return redirect()->back()->with( 'success', 'Department restored successfully.' );
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete( string $id ) {
        $department = Department::withTrashed()->find( $id );
        $department->forceDelete();
        return redirect()->back()->with( 'success', 'Department deleted permanently.' );
    }

    /**
     * Delete all selected from storage.
     */
    public function deleteAll() {
        Department::onlyTrashed()->forceDelete();
        return redirect()->back()->with( 'success', 'All Departments deleted permanently.' );
    }
}
