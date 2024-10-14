<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\LeaveType;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveTypeController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $leaves = LeaveType::all();
        return view( 'LeaveType::index', compact( 'leaves' ) );
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
            'title'       => 'required|unique:leave_types|max:255',
            'paid_status' => 'required',
        ] );

        try {
            DB::beginTransaction();
            $leave              = new LeaveType();
            $leave->auth_id     = auth()->user()->id;
            $leave->title       = $request->title;
            $leave->paid_status = $request->paid_status;
            $leave->remarks     = $request->remarks;
            $leave->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Leave created successfully.' );
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

        $data = LeaveType::find( $id );
        return view( 'LeaveType::edit', compact( 'data' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {

        $validated = $request->validate( [
            'title'       => 'required|unique:leave_types,title,' . $id . '|max:255',
            'paid_status' => 'required',
        ] );
        try {
            DB::beginTransaction();
            $leave              = LeaveType::find( $id );
            $leave->title       = $request->title;
            $leave->paid_status = $request->paid_status;
            $leave->remarks     = $request->remarks;
            $leave->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Leave updated successfully.' );
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {

        $leave = LeaveType::find( $id );
        $leave->delete();
        return redirect()->back()->with( 'success', 'Leave deleted successfully.' );
    }

    /**
     * Display a listing of the delete resource.
     */
    public function indexTrash() {

        $leaves = LeaveType::onlyTrashed()->get();
        return view( 'LeaveType::trash', compact( 'leaves' ) );
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore( string $id ) {
        $leave = LeaveType::withTrashed()->find( $id );
        $leave->restore();
        return redirect()->back()->with( 'success', 'Leave type restored successfully.' );
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete( string $id ) {
        $leave = LeaveType::withTrashed()->find( $id );
        $leave->forceDelete();
        return redirect()->back()->with( 'success', 'Leave type deleted permanently.' );
    }

    /**
     * Delete all selected from storage.
     */
    public function deleteAll() {
        LeaveType::onlyTrashed()->forceDelete();
        return redirect()->back()->with( 'success', 'All Leave type deleted permanently.' );
    }
}
