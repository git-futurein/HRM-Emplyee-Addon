<form id="editDocument" action="{{ route('employee.document.update', $data->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="mb-3">
                    <label for="input1" class="form-label">Title
                    </label>
                    <input type="text" name="d_title" value="{{ old('d_title', $data->d_title) }}"
                        class="form-control" id="input1" placeholder="type..." required />
                </div>
                <div class="mb-3">
                    <label for="input2" class="form-label">
                        Category
                    </label>
                    <select name="d_category" class="form-control form-select" id="id_type" required>
                        <option selected value="">Select</option>
                        <option value="1" @if (old('d_category', $data->d_category) == 1) selected @endif>1</option>
                        <option value="2" @if (old('d_category', $data->d_category) == 2) selected @endif>2</option>
                        <option value="3" @if (old('d_category', $data->d_category) == 3) selected @endif>3</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="input3" class="form-label">Start Date
                    </label>
                    <input class="datepicker-edit-here form-control" placeholder="Select" name="d_start_date"
                        data-range="false" data-multiple-dates-separator=" - " data-language="en"
                        data-format="dd-mm-yyyy" readonly data-position="bottom left" autocomplete="off"
                        value="{{ old('d_start_date', $data->d_start_date) }}" required />
                </div>
                <div class="mb-3">
                    <label for="input4" class="form-label">End Date
                    </label>
                    <input class="datepicker-edit-here form-control" placeholder="Select" name="d_end_date"
                        data-range="false" data-multiple-dates-separator=" - " data-language="en"
                        data-format="dd-mm-yyyy" readonly data-position="bottom left" autocomplete="off"
                        value="{{ old('d_end_date', $data->d_end_date) }}" required />
                </div>

                <div class="mb-3">
                    <label for="input5" class="form-label">Expiry Date
                    </label>
                    <input class="datepicker-edit-here form-control" placeholder="Select" name="d_expiry_date"
                        data-range="false" readonly data-multiple-dates-separator=" - " data-language="en"
                        data-format="dd-mm-yyyy" data-position="bottom left" autocomplete="off"
                        value="{{ old('d_expiry_date', $data->d_expiry_date) }}" required />
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">File No
                            </label>
                            <input class="form-control" name="d_file" type="file" id="formFile" />
                        </div>
                    </div>

                    <div class="col-lg-4">
                        @if ($data->d_file)
                            <div class="mb-3 text-center">
                                <label for="formFile" class="form-label">Old File</label>
                                <br>
                                <img src="{{ asset('backend/assets/img/file.png') }}" alt="file" width="50"
                                    height="70">
                                <br>
                                <small>.{{ pathinfo($data->d_file, PATHINFO_EXTENSION) }}</small>
                            </div>
                        @endif
                    </div>

                </div>

                <div class="mb-3">
                    <label for="input7" class="form-label">
                        Remark</label>
                    <textarea class="form-control" name="d_remark" placeholder="type" id="floatingTextarea2">{{ old('d_remark', $data->d_remark) }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>


<script>
    // Edit Document

    $(document).ready(function() {
        $('#editDocument').submit(function(e) {
            e.preventDefault();

            var url = $(this).attr('action');
            var formData = new FormData(this); // Use FormData to handle file input

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false, // Important for file upload
                processData: false, // Important for file upload
                success: function(data) {
                    $("#editDocument")[0].reset();
                    $("#documentEditModal").modal('hide');
                    showToast(data, "success", 3000);
                    loadDocumentTableData();
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    swal.fire({
                        title: "Error!",
                        text: "An error occurred while uploading the file.",
                        icon: "error",
                        timer: 1000,
                        buttons: false
                    });
                }
            });
        });

        loadDocumentTableData();
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
