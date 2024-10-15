<form action="{{ route('work.table.update', $data->id) }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control form-control-sm"
                    value="{{ old('title', $data->title) }}" id="title" placeholder="Enter title" />
            </div>

            <div class="mb-3">
                <label for="dailyWorkingHours" class="form-label">Daily Working
                    Hours</label>
                <input type="number" min="1" max="24" step="0.5"
                    value="{{ old('daily_working_hours', $data->daily_working_hours) }}" name="daily_working_hours"
                    class="form-control form-control-sm" id="dailyWorkingHours"
                    placeholder="Enter daily working hours" />
            </div>

            <div class="mb-3">
                <label for="remark" class="form-label">Remark</label>
                <textarea class="form-control form-control-sm" name="remarks" id="remark" rows="3" placeholder="Enter remark">{{ old('remarks', $data->remarks) }}</textarea>
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
                        <select class="form-select form-select-sm" id="workingDayMonday" name="working_day[]">
                            <option value="full_day" @if ($data?->work_days[0]?->working_day == 'full_day') selected @endif>Full Day</option>
                            <option value="half_day" @if ($data?->work_days[0]?->working_day == 'half_day') selected @endif>Half Day</option>
                            <option value="non_working_day" @if ($data?->work_days[0]?->working_day == 'non_working_day') selected @endif>
                                Non-working Day
                            </option>
                        </select>
                    </td>
                    <td width="20%">
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="working_time_from[]"
                                value="{{ $data?->work_days[0]?->working_time_from }}" id="Monday_Working_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="working_time_to[]"
                                value="{{ $data?->work_days[0]?->working_time_to }}" id="Monday_Working_Time_To"
                                class="input time end ui-timepicker-input form-control form-control-sm"
                                autocomplete="off" />
                        </div>
                    </td>
                    <td width="20%">
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="break_time_from[]"
                                value="{{ $data?->work_days[0]?->break_time_from }}" id="Monday_Break_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="break_time_to[]"
                                value="{{ $data?->work_days[0]?->break_time_to }}" id="Monday_Break_Time_To"
                                class="input time end ui-timepicker-input form-control form-control-sm"
                                autocomplete="off" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Tuesday</td>
                    <td>
                        <select class="form-select form-select-sm" id="workingDayTuesday" name="working_day[]">
                            <option value="full_day" @if ($data?->work_days[1]?->working_day == 'full_day') selected @endif>Full Day</option>
                            <option value="half_day" @if ($data?->work_days[1]?->working_day == 'half_day') selected @endif>Half Day</option>
                            <option value="non_working_day" @if ($data?->work_days[1]?->working_day == 'non_working_day') selected @endif>
                                Non-working Day
                            </option>
                        </select>
                    </td>
                    <td>
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="working_time_from[]"
                                value="{{ $data?->work_days[1]?->working_time_from }}" id="Tuesday_Working_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="working_time_to[]"
                                value="{{ $data?->work_days[1]?->working_time_to }}" id="Tuesday_Working_Time_To"
                                class="input time end ui-timepicker-input form-control form-control-sm"
                                autocomplete="off" />
                        </div>
                    </td>
                    <td>
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="break_time_from[]"
                                value="{{ $data?->work_days[1]?->break_time_from }}" id="Tuesday_Break_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="break_time_to[]"
                                value="{{ $data?->work_days[1]?->break_time_to }}" id="Tuesday_Break_Time_To"
                                class="input time end ui-timepicker-input form-control form-control-sm"
                                autocomplete="off" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Wednesday</td>
                    <td>
                        <select class="form-select form-select-sm" id="workingDayWednesday" name="working_day[]">
                            <option value="full_day" @if ($data?->work_days[2]?->working_day == 'full_day') selected @endif>Full Day
                            </option>
                            <option value="half_day" @if ($data?->work_days[2]?->working_day == 'half_day') selected @endif>Half Day
                            </option>
                            <option value="non_working_day" @if ($data?->work_days[2]?->working_day == 'non_working_day') selected @endif>
                                Non-working Day
                            </option>
                        </select>
                    </td>
                    <td>
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="working_time_from[]"
                                value="{{ $data?->work_days[2]?->working_time_from }}"
                                id="Wednesday_Working_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="working_time_to[]"
                                value="{{ $data?->work_days[2]?->working_time_to }}" id="Wednesday_Working_Time_To"
                                class="input time end ui-timepicker-input form-control form-control-sm"
                                autocomplete="off" />
                        </div>
                    </td>
                    <td>
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="break_time_from[]"
                                value="{{ $data?->work_days[2]?->break_time_from }}" id="Wednesday_Break_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="break_time_to[]"
                                value="{{ $data?->work_days[2]?->break_time_to }}" id="Wednesday_Break_Time_To"
                                class="input time end ui-timepicker-input form-control form-control-sm"
                                autocomplete="off" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Thursday</td>
                    <td>
                        <select class="form-select form-select-sm" id="workingDayThursday" name="working_day[]">
                            <option value="full_day" @if ($data?->work_days[3]?->working_day == 'full_day') selected @endif>Full Day
                            </option>
                            <option value="half_day" @if ($data?->work_days[3]?->working_day == 'half_day') selected @endif>Half Day
                            </option>
                            <option value="non_working_day" @if ($data?->work_days[3]?->working_day == 'non_working_day') selected @endif>
                                Non-working Day
                            </option>
                        </select>
                    </td>
                    <td>
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="working_time_from[]"
                                value="{{ $data?->work_days[3]?->working_time_from }}"
                                id="Thursday_Working_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="working_time_to[]"
                                value="{{ $data?->work_days[3]?->working_time_to }}" id="Thursday_Working_Time_To"
                                class="input time end ui-timepicker-input form-control form-control-sm"
                                autocomplete="off" />
                        </div>
                    </td>
                    <td>
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="break_time_from[]"
                                value="{{ $data?->work_days[3]?->break_time_from }}" id="Thursday_Break_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="break_time_to[]"
                                value="{{ $data?->work_days[3]?->break_time_to }}" id="Thursday_Break_Time_To"
                                class="input time end ui-timepicker-input form-control form-control-sm"
                                autocomplete="off" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Friday</td>
                    <td>
                        <select class="form-select form-select-sm" id="workingDayFriday" name="working_day[]">
                            <option value="full_day" @if ($data?->work_days[4]?->working_day == 'full_day') selected @endif>Full Day
                            </option>
                            <option value="half_day" @if ($data?->work_days[4]?->working_day == 'half_day') selected @endif>Half Day
                            </option>
                            <option value="non_working_day" @if ($data?->work_days[4]?->working_day == 'non_working_day') selected @endif>
                                Non-working Day
                            </option>
                        </select>
                    </td>
                    <td>
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="working_time_from[]"
                                value="{{ $data?->work_days[4]?->working_time_from }}" id="Friday_Working_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="working_time_to[]"
                                value="{{ $data?->work_days[4]?->working_time_to }}" id="Friday_Working_Time_To"
                                class="input time end ui-timepicker-input form-control form-control-sm"
                                autocomplete="off" />
                        </div>
                    </td>
                    <td>
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="break_time_from[]"
                                value="{{ $data?->work_days[4]?->break_time_from }}" id="Friday_Break_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="break_time_to[]"
                                value="{{ $data?->work_days[4]?->break_time_to }}" id="Friday_Break_Time_To"
                                class="input time end ui-timepicker-input form-control form-control-sm"
                                autocomplete="off" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Saturday</td>
                    <td>
                        <select class="form-select form-select-sm" id="workingDaySaturday" name="working_day[]">
                            <option value="full_day" @if ($data?->work_days[5]?->working_day == 'full_day') selected @endif>Full Day
                            </option>
                            <option value="half_day" @if ($data?->work_days[5]?->working_day == 'half_day') selected @endif>Half Day
                            </option>
                            <option value="non_working_day" @if ($data?->work_days[5]?->working_day == 'non_working_day') selected @endif>
                                Non-working Day
                            </option>
                        </select>
                    </td>
                    <td>
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="working_time_from[]"
                                value="{{ $data?->work_days[5]?->working_time_from }}"
                                id="Saturday_Working_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="working_time_to[]"
                                value="{{ $data?->work_days[5]?->working_time_to }}" id="Saturday_Working_Time_To"
                                class="input time end ui-timepicker-input form-control form-control-sm"
                                autocomplete="off" />
                        </div>
                    </td>
                    <td>
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="break_time_from[]"
                                value="{{ $data?->work_days[5]?->break_time_from }}" id="Saturday_Break_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="break_time_to[]"
                                value="{{ $data?->work_days[5]?->break_time_to }}" id="Saturday_Break_Time_To"
                                class="input time end ui-timepicker-input form-control form-control-sm"
                                autocomplete="off" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Sunday</td>
                    <td>
                        <select class="form-select form-select-sm" id="workingDaySunday" name="working_day[]">
                            <option value="full_day" @if ($data?->work_days[6]?->working_day == 'full_day') selected @endif>Full Day
                            </option>
                            <option value="half_day" @if ($data?->work_days[6]?->working_day == 'half_day') selected @endif>Half Day
                            </option>
                            <option value="non_working_day" @if ($data?->work_days[6]?->working_day == 'non_working_day') selected @endif>
                                Non-working Day
                            </option>
                        </select>
                    </td>
                    <td>
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="working_time_from[]"
                                value="{{ $data?->work_days[6]?->working_time_from }}" id="Sunday_Working_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="working_time_to[]"
                                value="{{ $data?->work_days[6]?->working_time_to }}" id="Sunday_Working_Time_To"
                                class="input time end ui-timepicker-input form-control form-control-sm"
                                autocomplete="off" />
                        </div>
                    </td>
                    <td>
                        <div class="datepair d-flex gap-2">
                            <input type="text" name="break_time_from[]"
                                value="{{ $data?->work_days[6]?->break_time_from }}"id="Sunday_Break_Time_From"
                                class="input time start ui-timepicker-input valid form-control form-control-sm"
                                autocomplete="off" />
                            to
                            <input type="text" name="break_time_to[]"
                                value="{{ $data?->work_days[6]?->break_time_to }}" id="Sunday_Break_Time_To"
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
            <table class="table table-bordered">
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
            </table>
        </div>

    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

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
