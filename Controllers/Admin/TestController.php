<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            DB::beginTransaction();

            // Your logic here

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error( 'Failed to update user details', ['error' => $e->getMessage()] );
            return redirect()->back()->with( 'error', 'Oh ! Something went wrong !' );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            
            DB::beginTransaction();

            // Your logic here

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error( 'Failed to update user details', ['error' => $e->getMessage()] );
            return redirect()->back()->with( 'error', 'Oh ! Something went wrong !' );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            
            DB::beginTransaction();

            // Your logic here

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error( 'Failed to update user details', ['error' => $e->getMessage()] );
            return redirect()->back()->with( 'error', 'Oh ! Something went wrong !' );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            
            DB::beginTransaction();

            // Your logic here

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error( 'Failed to update user details', ['error' => $e->getMessage()] );
            return redirect()->back()->with( 'error', 'Oh ! Something went wrong !' );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            
            DB::beginTransaction();

            // Your logic here

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error( 'Failed to update user details', ['error' => $e->getMessage()] );
            return redirect()->back()->with( 'error', 'Oh ! Something went wrong !' );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            
            DB::beginTransaction();

            // Your logic here

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error( 'Failed to update user details', ['error' => $e->getMessage()] );
            return redirect()->back()->with( 'error', 'Oh ! Something went wrong !' );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            
            DB::beginTransaction();

            // Your logic here

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error( 'Failed to update user details', ['error' => $e->getMessage()] );
            return redirect()->back()->with( 'error', 'Oh ! Something went wrong !' );
        }
    }
}
