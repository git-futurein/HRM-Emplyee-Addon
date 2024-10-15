@extends('layouts.app')
@section('title', '| Department')
@section('header', 'Department')
@section('content')
    @push('css')
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
                                    <li class="breadcrumb-item active" aria-current="page">Departments</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('department.trash') }}" class="btn btn-danger btn-sm me-2"> <i
                                        class="far fa-trash-alt"></i> Trash</a>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    class="btn btn-base btn-sm">
                                    Add Department
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
                                        <th class="text-danger">Department Name</th>
                                        <th>Status</th>
                                        <th>Deactive</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($departments as $key => $department)
                                        <tr>
                                            <td width="3%">{{ $key + 1 }}</td>
                                            <td>{{ $department->name }}</td>
                                            <td width="15%">
                                                <span
                                                    class="badge rounded-pill @if ($department->status == 'active') text-bg-success @else text-bg-danger @endif ">{{ $department->status }}</span>
                                            </td>
                                            <td width="15%">
                                                <span
                                                    class="badge rounded-pill @if ($department->status == 'active') text-bg-success @else text-bg-danger @endif ">{{ $department->status }}</span>
                                            </td>
                                            <td width="10%">
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-outline-base btn-sm edit"
                                                        data-id="{{ $department->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#editModal">
                                                        <i class="far fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('department.destroy', $department->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm delete">
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
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                            Add Department
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('department.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="input1" class="form-label">Department Name</label>
                                                <input type="text" name="name" class="form-control" id="input1"
                                                    placeholder="Department Name" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="input2" class="form-label">Status</label>
                                                <select name="status" class="form-control" id="input2" required>
                                                    <option value="active"> Active </option>
                                                    <option value="inactive"> Inactive </option>
                                                </select>
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

                        <!--Create Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">
                                            Edit Department
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
            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.get("{{ url('admin/department/edit') }}/" + id,
                    function(data) {
                        $('#edit_section').html(data);
                    })
            });
        </script>
    @endpush
@endsection
