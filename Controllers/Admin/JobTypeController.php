<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\JobType;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobTypeController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $job_types = JobType::select( 'id', 'name', 'status' )->get();

        $view = 'JobType::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'JobType::index', compact( 'job_types' ) );
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
            'name' => 'required|unique:job_types|max:255',
        ] );

        try {
            DB::beginTransaction();
            $job_type          = new JobType();
            $job_type->auth_id = auth()->user()->id;
            $job_type->name    = $request->name;
            $job_type->slug    = Str::slug( $request->name );
            $job_type->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'job type created successfully.' );
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

        $data = JobType::find( $id );

        $view = 'JobType::edit';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'JobType::edit', compact( 'data' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {

        $validated = $request->validate( [
            'name' => 'required|unique:job_types,name,' . $id . '|max:255',
        ] );
        try {
            DB::beginTransaction();
            $job_type         = JobType::find( $id );
            $job_type->name   = $request->name;
            $job_type->slug   = Str::slug( $request->name );
            $job_type->status = $request->status;
            $job_type->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'job type updated successfully.' );
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {

        $job_type = JobType::find( $id );
        $job_type->delete();
        return redirect()->back()->with( 'success', 'Job type deleted successfully.' );
    }

    /**
     * Display a listing of the delete resource.
     */
    public function indexTrash() {

        $job_types = JobType::onlyTrashed()->get();

        $view = 'JobType::trash';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'JobType::trash', compact( 'job_types' ) );
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore( string $id ) {
        $job_type = JobType::withTrashed()->find( $id );
        $job_type->restore();
        return redirect()->back()->with( 'success', 'Job type restored successfully.' );
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete( string $id ) {
        $job_type = JobType::withTrashed()->find( $id );
        $job_type->forceDelete();
        return redirect()->back()->with( 'success', 'Job type deleted permanently.' );
    }

    /**
     * Delete all selected from storage.
     */
    public function deleteAll() {
        JobType::onlyTrashed()->forceDelete();
        return redirect()->back()->with( 'success', 'All Job type deleted permanently.' );
    }
}
