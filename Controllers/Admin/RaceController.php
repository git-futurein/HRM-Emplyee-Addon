<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\Race;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RaceController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $races = Race::select( 'id', 'name', 'status' )->get();
        return view( 'Race::index', compact( 'races' ) );
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
            'name' => 'required|unique:races|max:255',
        ] );

        try {
            DB::beginTransaction();
            $race          = new Race();
            $race->auth_id = auth()->user()->id;
            $race->name    = $request->name;
            $race->status  = $request->status;
            $race->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Race created successfully.' );
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

        $data = Race::find( $id );
        return view( 'Race::edit', compact( 'data' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {

        $validated = $request->validate( [
            'name' => 'required|unique:races,name,' . $id . '|max:255',
        ] );
        try {
            DB::beginTransaction();
            $race         = Race::find( $id );
            $race->name   = $request->name;
            $race->status = $request->status;
            $race->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Race updated successfully.' );
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {

        $race = Race::find( $id );
        $race->delete();
        return redirect()->back()->with( 'success', 'Race deleted successfully.' );
    }

    /**
     * Display a listing of the delete resource.
     */
    public function indexTrash() {

        $races = Race::onlyTrashed()->get();
        return view( 'Race::trash', compact( 'races' ) );
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore( string $id ) {
        $race = Race::withTrashed()->find( $id );
        $race->restore();
        return redirect()->back()->with( 'success', 'Race restored successfully.' );
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete( string $id ) {
        $race = Race::withTrashed()->find( $id );
        $race->forceDelete();
        return redirect()->back()->with( 'success', 'Race deleted permanently.' );
    }

    /**
     * Delete all selected from storage.
     */
    public function deleteAll() {
        Race::onlyTrashed()->forceDelete();
        return redirect()->back()->with( 'success', 'All Race deleted permanently.' );
    }
}
