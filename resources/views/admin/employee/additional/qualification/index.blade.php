<thead>
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Level/Score</th>
        <th>Type</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Expire Date</th>
        <th>Comment</th>
        <th>Action</th>
    </tr>
</thead>

<tbody>
    @forelse($qualifications as $key => $qualification)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $qualification->q_institution }}</td>
            <td>{{ $qualification->q_level }}</td>
            <td>{{ $qualification->q_type }}</td>
            <td>{{ $qualification->q_start_date }}</td>
            <td>{{ $qualification->q_end_date }}</td>
            <td>{{ $qualification->q_expire_date }}</td>
            <td>{{ $qualification->q_comment }}</td>
            <td>
                <div class="d-flex gap-1">
                    <button class="btn btn-outline-base btn-sm q_edit_btn" data-bs-toggle="modal"
                        data-id="{{ $qualification->id }}" data-bs-target="#qualificationEditModal">
                        <i class="far fa-edit"></i>
                    </button>

                    <button type="button" data-id="{{ $qualification->id }}"
                        class="btn btn-outline-danger btn-sm delete-btn-qualification">
                        <i class="far fa-trash-alt"></i>
                    </button>

                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td class="text-center" colspan="9">No Data Found
            </td>
        </tr>
    @endforelse
</tbody>

<script type="text/javascript">
    // Delete Confirmation
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.delete-btn-qualification').click(function() {
            var id = $(this).data('id');
            var url = '{{ route('employee.qualification.destroy', '') }}' + '/' + id;
            // Show a confirmation dialog
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(data) {

                            showToast("Done! Your item has been deleted!",
                                "success", 3000)
                            loadQualificationTableData();
                        },
                        error: function(xhr) {
                            // Handle errors
                            showToast("Error! Something went wrong!", "error",
                                3000)
                        }
                    });
                }
            });
        });
    });
</script>
