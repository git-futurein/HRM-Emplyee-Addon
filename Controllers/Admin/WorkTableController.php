<?php

namespace Addons\Employee\Controllers\Admin;

use Addons\Employee\Models\WorkDaysTable;
use Addons\Employee\Models\WorkTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkTableController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $workTabls    = WorkTable::with( 'work_days' )->get();
        $calendarData = $this->generateCalendarData();
        return view( 'WorkTable::index', compact( 'workTabls', 'calendarData' ) );
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
        try {
            DB::beginTransaction();

            // Insert into the main work table
            $workTable                      = new WorkTable();
            $workTable->auth_id             = auth()->user()->id;
            $workTable->title               = $request->title;
            $workTable->daily_working_hours = $request->daily_working_hours;
            $workTable->remarks             = $request->remarks;
            $workTable->save();

            // Days of the week array
            $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            foreach ( $daysOfWeek as $key => $day ) {
                // Check if working time from, to, and break times are provided and valid
                $working_time_from = $request->working_time_from[$key] ?? null;
                $working_time_to   = $request->working_time_to[$key] ?? null;
                $break_time_from   = $request->break_time_from[$key] ?? null;
                $break_time_to     = $request->break_time_to[$key] ?? null;

                // Parse and format time if provided, otherwise set to null
                $working_time_from = $working_time_from ? Carbon::createFromFormat( 'g:ia', $working_time_from )->format( 'H:i:s' ) : null;
                $working_time_to   = $working_time_to ? Carbon::createFromFormat( 'g:ia', $working_time_to )->format( 'H:i:s' ) : null;
                $break_time_from   = $break_time_from ? Carbon::createFromFormat( 'g:ia', $break_time_from )->format( 'H:i:s' ) : null;
                $break_time_to     = $break_time_to ? Carbon::createFromFormat( 'g:ia', $break_time_to )->format( 'H:i:s' ) : null;

                // Insert into the work days table
                $workTableDay                    = new WorkDaysTable();
                $workTableDay->work_table_id     = $workTable->id;
                $workTableDay->day_of_week       = $day;
                $workTableDay->working_day       = $request->working_day[$key];
                $workTableDay->working_time_from = $working_time_from;
                $workTableDay->working_time_to   = $working_time_to;
                $workTableDay->break_time_from   = $break_time_from;
                $workTableDay->break_time_to     = $break_time_to;
                $workTableDay->save();
            }

            DB::commit();
            return redirect()->back()->with( 'success', 'Work table created successfully.' );
        } catch ( \Exception $e ) {
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

        $data = WorkTable::with( 'work_days' )->find( $id );

        return view( 'WorkTable::edit', compact( 'data' ) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, $id ) {
        try {
            DB::beginTransaction();

            // Find the work table by ID
            $workTable                      = WorkTable::findOrFail( $id );
            $workTable->title               = $request->title;
            $workTable->daily_working_hours = $request->daily_working_hours;
            $workTable->remarks             = $request->remarks;
            $workTable->save();

            // Days of the week array
            $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            foreach ( $daysOfWeek as $key => $day ) {
                // Check if the work day entry exists for this day
                $workTableDay = WorkDaysTable::where( 'work_table_id', $workTable->id )
                    ->where( 'day_of_week', $day )
                    ->first();

                // If it doesn't exist, create a new entry
                if ( !$workTableDay ) {
                    $workTableDay                = new WorkDaysTable();
                    $workTableDay->work_table_id = $workTable->id;
                    $workTableDay->day_of_week   = $day;
                }

                // Update fields
                $working_time_from = $request->working_time_from[$key] ?? null;
                $working_time_to   = $request->working_time_to[$key] ?? null;
                $break_time_from   = $request->break_time_from[$key] ?? null;
                $break_time_to     = $request->break_time_to[$key] ?? null;

                // Parse and format time if provided, otherwise set to null
                $workTableDay->working_time_from = $working_time_from ? Carbon::createFromFormat( 'g:ia', $working_time_from )->format( 'H:i:s' ) : null;
                $workTableDay->working_time_to   = $working_time_to ? Carbon::createFromFormat( 'g:ia', $working_time_to )->format( 'H:i:s' ) : null;
                $workTableDay->break_time_from   = $break_time_from ? Carbon::createFromFormat( 'g:ia', $break_time_from )->format( 'H:i:s' ) : null;
                $workTableDay->break_time_to     = $break_time_to ? Carbon::createFromFormat( 'g:ia', $break_time_to )->format( 'H:i:s' ) : null;

                // Save the work day entry
                $workTableDay->working_day = $request->working_day[$key];
                $workTableDay->save();
            }

            DB::commit();
            return redirect()->back()->with( 'success', 'Work table updated successfully.' );
        } catch ( \Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( string $id ) {

        try {
            DB::beginTransaction();
            $workTable = WorkTable::find( $id );
            $workTable->delete();

            WorkDaysTable::where( 'work_table_id', $id )->delete();
            DB::commit();
            return redirect()->route( 'WorkTable::index' )->with( 'success', 'Work table deleted successfully!' );
        } catch ( \Exception $e ) {
            DB::rollBack();
            return redirect()->back()->with( 'error', $e->getMessage() );
        }

    }

    /**
     * Display a listing of the delete resource.
     */
    public function indexTrash() {

        $workTables = WorkTable::onlyTrashed()->get();
        return view( 'WorkTable::trash', compact( 'workTables' ) );
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore( string $id ) {
        $workTable = WorkTable::withTrashed()->find( $id );
        $workTable->restore();

        foreach ( $workTable->work_days()->withTrashed()->get() as $child ) {
            $child->restore();
        }

        return redirect()->back()->with( 'success', 'Work table restored successfully.' );
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete( string $id ) {
        $workTable = WorkTable::withTrashed()->find( $id );
        $workTable->forceDelete();
        return redirect()->back()->with( 'success', 'Work table deleted permanently.' );
    }

    /**
     * Delete all selected from storage.
     */
    public function deleteAll() {
        WorkTable::onlyTrashed()->forceDelete();
        return redirect()->back()->with( 'success', 'All Work table deleted permanently.' );
    }

    public function generateCalendarData() {
        $calendarData = [];

        // Get current year, previous year, and next year
        $currentYear = Carbon::now()->year;
        $years       = [$currentYear - 1, $currentYear, $currentYear + 1];

        // Define non-working days (customize these as needed)
        $nonWorkingDays = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // Loop through each year
        foreach ( $years as $year ) {
            $monthsData = [];

            // Loop through each month in the year
            for ( $month = 1; $month <= 12; $month++ ) {
                $daysInMonth = Carbon::create( $year, $month )->daysInMonth;

                // Initialize counters for each day of the week
                $dayCounts = [
                    'Monday'    => 0,
                    'Tuesday'   => 0,
                    'Wednesday' => 0,
                    'Thursday'  => 0,
                    'Friday'    => 0,
                    'Saturday'  => 0,
                    'Sunday'    => 0,
                ];

                // Loop through each day in the month
                for ( $day = 1; $day <= $daysInMonth; $day++ ) {
                    $date      = Carbon::create( $year, $month, $day );
                    $dayOfWeek = $date->format( 'l' ); // Get day name (e.g., Monday, Sunday)

                    // Increment count for the day of the week
                    $dayCounts[$dayOfWeek]++;
                }

                // Calculate working days by excluding non-working days
                $workingDays = array_sum( $dayCounts ) - ( $dayCounts[$nonWorkingDays[0]] + $dayCounts[$nonWorkingDays[1]] );

                // Add month data to the year's data
                $monthsData[] = [
                    'month'       => Carbon::create( $year, $month )->format( 'F' ),
                    'year'        => $year,
                    'dayCounts'   => $dayCounts,
                    'workingDays' => $workingDays,
                ];
            }

            // Add year data to the calendar data
            $calendarData[$year] = $monthsData;
        }

        return $calendarData;
    }
}
