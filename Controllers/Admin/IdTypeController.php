<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\IdType;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IdTypeController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $idTypes = IdType::select( 'id', 'name', 'status' )->get();

        $view = 'IdType::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'IdType::index', compact( 'idTypes' ) );
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
            'name' => 'required|unique:id_types|max:255',
        ] );

        try {
            DB::beginTransaction();
            $idType          = new IdType();
            $idType->auth_id = auth()->user()->id;
            $idType->name    = $request->name;
            $idType->status  = $request->status;
            $idType->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Id type created successfully.' );
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

        $data = IdType::find( $id );
        $view = 'IdType::edit';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'IdType::edit', compact( 'data' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {

        $validated = $request->validate( [
            'name' => 'required|unique:id_types,name,' . $id . '|max:255',
        ] );
        try {
            DB::beginTransaction();
            $idType         = IdType::find( $id );
            $idType->name   = $request->name;
            $idType->status = $request->status;
            $idType->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'Id type updated successfully.' );
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {

        $relationship = IdType::find( $id );
        $relationship->delete();
        return redirect()->back()->with( 'success', 'Id type deleted successfully.' );
    }

    /**
     * Display a listing of the delete resource.
     */
    public function indexTrash() {

        $idTypes = IdType::onlyTrashed()->get();
        $view    = 'IdType::trash';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'IdType::trash', compact( 'idTypes' ) );
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore( string $id ) {
        $idType = IdType::withTrashed()->find( $id );
        $idType->restore();
        return redirect()->back()->with( 'success', 'ID Type restored successfully.' );
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete( string $id ) {
        $idType = IdType::withTrashed()->find( $id );
        $idType->forceDelete();
        return redirect()->back()->with( 'success', 'ID Type deleted permanently.' );
    }

    /**
     * Delete all selected from storage.
     */
    public function deleteAll() {
        IdType::onlyTrashed()->forceDelete();
        return redirect()->back()->with( 'success', 'All ID Type deleted permanently.' );
    }
}
