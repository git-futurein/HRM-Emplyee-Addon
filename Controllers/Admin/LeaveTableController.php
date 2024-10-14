<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\LeaveTable;
use Addons\Employee\Models\LeaveTableDetails;
use Addons\Employee\Models\LeaveType;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveTableController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $leaveTables = LeaveTable::withcount( 'leaveTableDetails' )->get();
        return view( 'LeaveTable::index', compact( 'leaveTables' ) );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $leaveTypes = LeaveType::select( 'id', 'title' )->get();
        return view( 'LeaveTable::create', compact( 'leaveTypes' ) );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request ) {

        $request->validate( [
            'title' => 'required|unique:leave_tables,title',
        ] );

        try {
            DB::beginTransaction();
            $leaveTable              = new LeaveTable();
            $leaveTable->auth_id     = auth()->user()->id;
            $leaveTable->title       = $request->title;
            $leaveTable->description = $request->description;
            $leaveTable->save();

            $leaveTypes = $request->leave_type;
            foreach ( $leaveTypes as $key => $leaveType ) {

                $leaveTableDetails                  = new LeaveTableDetails();
                $leaveTableDetails->leave_table_id  = $leaveTable->id;
                $leaveTableDetails->leave_type_id   = $leaveType;
                $leaveTableDetails->from            = $request->from[$key];
                $leaveTableDetails->to              = $request->to[$key];
                $leaveTableDetails->entitlement     = $request->entitlement[$key];
                $leaveTableDetails->carried_forward = $request->carried_forward[$key];
                $leaveTableDetails->save();
            }

            DB::commit();
            return redirect()->route( 'LeaveTable::index' )->with( 'success', 'Leave table created successfully!' );
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->route( 'LeaveTable::index' )->with( 'error', 'Something went wrong!' );
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

        $leaveTypes = LeaveType::select( 'id', 'title' )->get();
        $leaveTable = LeaveTable::with( 'leaveTableDetails' )->find( $id );
        return view( 'LeaveTable::edit', compact( 'leaveTable', 'leaveTypes' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {
        // Validate the incoming request data
        $request->validate( [
            'title' => 'required|string|unique:leave_tables,title,' . $id,
        ] );

        try {
            DB::beginTransaction();

            // Find the leave table record
            $leaveTable              = LeaveTable::findOrFail( $id );
            $leaveTable->title       = $request->title;
            $leaveTable->description = $request->description;
            $leaveTable->save();

            // Delete existing leave table details
            LeaveTableDetails::where( 'leave_table_id', $id )->delete();

            // Insert or update leave table details
            $leaveTypes = $request->leave_type;
            foreach ( $leaveTypes as $key => $leaveType ) {
                $leaveTableDetails                  = new LeaveTableDetails();
                $leaveTableDetails->leave_table_id  = $leaveTable->id;
                $leaveTableDetails->leave_type_id   = $leaveType;
                $leaveTableDetails->from            = $request->from[$key];
                $leaveTableDetails->to              = $request->to[$key];
                $leaveTableDetails->entitlement     = $request->entitlement[$key];
                $leaveTableDetails->carried_forward = $request->carried_forward[$key];
                $leaveTableDetails->save();
            }

            DB::commit();
            return redirect()->route( 'LeaveTable::index' )->with( 'success', 'Leave table updated successfully!' );
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->route( 'LeaveTable::index' )->with( 'error', 'Something went wrong!' );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {

        try {
            DB::beginTransaction();

            // Find the leave table record
            $leaveTable = LeaveTable::findOrFail( $id );

            // Delete associated leave table details
            LeaveTableDetails::where( 'leave_table_id', $id )->delete();

            // Delete the leave table record
            $leaveTable->delete();

            DB::commit();
            return redirect()->route( 'LeaveTable::index' )->with( 'success', 'Leave table deleted successfully!' );
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->route( 'LeaveTable::index' )->with( 'error', 'Something went wrong!' );
        }
    }

    /**
     * Display a listing of the delete resource.
     */
    public function indexTrash() {

        $leaveTables = LeaveTable::onlyTrashed()->get();
        return view( 'LeaveTable::trash', compact( 'leaveTables' ) );
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore( string $id ) {
        $leaveTable = LeaveTable::withTrashed()->find( $id );
        $leaveTable->restore();

        foreach ( $leaveTable->leaveTableDetails()->withTrashed()->get() as $child ) {
            $child->restore();
        }

        return redirect()->back()->with( 'success', 'Leave table restored successfully.' );
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete( string $id ) {
        $leaveTable = LeaveTable::withTrashed()->find( $id );
        $leaveTable->forceDelete();
        return redirect()->back()->with( 'success', 'Leave table deleted permanently.' );
    }

    /**
     * Delete all selected from storage.
     */
    public function deleteAll() {
        LeaveTable::onlyTrashed()->forceDelete();
        return redirect()->back()->with( 'success', 'All Leave table deleted permanently.' );
    }
}
