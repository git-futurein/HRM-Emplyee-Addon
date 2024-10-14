@extends('layouts.app')
@section('title', '| Job Type')
@section('header', 'Job Type')
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
                                    <li class="breadcrumb-item active" aria-current="page">Job Type</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('job.type.trash') }}" class="btn btn-danger btn-sm me-2"> <i
                                        class="far fa-trash-alt"></i> Trash</a>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                    class="btn btn-sm btn-base">
                                    Add Job Type
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
                                        <th>Job Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($job_types as $key => $job_type)
                                        <tr>
                                            <td width="5%">{{ $key + 1 }}</td>
                                            <td>{{ $job_type->name }}</td>
                                            <td width="15%">
                                                <span
                                                    class="badge rounded-pill @if ($job_type->status == 'active') text-bg-success @else text-bg-danger @endif ">{{ $job_type->status }}</span>
                                            </td>
                                            <td width="10%">
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-outline-base btn-sm edit"
                                                        data-id="{{ $job_type->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#editModal">
                                                        <i class="far fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('job.type.destroy', $job_type->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" id="delete"
                                                            class="btn btn-outline-danger btn-sm delete">
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
                                            Add Designation
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('job.type.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="input1" class="form-label">Job Type</label>
                                                <input type="text" name="name" class="form-control" id="input1"
                                                    placeholder="Job Type Name" required />
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
                                            Edit JOb Type
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
                $.get("{{ url('admin/job-type/edit') }}/" + id,
                    function(data) {
                        $('#edit_section').html(data);
                    })
            });
        </script>
    @endpush
@endsection
