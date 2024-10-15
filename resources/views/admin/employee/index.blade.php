@extends('layouts.app')
@section('title', '| Employee')
@section('header', 'Employee')
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
                        <form action="{{ route('employee.index') }}" method="GET" id="searchForm">
                            <div class="row">
                                <div class=" mb-3 col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control form-control-sm" type="text" name="search"
                                            placeholder="search" value="{{ request()->get('search') }}" />
                                    </div>
                                </div>
                                <div class=" mb-3 col-lg-3">
                                    <div class="form-group">
                                        <select class="form-select form-control-sm" id="department" type="text"
                                            name="department">
                                            <option value="">All Department</option>
                                            @foreach ($departmentFilter as $department)
                                                <option value="{{ $department->slug }}"
                                                    {{ request()->get('department') == $department->slug ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
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

                                <a href="{{ route('employee.trash') }}" class="btn btn-danger btn-sm"> <i
                                        class="far fa-trash-alt"></i> Trash</a>

                                <a href="{{ route('employee.create') }}" class="btn  btn-sm btn-base ms-1">
                                    Add Empolyee
                                </a>

                                <a href="{{ route('employee.export') }}" class="btn btn-sm btn-info ms-1">
                                    Export Employee
                                </a>

                                <a href="" class="btn btn-sm btn-primary ms-1">
                                    Send Login Credentials
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
                                <h5 class="card-title">Employee List</h5>
                            </div>

                            <div class="row gy-4">
                                @forelse ($departments as $key => $department)
                                    <h5>{{ $department->name }} ({{ $department->employees->count() }})</h5>
                                    @foreach ($department->employees as $employee)
                                        <div class="col-xxl-3 col-xl-4">
                                            <div class="card addons-card border">
                                                <div
                                                    class="title-wrap d-flex justify-content-start align-items-start gap-3 mb-4">
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
                                                    <a href="{{ route('employee.edit', $employee->id) }}"
                                                        class="btn btn-outline-base btn-sm">
                                                        Edit
                                                    </a>
                                                    <button class="btn btn-outline-primary btn-sm">
                                                        View Payslips
                                                    </button>
                                                    <button class="btn btn-outline-primary btn-sm">
                                                        Permissions
                                                    </button>
                                                    <button class="btn btn-outline-warning btn-sm changePassword"
                                                        data-bs-toggle="modal" data-bs-target="#changePasswordModal"
                                                        data-employee_id={{ $employee->employee_id }} id="changePassword">
                                                        Change Password
                                                    </button>
                                                    <button class="btn btn-outline-warning btn-sm changeEmail"
                                                        data-bs-toggle="modal" data-bs-target="#changeEmailModal"
                                                        data-employee_id={{ $employee->employee_id }}
                                                        data-email="{{ $employee->email }}" id="changeEmail">
                                                        Change Email
                                                    </button>
                                                    <form action="{{ route('employee.destroy', $employee->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-outline-danger btn-sm delete" id="delete">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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

    <!--Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Change Password
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="mb-2 form--label text--white">New Password</label>
                            <span class="text-danger">*</span>
                            <div class="input--group position-relative">
                                <input class="form-control" id="password" placeholder="New Password" type="password"
                                    name="password" autocomplete="current-password" required>
                                <div class="password-show-hide fas toggle-password-change text--white fa-eye-slash"
                                    data-target="password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2 form--label text--white">Confirm Password</label>
                            <span class="text-danger">*</span>
                            <div class="input--group position-relative">
                                <input class="form-control " id="confirm_password" placeholder="Passwords"
                                    type="password" name="password_confirmation" autocomplete="current-password"
                                    required>
                                <div class="password-show-hide fas toggle-password-change text--white fa-eye-slash"
                                    data-target="confirm_password">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- / Modal -->

    <!--Change Email Modal -->
    <div class="modal fade" id="changeEmailModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Change Email
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="mb-2 form--label text--white">Old Email</label>
                            <div class="input--group position-relative">
                                <input class="form-control" id="oldEmail" type="email"required disabled>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="mb-2 form--label text--white">New Email</label>
                            <span class="text-danger">*</span>
                            <div class="input--group position-relative">
                                <input class="form-control" value="{{ old('newEmail') }}" placeholder="New Email"
                                    type="email" name="newEmail"required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- / Modal -->

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
            // Handle Change Password Modal
            $(document).on('click', '.changePassword', function() {
                let employee_id = $(this).data('employee_id');

                // Update the form action with the employee_id for Change Password
                let passwordFormAction = "{{ route('employee.change.password', ':id') }}";
                passwordFormAction = passwordFormAction.replace(':id', employee_id);
                $('#changePasswordModal form').attr('action', passwordFormAction);
            });

            // Handle Change Password Modal
            $(document).on('click', '.changeEmail', function() {
                let employee_id = $(this).data('employee_id');
                let oldEmail = $(this).data('email');

                // Populate old email in the modal
                $('#oldEmail').val(oldEmail);

                // Update the form action with the correct route and employee ID
                let emailFormAction = "{{ route('employee.change.email', ':id') }}";
                emailFormAction = emailFormAction.replace(':id', employee_id);
                $('#changeEmailModal form').attr('action', emailFormAction);
            });

            $(document).ready(function() {
                $('#department').on('change', function() {
                    $('#searchForm').submit(); // Submit the form
                });
            });
        </script>
    @endpush
@endsection
