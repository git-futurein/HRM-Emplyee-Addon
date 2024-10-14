<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\Relationship;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelationshipController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $relationships = Relationship::select( 'id', 'name', 'status' )->get();
        return view( 'Relationship::index', compact( 'relationships' ) );
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
            'name' => 'required|unique:relationships|max:255',
        ] );

        try {
            DB::beginTransaction();
            $relationship          = new Relationship();
            $relationship->auth_id = auth()->user()->id;
            $relationship->name    = $request->name;
            $relationship->status  = $request->status;
            $relationship->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Relationship created successfully.' );
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

        $data = Relationship::find( $id );
        return view( 'Relationship::edit', compact( 'data' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {

        $validated = $request->validate( [
            'name' => 'required|unique:relationships,name,' . $id . '|max:255',
        ] );
        try {
            DB::beginTransaction();
            $relationship         = Relationship::find( $id );
            $relationship->name   = $request->name;
            $relationship->status = $request->status;
            $relationship->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Relationship updated successfully.' );
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {

        $relationship = Relationship::find( $id );
        $relationship->delete();
        return redirect()->back()->with( 'success', 'Relationship deleted successfully.' );
    }

    /**
     * Display a listing of the delete resource.
     */
    public function indexTrash() {

        $relationships = Relationship::onlyTrashed()->get();
        return view( 'Relationship::trash', compact( 'relationships' ) );
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore( string $id ) {
        $relationship = Relationship::withTrashed()->find( $id );
        $relationship->restore();
        return redirect()->back()->with( 'success', 'Relationship restored successfully.' );
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete( string $id ) {
        $relationship = Relationship::withTrashed()->find( $id );
        $relationship->forceDelete();
        return redirect()->back()->with( 'success', 'Relationship deleted permanently.' );
    }

    /**
     * Delete all selected from storage.
     */
    public function deleteAll() {
        Relationship::onlyTrashed()->forceDelete();
        return redirect()->back()->with( 'success', 'All Relationship deleted permanently.' );
    }
}
