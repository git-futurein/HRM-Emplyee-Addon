@extends('layouts.app')
@section('title', '| Work Table')
@section('header', 'Work Table')
@section('content')
    @push('css')
        <style>
            .non-working-day {
                background-color: red;
                color: white;
            }

            .today {
                background-color: #007bff;
                /* Highlight color for today */
                color: white;
            }
        </style>
    @endpush
    <div class="dd-content">

        <!-- Breadcrumb Start Here -->
        <section class="breadcrumb-section m-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="breadcrumb-wrapper">
                            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                                aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Work Table</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('work.table.trash') }}" class="btn btn-danger btn-sm me-2"> <i
                                        class="far fa-trash-alt"></i> Trash</a>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    class="btn btn-sm btn-base">
                                    Add Work Table
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb End Here -->

        <section class="employee-section mb-4">
            <div class="container-fluid">
                <!-- employee short info -->
                <div class="row gy-4 mb-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tile</th>
                                        <th>Daily Working Hours</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($workTabls as $key => $work)
                                        <tr>
                                            <td width="5%">{{ $key + 1 }}</td>
                                            <td width="30%">{{ $work->title }}</td>
                                            <td width="15%">{{ $work->daily_working_hours }}</td>
                                            <td width="30%">{{ $work->remarks }}</td>
                                            <td width="10%">
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-outline-base btn-sm edit"
                                                        data-id="{{ $work->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#editModal">
                                                        <i class="far fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('work.table.destroy', $work->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" id="delete"
                                                            class="btn btn-outline-danger btn-sm delete">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse

                                </tbody>
                            </table>
                        </div>

                        <!--Create Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xxl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                            Add Work Table
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">

                                            <form action="{{ route('work.table.store') }}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <div class="mb-3">
                                                            <label for="title" class="form-label">Title</label>
                                                            <input type="text" name="title"
                                                                class="form-control form-control-sm"
                                                                value="{{ old('title') }}" id="title"
                                                                placeholder="Enter title" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="dailyWorkingHours" class="form-label">Daily Working
                                                                Hours</label>
                                                            <input type="number" min="1" max="24"
                                                                step="0.5" value="{{ old('daily_working_hours') }}"
                                                                name="daily_working_hours"
                                                                class="form-control form-control-sm" id="dailyWorkingHours"
                                                                placeholder="Enter daily working hours" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="remark" class="form-label">Remark</label>
                                                            <textarea class="form-control form-control-sm" name="remarks" id="remark" rows="3" placeholder="Enter remark">{{ old('remarks') }}</textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="table-container mb-3">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Day of Week</th>
                                                                <th>Working Day</th>
                                                                <th>Working Time</th>
                                                                <th>Break Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td width="10%">Monday</td>
                                                                <td width="40%">
                                                                    <select class="form-select form-select-sm"
                                                                        id="workingDayMonday" name="working_day[]">
                                                                        <option value="full_day">Full Day</option>
                                                                        <option value="half_day">Half Day</option>
                                                                        <option value="non_working_day">Non-working Day
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td width="20%">
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="working_time_from[]"
                                                                            id="Monday_Working_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="working_time_to[]"
                                                                            id="Monday_Working_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                                <td width="20%">
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="break_time_from[]"
                                                                            id="Monday_Break_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="break_time_to[]"
                                                                            id="Monday_Break_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tuesday</td>
                                                                <td>
                                                                    <select class="form-select form-select-sm"
                                                                        id="workingDayTuesday" name="working_day[]">
                                                                        <option value="full_day">Full Day</option>
                                                                        <option value="half_day">Half Day</option>
                                                                        <option value="non_working_day">Non-working Day
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="working_time_from[]"
                                                                            id="Tuesday_Working_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="working_time_to[]"
                                                                            id="Tuesday_Working_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="break_time_from[]"
                                                                            id="Tuesday_Break_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="break_time_to[]"
                                                                            id="Tuesday_Break_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Wednesday</td>
                                                                <td>
                                                                    <select class="form-select form-select-sm"
                                                                        id="workingDayWednesday" name="working_day[]">
                                                                        <option value="full_day">Full Day</option>
                                                                        <option value="half_day">Half Day</option>
                                                                        <option value="non_working_day">Non-working Day
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="working_time_from[]"
                                                                            id="Wednesday_Working_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="working_time_to[]"
                                                                            id="Wednesday_Working_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="break_time_from[]"
                                                                            id="Wednesday_Break_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="break_time_to[]"
                                                                            id="Wednesday_Break_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Thursday</td>
                                                                <td>
                                                                    <select class="form-select form-select-sm"
                                                                        id="workingDayThursday" name="working_day[]">
                                                                        <option value="full_day">Full Day</option>
                                                                        <option value="half_day">Half Day</option>
                                                                        <option value="non_working_day">Non-working Day
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="working_time_from[]"
                                                                            id="Thursday_Working_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="working_time_to[]"
                                                                            id="Thursday_Working_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="break_time_from[]"
                                                                            id="Thursday_Break_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="break_time_to[]"
                                                                            id="Thursday_Break_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Friday</td>
                                                                <td>
                                                                    <select class="form-select form-select-sm"
                                                                        id="workingDayFriday" name="working_day[]">
                                                                        <option value="full_day">Full Day</option>
                                                                        <option value="half_day">Half Day</option>
                                                                        <option value="non_working_day">Non-working Day
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="working_time_from[]"
                                                                            id="Friday_Working_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="working_time_to[]"
                                                                            id="Friday_Working_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="break_time_from[]"
                                                                            id="Friday_Break_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="break_time_to[]"
                                                                            id="Friday_Break_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Saturday</td>
                                                                <td>
                                                                    <select class="form-select form-select-sm"
                                                                        id="workingDaySaturday" name="working_day[]">
                                                                        <option value="full_day">Full Day</option>
                                                                        <option value="half_day">Half Day</option>
                                                                        <option value="non_working_day">Non-working Day
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="working_time_from[]"
                                                                            id="Saturday_Working_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="working_time_to[]"
                                                                            id="Saturday_Working_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="break_time_from[]"
                                                                            id="Saturday_Break_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="break_time_to[]"
                                                                            id="Saturday_Break_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Sunday</td>
                                                                <td>
                                                                    <select class="form-select form-select-sm"
                                                                        id="workingDaySunday" name="working_day[]">
                                                                        <option value="full_day">Full Day</option>
                                                                        <option value="half_day">Half Day</option>
                                                                        <option value="non_working_day">Non-working Day
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="working_time_from[]"
                                                                            id="Sunday_Working_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="working_time_to[]"
                                                                            id="Sunday_Working_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="datepair d-flex gap-2">
                                                                        <input type="text" name="break_time_from[]"
                                                                            id="Sunday_Break_Time_From"
                                                                            class="input time start ui-timepicker-input valid form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                        to
                                                                        <input type="text" name="break_time_to[]"
                                                                            id="Sunday_Break_Time_To"
                                                                            class="input time end ui-timepicker-input form-control form-control-sm"
                                                                            autocomplete="off" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="table-container mt-3 table-responsive">
                                                    <div class="table-container mt-3 table-responsive">
                                                        {{-- <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Month</th>
                                                                    <th colspan="8">2023</th>
                                                                    <th colspan="8">2024</th>
                                                                    <th colspan="8">2025</th>
                                                                </tr>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>Mon</th>
                                                                    <th>Tue</th>
                                                                    <th>Wed</th>
                                                                    <th>Thu</th>
                                                                    <th>Fri</th>
                                                                    <th>Sat</th>
                                                                    <th>Sun</th>
                                                                    <th>Working Day</th>
                                                                    <th>Mon</th>
                                                                    <th>Tue</th>
                                                                    <th>Wed</th>
                                                                    <th>Thu</th>
                                                                    <th>Fri</th>
                                                                    <th>Sat</th>
                                                                    <th>Sun</th>
                                                                    <th>Working Day</th>
                                                                    <th>Mon</th>
                                                                    <th>Tue</th>
                                                                    <th>Wed</th>
                                                                    <th>Thu</th>
                                                                    <th>Fri</th>
                                                                    <th>Sat</th>
                                                                    <th>Sun</th>
                                                                    <th>Working Day</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>January</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>22</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>22</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>23</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>February</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>20</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>21</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>20</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>March</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>23</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>23</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>21</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>April</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>20</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>21</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>20</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>May</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>6</td>
                                                                    <td>23</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>6</td>
                                                                    <td>22</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>6</td>
                                                                    <td>23</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>June</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>20</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>21</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>20</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>July</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>23</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>22</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>23</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>August</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>22</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>22</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>22</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>September</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>21</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>21</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>21</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>October</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>22</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>21</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>22</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>November</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>20</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>21</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>20</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>December</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>23</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>22</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>4</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>5</td>
                                                                    <td>23</td>
                                                                </tr>
                                                                <tr class="total-row">
                                                                    <td>Total</td>
                                                                    <td colspan="8">262</td>
                                                                    <td colspan="8">262</td>
                                                                    <td colspan="8">261</td>
                                                                </tr>
                                                            </tbody>
                                                        </table> --}}

                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Month</th>
                                                                    @foreach ($calendarData as $year => $months)
                                                                        <th colspan="8" class="text-center">
                                                                            {{ $year }}</th>
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <th></th>
                                                                    @foreach ($calendarData as $year => $months)
                                                                        <th>Mon</th>
                                                                        <th>Tue</th>
                                                                        <th>Wed</th>
                                                                        <th>Thu</th>
                                                                        <th>Fri</th>
                                                                        <th>Sat</th>
                                                                        <th class="text-danger">Sun</th>
                                                                        <th>Working Day</th>
                                                                    @endforeach
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @for ($i = 0; $i < 12; $i++)
                                                                    <tr>
                                                                        <td>{{ $calendarData[array_key_first($calendarData)][$i]['month'] }}
                                                                        </td>
                                                                        @foreach ($calendarData as $year => $months)
                                                                            <td>{{ $months[$i]['dayCounts']['Monday'] }}
                                                                            </td>
                                                                            <td>{{ $months[$i]['dayCounts']['Tuesday'] }}
                                                                            </td>
                                                                            <td>{{ $months[$i]['dayCounts']['Wednesday'] }}
                                                                            </td>
                                                                            <td>{{ $months[$i]['dayCounts']['Thursday'] }}
                                                                            </td>
                                                                            <td>{{ $months[$i]['dayCounts']['Friday'] }}
                                                                            </td>
                                                                            <td>{{ $months[$i]['dayCounts']['Saturday'] }}
                                                                            </td>
                                                                            <td class="text-danger">
                                                                                {{ $months[$i]['dayCounts']['Sunday'] }}
                                                                            </td>
                                                                            <td class="text-primary">
                                                                                {{ $months[$i]['workingDays'] }}</td>
                                                                        @endforeach
                                                                    </tr>
                                                                @endfor
                                                                <!-- Total Row -->
                                                                <tr>
                                                                    <td>Total</td>
                                                                    @foreach ($calendarData as $year => $months)
                                                                        @php
                                                                            $totalWorkingDays = array_sum(
                                                                                array_column($months, 'workingDays'),
                                                                            );
                                                                        @endphp
                                                                        <td colspan="7"></td>
                                                                        <td class="text-primary">{{ $totalWorkingDays }}
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>

                                                <div class="mt-3">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Modal -->

                        <!--Create Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xxl">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">
                                            Edit Leave Type
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" id="edit_section">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Modal -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('js')
        <script>
            $(document).ready(function(e) {
                // initialize input widgets first
                $(".time").timepicker({
                    showDuration: true,
                    timeFormat: "g:ia",
                    step: 15,
                });
                $(".datepair").datepair();
            });
        </script>

        <script>
            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.get("{{ url('admin/work-table/edit') }}/" + id,
                    function(data) {
                        $('#edit_section').html(data);
                    })
            });
        </script>
    @endpush
@endsection
