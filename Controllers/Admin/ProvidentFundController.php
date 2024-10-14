<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\ProvidentFund;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvidentFundController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $providentFunds = ProvidentFund::select( 'id', 'title', 'details', 'status' )->get();
        return view( 'ProvidentFund::index', compact( 'providentFunds' ) );
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
            'title' => 'required|unique:provident_funds|max:255',
        ] );

        try {
            DB::beginTransaction();
            $providentFund          = new ProvidentFund();
            $providentFund->auth_id = auth()->user()->id;
            $providentFund->title   = $request->title;
            $providentFund->details = $request->details;
            $providentFund->status  = $request->status;
            $providentFund->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Provident Fund created successfully.' );
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

        $data = ProvidentFund::find( $id );

        return view( 'ProvidentFund::edit', compact( 'data' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {

        $validated = $request->validate( [
            'title' => 'required|unique:provident_funds,title,' . $id . '|max:255',
        ] );
        try {
            DB::beginTransaction();
            $providentFund          = ProvidentFund::find( $id );
            $providentFund->title   = $request->title;
            $providentFund->details = $request->details;
            $providentFund->status  = $request->status;
            $providentFund->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Provident Fund updated successfully.' );
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {

        $ProvidentFund = ProvidentFund::find( $id );
        $ProvidentFund->delete();
        return redirect()->back()->with( 'success', 'Provident Fund deleted successfully.' );
    }

    /**
     * Display a listing of the delete resource.
     */
    public function indexTrash() {

        $providentFunds = ProvidentFund::onlyTrashed()->get();
        return view( 'ProvidentFund::trash', compact( 'providentFunds' ) );
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore( string $id ) {
        $ProvidentFund = ProvidentFund::withTrashed()->find( $id );
        $ProvidentFund->restore();
        return redirect()->back()->with( 'success', 'Provident Fund  restored successfully.' );
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete( string $id ) {
        $ProvidentFund = ProvidentFund::withTrashed()->find( $id );
        $ProvidentFund->forceDelete();
        return redirect()->back()->with( 'success', 'Provident Fund  deleted permanently.' );
    }

    /**
     * Delete all selected from storage.
     */
    public function deleteAll() {
        ProvidentFund::onlyTrashed()->forceDelete();
        return redirect()->back()->with( 'success', 'All Provident Fund deleted permanently.' );
    }
}
