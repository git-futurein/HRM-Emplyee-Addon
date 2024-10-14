<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\Designation;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DesignationController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $designations = Designation::select( 'id', 'name', 'status' )->get();
        $view         = 'Designation::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Designation::index', compact( 'designations' ) );
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
            'name' => 'required|unique:designations|max:255',
        ] );

        try {
            DB::beginTransaction();
            $designation          = new Designation();
            $designation->auth_id = auth()->user()->id;
            $designation->name    = $request->name;
            $designation->slug    = Str::slug( $request->name );
            $designation->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Designation created successfully.' );
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

        $data = Designation::find( $id );
        $view = 'Designation::edit';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Designation::edit', compact( 'data' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {

        $validated = $request->validate( [
            'name' => 'required|unique:designations,name,' . $id . '|max:255',
        ] );
        try {
            DB::beginTransaction();
            $designation         = Designation::find( $id );
            $designation->name   = $request->name;
            $designation->slug   = Str::slug( $request->name );
            $designation->status = $request->status;
            $designation->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Designation updated successfully.' );
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {

        $designation = Designation::find( $id );
        $designation->delete();
        return redirect()->back()->with( 'success', 'Designation deleted successfully.' );
    }

    /**
     * Display a listing of the delete resource.
     */
    public function indexTrash() {

        $designations = Designation::onlyTrashed()->get();
        $view         = 'Designation::trash';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'Designation::trash', compact( 'designations' ) );
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore( string $id ) {
        $designation = Designation::withTrashed()->find( $id );
        $designation->restore();
        return redirect()->back()->with( 'success', 'Designation restored successfully.' );
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete( string $id ) {
        $designation = Designation::withTrashed()->find( $id );
        $designation->forceDelete();
        return redirect()->back()->with( 'success', 'Designation deleted permanently.' );
    }

    /**
     * Delete all selected from storage.
     */
    public function deleteAll() {
        Designation::onlyTrashed()->forceDelete();
        return redirect()->back()->with( 'success', 'All designations deleted permanently.' );
    }
}
