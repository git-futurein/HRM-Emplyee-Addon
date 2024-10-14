@extends('layouts.app')
@section('title', '| Leave Table')
@section('header', 'Leave Table')
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
                                    <li class="breadcrumb-item active" aria-current="page">Leave Table</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('leave.table.trash') }}" class="btn btn-danger btn-sm me-2"> <i
                                        class="far fa-trash-alt"></i> Trash</a>
                                <a href="{{ route('leave.table.create') }}" class="btn btn-sm btn-info">
                                    Add Leave Table
                                </a>
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
                                        <th>Tile</th>
                                        <th>Description</th>
                                        <th>Records</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($leaveTables as $key => $leavetable)
                                        <tr>
                                            <td width="5%">{{ $key + 1 }}</td>
                                            <td>{{ $leavetable->title }}</td>
                                            <td width="15%">{{ $leavetable->description }}</td>
                                            <td>{{ $leavetable->leave_table_details_count }}</td>
                                            <td width="10%">
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('leave.table.edit', $leavetable->id) }}"
                                                        class="btn btn-outline-base btn-sm edit">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('leave.table.destroy', $leavetable->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button Table="submit" id="delete"
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
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('js')
        <script>
            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.get("{{ url('admin/leave/edit') }}/" + id,
                    function(data) {
                        $('#edit_section').html(data);
                    })
            });
        </script>
    @endpush
@endsection
