<thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Gender</th>
        <th>Relationship</th>
        <th>Home Telephone</th>
        <th>Mobile</th>
        <th>Work Telephone</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
</thead>

<tbody>

    @forelse ($contacts as $key => $contact)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $contact->c_name }}</td>
            <td>{{ $contact->c_gender }}</td>
            <td>{{ $contact->c_relationship_id }}</td>
            <td>{{ $contact->c_home_telephone }}</td>
            <td>{{ $contact->c_mobile }}</td>
            <td>{{ $contact->c_work_telephone }}</td>
            <td>{{ $contact->c_email }}</td>
            <td>
                <div class="d-flex gap-1">
                    <button class="btn btn-outline-base btn-sm c_edit_btn" data-bs-toggle="modal"
                        data-id="{{ $contact->id }}" data-bs-target="#contactEditModal">
                        <i class="far fa-edit"></i>
                    </button>

                    <button type="button" data-id="{{ $contact->id }}" class="btn btn-outline-danger btn-sm delete-btn">
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

        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            var url = '{{ route('employee.contact.destroy', '') }}' + '/' + id;

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
                            loadContactTableData();
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
