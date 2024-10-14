<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\JobCategory;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobCategoryController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $job_categories = JobCategory::select( 'id', 'title', 'status', 'remarks' )->get();

        $view = 'JobCategory::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'JobCategory::index', compact( 'job_categories' ) );
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
            'title' => 'required|unique:job_categories|max:255',
        ] );

        try {
            DB::beginTransaction();
            $job_category          = new JobCategory();
            $job_category->auth_id = auth()->user()->id;
            $job_category->title   = $request->title;
            $job_category->slug    = Str::slug( $request->title );
            $job_category->status  = $request->status;
            $job_category->remarks = $request->remarks;
            $job_category->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'job category created successfully.' );
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

        $data = JobCategory::find( $id );

        $view = 'JobCategory::index';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'JobCategory::edit', compact( 'data' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, string $id ) {

        $validated = $request->validate( [
            'title' => 'required|unique:job_categories,title,' . $id . '|max:255',
        ] );
        try {
            DB::beginTransaction();
            $job_category          = JobCategory::find( $id );
            $job_category->title   = $request->title;
            $job_category->slug    = Str::slug( $request->title );
            $job_category->status  = $request->status;
            $job_category->remarks = $request->remarks;
            $job_category->save();
            DB::commit();
            return redirect()->back()->with( 'success', 'job category updated successfully.' );
        } catch ( Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {

        $job_category = JobCategory::find( $id );
        $job_category->delete();
        return redirect()->back()->with( 'success', 'Job category deleted successfully.' );
    }

    /**
     * Display a listing of the delete resource.
     */
    public function indexTrash() {

        $job_categories = JobCategory::onlyTrashed()->get();

        $view = 'JobCategory::trash';
        if ( !view()->exists( $view ) ) {
            return view( 'errors.404' );
        } else {
            return view( 'JobCategory::trash', compact( 'job_categories' ) );
        }
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore( string $id ) {
        $job_category = JobCategory::withTrashed()->find( $id );
        $job_category->restore();
        return redirect()->back()->with( 'success', 'Job category restored successfully.' );
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete( string $id ) {
        $job_category = JobCategory::withTrashed()->find( $id );
        $job_category->forceDelete();
        return redirect()->back()->with( 'success', 'Job category deleted permanently.' );
    }

    /**
     * Delete all selected from storage.
     */
    public function deleteAll() {
        JobCategory::onlyTrashed()->forceDelete();
        return redirect()->back()->with( 'success', 'All Job category deleted permanently.' );
    }
}
