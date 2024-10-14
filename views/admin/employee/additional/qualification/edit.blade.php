<form id="editQualification" action="{{ route('employee.qualification.update', $data->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="mb-3">
                    <label for="input1" class="form-label">Name of institution
                    </label>
                    <input type="text" name="q_institution" class="form-control" id="input1"
                        value="{{ old('q_institution', $data->q_institution) }}" placeholder="Name of institution"
                        required />
                </div>

                <div class="mb-3">
                    <label for="input1" class="form-label">Level/Score
                    </label>
                    <input type="text" name="q_level" class="form-control" id="input1" placeholder="Level/Score"
                        value="{{ old('q_level', $data->q_level) }}" required />
                </div>

                <div class="mb-3">
                    <label for="input1" class="form-label">Type
                    </label>
                    <input type="text" name="q_type" class="form-control" id="input1" placeholder="Type"
                        value="{{ old('q_type', $data->q_type) }}" required />
                </div>

                <div class="mb-3">
                    <label for="input3" class="form-label">Start Date
                    </label>
                    <input class="datepicker-edit-here form-control" placeholder="Select" name="q_start_date"
                        data-range="false" readonly data-multiple-dates-separator=" - " data-language="en"
                        data-format="dd-mm-yyyy" data-position="bottom left" autocomplete="off"
                        value="{{ old('q_start_date', $data->q_start_date) }}" required />
                </div>

                <div class="mb-3">
                    <label for="input3" class="form-label">End Date
                    </label>
                    <input class="datepicker-edit-here form-control" placeholder="Select" name="q_end_date"
                        data-range="false" readonly data-multiple-dates-separator=" - " data-language="en"
                        data-format="dd-mm-yyyy" data-position="bottom left" autocomplete="off"
                        value="{{ old('q_end_date', $data->q_end_date) }}" required />
                </div>

                <div class="mb-3">
                    <label for="input3" class="form-label">Expire Date
                    </label>
                    <input class="datepicker-edit-here form-control" placeholder="Select" name="q_expire_date"
                        data-range="false" readonly data-multiple-dates-separator=" - " data-language="en"
                        data-format="dd-mm-yyyy" data-position="bottom left" autocomplete="off"
                        value="{{ old('q_expire_date', $data->q_expire_date) }}" required />
                </div>

                <div class="mb-3">
                    <label for="input3" class="form-label">Comment
                    </label>
                    <textarea type="text" name="q_comment" id="input1" class="form-control" required placeholder="Comment">{{ old('q_comment', $data->q_comment) }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-base">Update</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Edit Confirmation

        $('#editQualification').submit(function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var request = $(this).serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: request,
                success: function(data) {
                    $("#editQualification")[0].reset();
                    $("#qualificationEditModal").modal('hide');
                    showToast("Done! Your item has been updated!",
                        "success", 3000)
                    loadQualificationTableData()

                }
            });
        });

        loadQualificationTableData()
    });


    (function($) {
        "use strict";
        $(".datepicker-edit-here").datepicker();

        $(".timepicker-edit-here").datepicker({
            onlyTimepicker: true, // Enable time picker only
            timeFormat: "hh:ii aa", // Format for the time
            autoClose: true, // Close after selecting time
        });
    })(jQuery);
</script>
