<form id="editContact" action="{{ route('employee.contact.update', $data->id) }}" method="POST">
    @csrf
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="mb-3">
                    <label for="input1" class="form-label">Name
                    </label>
                    <input type="text" name="c_name" value="{{ old('c_name', $data->c_name) }}" class="form-control"
                        id="input1" placeholder="type..." required />
                </div>

                <div class="mb-3">
                    <label for="input2" class="form-label">
                        Gender
                    </label>
                    <select name="c_gender" class="form-control form-select" id="c_gender" required>
                        <option selected value="">Select</option>
                        <option value="male" @if (old('c_gender', $data->c_gender) == 'male') selected @endif>Male</option>
                        <option value="female" @if (old('c_gender', $data->c_gender) == 'female') selected @endif>Female</option>
                        <option value="others" @if (old('c_gender', $data->c_gender) == 'others') selected @endif>Others</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="input2" class="form-label">
                        Relationship
                    </label>
                    <select name="c_relationship_id" class="form-control form-select" id="c_relationship_id" required>
                        <option selected value="">Select</option>
                        @foreach ($relationships as $relationship)
                            <option value="{{ $relationship->id }}" @if (old('c_relationship_id', $data->c_relationship_id) == $relationship->id) selected @endif>
                                {{ $relationship->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="input3" class="form-label">Home Telephone
                    </label>
                    <input type="text" name="c_home_telephone"
                        value="{{ old('c_home_telephone', $data->c_home_telephone) }}" id="input1"
                        class="form-control" required placeholder="Home Telephone"
                        oninput="this.value=this.value.replace(/[^0-9 ]/g,'');" />
                </div>

                <div class="mb-3">
                    <label for="input3" class="form-label">Mobile
                    </label>
                    <input type="text" name="c_mobile" value="{{ old('c_mobile', $data->c_mobile) }}" id="input1"
                        class="form-control" required placeholder="Mobile"
                        oninput="this.value=this.value.replace(/[^0-9 ]/g,'');" />
                </div>

                <div class="mb-3">
                    <label for="input3" class="form-label">Work Telephone
                    </label>
                    <input type="text" name="c_work_telephone"
                        value="{{ old('c_work_telephone', $data->c_work_telephone) }}" id="input1"
                        class="form-control" required placeholder="Work Telephone"
                        oninput="this.value=this.value.replace(/[^0-9 ]/g,'');" />
                </div>

                <div class="mb-3">
                    <label for="input3" class="form-label">Email
                    </label>
                    <input type="email" name="c_email" value="{{ old('c_email', $data->c_email) }}" id="input1"
                        class="form-control" required placeholder="Email" />
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-base">Submit</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Edit Confirmation

        $('#editContact').submit(function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var request = $(this).serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: request,
                success: function(data) {
                    $("#editContact")[0].reset();
                    $("#contactEditModal").modal('hide');
                    showToast(data, "success", 3000);
                    loadContactTableData()

                }
            });
        });

        loadContactTableData()
    });
</script>
