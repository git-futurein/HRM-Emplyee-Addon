@extends('layouts.app')
@section('title', '| Employee Import')
@section('header', 'Employee Import')
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
                                    <li class="breadcrumb-item " aria-current="page"><a
                                            href="{{ route('employee.index') }}">Employee</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Employee Import</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class=" mb-3 col-lg-6 d-flex justify-content-end">
                        <div class="form-group ms-1">
                            <a href="{{ route('employee.import.sample') }}" class="btn btn-sm btn-info">
                                <i class="fas fa-download"></i> Download Sample File
                            </a>
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
                                <h5 class="card-title">Employee Import </h5>
                            </div>

                            <div class="row gy-4">
                                <form action="{{ route('employee.import.data') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class=" mb-3 col-lg-6">
                                            <div class="form-group">
                                                <input class="form-control form-control-sm" required type="file"
                                                    name="file" />
                                            </div>
                                        </div>
                                        <div class=" mb-3 col-lg-2">
                                            <div class="form-group ms-1">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-file-import"></i> Import
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    @push('js')
    @endpush
@endsection
