@extends('layouts.app')
@section('title', '| Employee Trash')
@section('header', 'Employee Trash')
@section('content')
    @push('css')
    @endpush
    <div class="dd-content">
        <!-- Breadcrumb Start Here -->
        <section class="breadcrumb-section m-0">
            <div class="container-fluid">
                <div class="row">
                    {{-- <div class="col-lg-3">
                        <div class="breadcrumb-wrapper">
                            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                                aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Employee</li>
                                </ol>
                            </nav>
                        </div>
                    </div> --}}

                    <div class="col-lg-6">
                        <form action="{{ route('employee.index') }}" method="GET">
                            <div class="row">
                                <div class=" mb-3 col-lg-9">
                                    <div class="form-group">
                                        <input class="form-control form-control-sm" type="text" name="search"
                                            placeholder="search" value="{{ request()->get('search') }}" />
                                    </div>
                                </div>
                                <div class=" mb-3 col-lg-1">
                                    <div class="form-group ms-1">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class=" mb-3 col-lg-2">
                                    <div class="form-group ms-1">
                                        <a href="{{ route('employee.index') }}" class="btn btn-sm btn-outline-primary">
                                            Clear
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-6">
                        <div class="">
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" id="deleteAllBtn" disabled class="btn  btn-sm btn-danger">
                                    <i class="far fa-trash-alt"></i> Delete All
                                </button>

                                <a href="{{ route('employee.index') }}" class="btn btn-sm btn-base ms-1"> <i
                                        class="fas fa-undo"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
        </section>
        <!-- Breadcrumb End Here -->



        <section class="employee-section mb-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header mb-4">
                                <h5 class="card-title">Employee trash List</h5>
                                <div class="d-flex justify-content-end">
                                    <label for="checkAll" class="me-2">Check All</label>
                                    <input type="checkbox" id="checkAll">
                                </div>
                            </div>

                            <div class="row gy-4">
                                @forelse ($employees as $employee)
                                    <div class="col-xxl-3 col-xl-4">
                                        <div class="card addons-card border">
                                            <div
                                                class="title-wrap d-flex justify-content-start align-items-start gap-3 mb-4">
                                                <form id="deleteAllForm" action="{{ route('employee.delete.all') }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="checkbox" name="id[]" value="{{ $employee->id }}">
                                                </form>
                                                <div
                                                    class="icon-wrap d-flex flex-shrink-0 justify-content-center align-items-center">
                                                    <i class="fa-solid fa-user"></i>
                                                    {{-- <img src="{{ asset($employee?->user?->image) }}" alt="image"> --}}
                                                </div>
                                                <ul class="user-info d-flex flex-column gap-1">
                                                    <li>
                                                        <h6 class="title mb-1">{{ $employee?->name }}</h6>
                                                    </li>
                                                    <li class="d-flex gap-2">
                                                        <i class="fa-solid fa-briefcase"></i>
                                                        <p>{{ $employee?->department?->name }}</p>
                                                    </li>
                                                    <li class="d-flex gap-2">
                                                        <i class="fa-solid fa-user-tag"></i>
                                                        <p>{{ $employee?->designation?->name }}</p>
                                                    </li>
                                                    <li class="d-flex gap-2">
                                                        <i class="fa-regular fa-id-badge"></i>
                                                        <p>{{ $employee?->employee_id }}</p>
                                                    </li>
                                                    <li class="d-flex gap-2">
                                                        <i class="fa-solid fa-phone"></i>
                                                        <p>{{ $employee?->phone }}</p>
                                                    </li>
                                                    <li class="d-flex gap-2">
                                                        <i class="fa-solid fa-envelope"></i>
                                                        <p>{{ $employee?->email }}</p>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div
                                                class="btn-wrap d-flex flex-wrap justify-content-start align-items-center gap-2">
                                                <form action="{{ route('employee.restore', $employee->id) }}"
                                                    method="get">
                                                    <button class="btn btn-outline-base btn-sm" type="submit"
                                                        id="restoreBtn">
                                                        <i class="fas fa-trash-restore"></i> Restore
                                                    </button>
                                                </form>
                                                <form action="{{ route('employee.forceDelete', $employee->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm delete">
                                                        <i class="far fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-lg-12">
                                        <div class="card"></div>
                                        <div class="card-body">
                                            <p class="text-center">No Data Found</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    @push('js')
        <script>
            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.get("{{ url('admin/department/edit') }}/" + id,
                    function(data) {
                        $('#edit_section').html(data);
                    })
            });
        </script>


        <script>
            // $("#checkAll").click(function() {
            //     $('input:checkbox').not(this).prop('checked', this.checked);
            // });

            $(document).ready(function() {
                const $deleteAllBtn = $('#deleteAllBtn');
                const $checkboxes = $('input[name="id[]"]');
                const $checkAll = $('#checkAll');

                // Function to update the delete button state
                function updateDeleteButtonState() {
                    $deleteAllBtn.prop('disabled', !$checkboxes.is(':checked'));
                }

                // Event listener for individual checkboxes
                $checkboxes.change(function() {
                    updateDeleteButtonState();
                });

                // Event listener for the "Check All" checkbox
                $checkAll.change(function() {
                    $checkboxes.prop('checked', this.checked);
                    updateDeleteButtonState();
                });

                // Initial state check
                updateDeleteButtonState();
            });


            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });


            $(document).on('click', '#deleteAllBtn', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#deleteAllForm').submit();
                    }
                })
            });

            $(document).on('click', '#restoreBtn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will restore the selected item.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, restore it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        </script>
    @endpush
@endsection
