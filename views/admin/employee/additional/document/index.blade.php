<thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Category</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Expire Date</th>
        <th>File</th>
        <th>Comment</th>
        <th>Action</th>
    </tr>
</thead>

<tbody>

    @foreach ($documents as $key => $document)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $document->d_title }}</td>
            <td>-</td>
            <td>{{ $document->d_start_date }}</td>
            <td>{{ $document->d_end_date }}</td>
            <td>{{ $document->d_expiry_date }}</td>
            <td>
                <a href="{{ asset($document->d_file) }}"
                    download="{{ basename($document->d_file) }}">{{ basename($document->d_file) }}</a>

            </td>
            <td>{{ $document->d_remark }}</td>

            <td>
                <div class="d-flex gap-1">
                    <button class="btn btn-outline-base btn-sm d_edit_btn" data-bs-toggle="modal"
                        data-id="{{ $document->id }}" data-bs-target="#documentEditModal">
                        <i class="far fa-edit"></i>
                    </button>

                    <button type="button" data-id="{{ $document->id }}"
                        class="btn btn-outline-danger btn-sm delete-btn">
                        <i class="far fa-trash-alt"></i>
                    </button>

                </div>
            </td>
        </tr>
    @endforeach
</tbody>

<script type="text/javascript">
    // Delete Confirmation
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            var url = '{{ route('employee.document.destroy', '') }}' + '/' + id;

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
                                "success", 3000);

                            loadDocumentTableData();
                        },
                        error: function(xhr) {
                            // Handle errors
                            showToast("Done! Your item has been deleted!", "error",
                                3000)
                        }
                    });
                }
            });
        });
    });
</script>
