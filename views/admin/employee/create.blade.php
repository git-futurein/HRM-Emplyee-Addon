@extends('layouts.app')
@section('title', '| Employee')
@section('header', 'Employee')
@section('content')
    @push('css')
        <link rel="stylesheet" href="https://unpkg.com/sweetalert/dist/sweetalert.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
            .position-relative {
                position: relative;
            }

            .position-absolute {
                position: absolute;
            }
        </style>
    @endpush
    <div class="dd-content">
        <!-- Breadcrumb Start Here -->
        <section class="breadcrumb-section m-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="breadcrumb-wrapper">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">
                                    <a href="{{ url('/home') }}" class="breadcrumb-link">Home</a>
                                </li>
                                <li class="breadcrumb-icon">
                                    <i class="fa-solid fa-slash"></i>
                                </li>
                                <li class="breadcrumb-item">
                                    <span class="breadcrumb-item-text">Create Employee</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex justify-content-end mb-3">
                            <div class="">
                                <a href="{{ route('employee.index') }}" class="btn btn-base">
                                    All Employee
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb End Here -->

        <!-- Employee List -->
        <section class="employee-section mb-4">
            <div class="container-fluid">

                {{-- Password copy --}}
                @if (session()->has('success'))
                    <div class="alert alert-light d-flex justify-content-between align-items-center" role="alert">
                        <div class="title--wrap flex-grow-1 text-center">
                            <p id="email"><strong>Email : <span id="emailText">{{ session('email') }}</span></strong>
                            </p>
                            <p id="password"><strong>Password : <span
                                        id="passwordText">{{ session('password') }}</span></strong></p>
                        </div>
                        <button id="copyButton" class="btn btn-primary btn-sm ml-2">Copy</button>
                    </div>
                @endif
                {{-- End Password copy --}}


                <!-- employee short info -->
                <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-lg-5">
                            <div class="card">
                                <div class="d-flex justify-content-center mb-3">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTtuphMb4mq-EcVWhMVT8FCkv5dqZGgvn_QiA&s"
                                        class="rounded-circle border border-secondary-subtle w-0" width="110"
                                        height="110" alt="image" id="imagePreview">
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control form-control-sm" id="name" placeholder="Name" required />
                                </div>
                                <div class="mb-3">
                                    <label for="employee_id" class="form-label">Employee ID</label>
                                    <input type="number" name="employee_id" value="{{ employee_unid() }}"
                                        class="form-control form-control-sm" id="employee_id" placeholder="Employee ID"
                                        required />
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="id_number" class="form-label">Identification Number</label>
                                    <input type="password" name="id_number" value="{{ old('id_number') }}"
                                        class="form-control form-control-sm" id="id_number" placeholder="ID Number"
                                        required />
                                    <span id="togglePassword" class="position-absolute"
                                        style="right: 10px; top: 50%; transform: translateY(10%); cursor: pointer;">
                                        <i class="fa fa-eye"></i>
                                        <!-- Bootstrap Icons, you might need to include the Bootstrap Icons library -->
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <label for="id_type_id" class="form-label">ID Type</label>
                                    <select class="form-select form-control-sm" name="id_type_id"
                                        aria-label="Default select example" id="id_type_id" required>
                                        <option selected disabled value="">Select ID Type</option>
                                        @foreach ($idTypes as $idType)
                                            <option
                                                value="{{ $idType->id }}"@if (old('id_type_id') == $idType->id) selected @endif>
                                                {{ $idType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="dob" class="form-label">DOB</label>
                                    <input class="datepicker-here form-control form-control-sm" placeholder="Date Of Birth"
                                        name="dob" data-range="false" data-multiple-dates="false" id="dob"
                                        value="{{ old('dob') }}" readonly data-multiple-dates-separator=" - "
                                        data-language="en" data-format="dd-mm-yyyy" data-position="bottom left"
                                        autocomplete="off" required />

                                    {{-- <input class="datepicker-here form-control form-control-sm" placeholder="Date Of Birth"
                                        
                                        name="dob" data-range="false" data-multiple-dates="false" id="dob"
                                        value="{{ old('dob') }}" data-multiple-dates-separator=" - "
                                        autocomplete="off" data-language="en" data-format="dd-mm-yyyy"
                                        data-position="bottom left" 
                                        required /> --}}
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select form-control-sm" name="gender"
                                        aria-label="Default select example" id="gender" required>
                                        <option selected>Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="others" {{ old('gender') == 'others' ? 'selected' : '' }}>Others
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Race</label>

                                    <select class="form-select form-control-sm" name="race_id"
                                        aria-label="Default select example">
                                        <option selected disabled value="">Select race</option>
                                        @foreach ($races as $race)
                                            <option value="{{ $race->id }}"
                                                {{ old('race_id') == $race->id ? 'selected' : '' }}>{{ $race->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="card">
                                <div class="row mb-5">
                                    <div class="col-lg-4">
                                        <a href="">
                                            <div class=" p-2 bg-secondary-subtle text-center rounded">
                                                <i class="fas fa-money-check fs-3 text-primary"></i>
                                                <br>
                                                <small>Payslip (0)</small>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-lg-4">
                                        <a href="">
                                            <div class=" p-2 bg-secondary-subtle text-center rounded">
                                                <i class="fas fa-money-check fs-3 text-primary"></i>
                                                <p>Leave Application (0)</p>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-lg-4">
                                        <a href="">
                                            <div class=" p-2 bg-secondary-subtle text-center rounded">
                                                <i class="fas fa-money-check fs-3 text-primary"></i>
                                                <p>Overtime Records (0)</p>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-lg-4 mt-2">
                                        <a href="">
                                            <div class=" p-2 bg-secondary-subtle text-center rounded">
                                                <i class="fas fa-money-check fs-3 text-primary"></i>
                                                <p>Claim (0)</p>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-lg-4 mt-2">
                                        <a href="">
                                            <div class=" p-2 bg-secondary-subtle text-center rounded">
                                                <i class="fas fa-money-check fs-3 text-primary"></i>
                                                <p>Loan (0)</p>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-lg-4 mt-2">
                                        <a href="">
                                            <div class=" p-2 bg-secondary-subtle text-center rounded">
                                                <i class="fas fa-money-check fs-3 text-primary"></i>
                                                <p>Warning (0)</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Image</label>
                                    <input type="file" name="image" eccept=".jpg, .jpeg, .png"
                                        class="form-control form-control-sm" id="image" placeholder="Image" />
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Mobile</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        class="form-control form-control-sm" id="phone" placeholder="Mobile"
                                        required />
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control form-control-sm" id="email" placeholder="Email"
                                        required />
                                </div>
                                <div class="mb-3">
                                    <label for="optional_email" class="form-label">Optional Email</label>
                                    <input type="email" name="optional_email" value="{{ old('optional_email') }}"
                                        class="form-control form-control-sm" id="optional_email" placeholder="Email" />
                                </div>

                                <div class="form--check mb-4">
                                    <input class="form-check-input me-2" type="checkbox" name="autopassword"
                                        id="autopassword" value="1" />
                                    <label class="form-check-label" for="autopassword">Auto Generate Password</label>
                                </div>

                                <div class="password--wrap">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="text" name="password" class="form-control form-control-sm"
                                            id="password" placeholder="Password" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Re-Password</label>
                                        <input type="text" name="password_confirmation"
                                            class="form-control form-control-sm" id="password_confirmation"
                                            placeholder="Re-Password" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- employee details -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <!-- tabs -->
                                <div class="tab-pane fade active show" id="buy" role="tabpanel"
                                    aria-labelledby="buy-tab">
                                    <ul class="nav nav-tabs custom--tabs justify-content-start mb-3" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="btn btn-sm active" id="BTC-tab" data-bs-toggle="tab"
                                                data-bs-target="#BTC" type="button" role="tab"
                                                aria-selected="true">
                                                Info
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="btn btn-sm" id="USDT-tab" data-bs-toggle="tab"
                                                data-bs-target="#USDT" type="button" role="tab"
                                                aria-selected="false" tabindex="-1">
                                                Setting
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="btn btn-sm" id="XRP-tab" data-bs-toggle="tab"
                                                data-bs-target="#XRP" type="button" role="tab"
                                                aria-selected="false" tabindex="-1">
                                                Salary
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="btn btn-sm" id="DOGE-tab" data-bs-toggle="tab"
                                                data-bs-target="#DOGE" type="button" role="tab"
                                                aria-selected="false" tabindex="-1">
                                                Employment
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="btn btn-sm" id="Nuna-tab" data-bs-toggle="tab"
                                                data-bs-target="#Nuna" type="button" role="tab"
                                                aria-selected="false" tabindex="-1">
                                                Qualification
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="btn btn-sm" id="LUNA-tab" data-bs-toggle="tab"
                                                data-bs-target="#LUNA" type="button" role="tab"
                                                aria-selected="false" tabindex="-1">
                                                Contact
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="btn btn-sm" id="LTC-tab" data-bs-toggle="tab"
                                                data-bs-target="#LTC" type="button" role="tab"
                                                aria-selected="false" tabindex="-1">
                                                Document
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane fade active show" id="BTC" role="tabpanel"
                                            aria-labelledby="BTC-tab">
                                            <div class="row mb-4">
                                                <div class="col-lg-6">
                                                    <div class="card">
                                                        <div class="mb-3">
                                                            <label for="address_type" class="form-label">Address
                                                                Type</label>

                                                            <select class="form-select form-control-sm"
                                                                name="address_type" aria-label="Default select example"
                                                                id="address_type">
                                                                <option selected value="" disabled>Select Address
                                                                    Type
                                                                </option>
                                                                <option value="Local residential address"
                                                                    {{ old('address_type') == 'Local residential address' ? 'selected' : '' }}>
                                                                    Local residential
                                                                    address</option>
                                                                <option value="Foreign address"
                                                                    {{ old('address_type') == 'Foreign address' ? 'selected' : '' }}>
                                                                    Foreign address</option>
                                                                <option value="Local C/O address"
                                                                    {{ old('address_type') == 'Local C/O address' ? 'selected' : '' }}>
                                                                    Local C/O address
                                                                </option>
                                                                <option value="Not Available"
                                                                    {{ old('address_type') == 'Not Available' ? 'selected' : '' }}>
                                                                    Not Available</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input2" class="form-label">House No</label>
                                                            <input type="text" name="house_no"
                                                                value="{{ old('house_no') }}"
                                                                class="form-control form-control-sm" id="input2"
                                                                placeholder="House No" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input3" class="form-label">Level No</label>
                                                            <input type="text" name="level_no"
                                                                value="{{ old('level_no') }}"
                                                                class="form-control form-control-sm" id="input3"
                                                                placeholder="Level No" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input4" class="form-label">Unit No</label>
                                                            <input type="text" name="unit_no"
                                                                value="{{ old('unit_no') }}"
                                                                class="form-control form-control-sm" id="input4"
                                                                placeholder="Unit No" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input5" class="form-label">Street</label>
                                                            <input type="text" name="street"
                                                                value="{{ old('street') }}"
                                                                class="form-control form-control-sm" id="input5"
                                                                placeholder="Street" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Address</label>
                                                            <textarea type="text" rows="2" name="address" class="form-control form-control-sm" id="address"
                                                                placeholder="Address" required>{{ old('address') }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input7" class="form-label">City</label>
                                                            <input type="text" name="city"
                                                                class="form-control form-control-sm"
                                                                value="{{ old('city') }}" id="input7"
                                                                placeholder="City" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="input7"
                                                                class="form-label">State/Province</label>
                                                            <input type="text" name="state"
                                                                class="form-control form-control-sm"
                                                                value="{{ old('state') }}" id="input7"
                                                                placeholder="State" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="input7" class="form-label">Zip/Postal
                                                                Code</label>
                                                            <input type="text" name="zip_code"
                                                                class="form-control form-control-sm"
                                                                value="{{ old('zip_code') }}" id="input7"
                                                                placeholder="Zip" />
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Country</label>
                                                            <select
                                                                class="form-select js-example-basic-multiple form-control-sm"
                                                                name="country_id" aria-label="Default select example">
                                                                <option selected disabled value="">Select Country
                                                                </option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->id }}"
                                                                        {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                                        {{ $country->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Nationality</label>
                                                            <select
                                                                class="form-select js-example-basic-multiple form-control-sm"
                                                                name="nationality_id" aria-label="Default select example">
                                                                <option selected disabled value="">Select Nationality
                                                                </option>
                                                                @foreach ($countries as $nat)
                                                                    <option value="{{ $nat->id }}"
                                                                        {{ old('nationality_id') == $nat->id ? 'selected' : '' }}>
                                                                        {{ $nat->nationality }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="card">
                                                        <div class="mb-3">
                                                            <label for="input8" class="form-label">Home
                                                                Telephone</label>
                                                            <input type="text" name="home_telephone"
                                                                class="form-control form-control-sm"
                                                                value="{{ old('home_telephone') }}" id="input8"
                                                                placeholder="Home Telephone" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input9" class="form-label">Work
                                                                Telephone</label>
                                                            <input type="text" name="work_telephone"
                                                                class="form-control form-control-sm"
                                                                value="{{ old('work_telephone') }}" id="input9"
                                                                placeholder="Work Telephone" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Marital Status</label>
                                                            <select class="form-select form-control-sm"
                                                                name="marital_status" aria-label="Default select example">
                                                                <option value="single"
                                                                    {{ old('marital_status') == 'single' ? 'selected' : '' }}>
                                                                    Single</option>
                                                                <option value="married"
                                                                    {{ old('marital_status') == 'married' ? 'selected' : '' }}>
                                                                    Married</option>
                                                                <option value="widow"
                                                                    {{ old('marital_status') == 'widow' ? 'selected' : '' }}>
                                                                    Widow</option>
                                                                <option value="devorced"
                                                                    {{ old('marital_status') == 'devorced' ? 'selected' : '' }}>
                                                                    Devorced</option>
                                                                <option value="others"
                                                                    {{ old('marital_status') == 'others' ? 'selected' : '' }}>
                                                                    Others</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input6" class="form-label">Comment</label>
                                                            <textarea type="text" name="comment" rows="5" class="form-control form-control-sm" id="input6"
                                                                name="comment" placeholder="Comment"> {{ old('comment') }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input11" class="form-label">Bank Name</label>
                                                            <input type="text" name="bank_name"
                                                                class="form-control form-control-sm"
                                                                value="{{ old('bank_name') }}" id="input11"
                                                                placeholder="Bank Name" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input5" class="form-label">Bank Swift
                                                                Code</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="input5" name="bank_swift_code"
                                                                value="{{ old('bank_swift_code') }}"
                                                                placeholder="Bank Swift Code" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input5" class="form-label">Bank Account</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="input5" name="bank_account"
                                                                value="{{ old('bank_account') }}"
                                                                placeholder="Bank Account" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Role</label>
                                                            <select class="form-select form-control-sm" name="role"
                                                                aria-label="Default select example">
                                                                <option value="employee"
                                                                    {{ old('role') == 'employee' ? 'selected' : '' }}>
                                                                    Employee</option>
                                                                <option value="admin"
                                                                    {{ old('role') == 'admin' ? 'selected' : '' }}>Admin
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Is Active</label>
                                                            <select class="form-select form-control-sm" name="is_active"
                                                                aria-label="Default select example">
                                                                <option value="active"
                                                                    {{ old('is_active') == 'active' ? 'selected' : '' }}>
                                                                    Active</option>
                                                                <option value="inactive"
                                                                    {{ old('is_active') == 'inactive' ? 'selected' : '' }}>
                                                                    Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="USDT" role="tabpanel"
                                            aria-labelledby="USDT-tab">
                                            <div class="row mb-4">
                                                <div class="col-lg-6">
                                                    <div class="card">
                                                        <div class="mb-3">
                                                            <label for="cpf_id" class="form-label">CPF Table</label>
                                                            <select
                                                                class="form-select js-example-basic-multiple form-control-sm"
                                                                name="cpf_id" aria-label="Default select example"
                                                                style="width: 100%" id="cpf_id" required>
                                                                @foreach ($provident_funds as $cpf)
                                                                    <option value="{{ $cpf->id }}"
                                                                        {{ old('cpf_id') == $cpf->id ? 'selected' : '' }}>
                                                                        {{ $cpf->title }}<br />{{ $cpf->details }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="cpf_full_paid"
                                                                {{ old('cpf_full_paid') == 'yes' ? 'checked' : '' }}
                                                                id="input2" value="yes" />
                                                            <label for="input2" class="form-label">CPF is fully paid by
                                                                Employer</label>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input5" class="form-label">PR Effective
                                                                Date</label>
                                                            <input class="datepicker-here form-control form-control-sm"
                                                                placeholder="Date Of Birth" name="pr_effective_date"
                                                                readonly data-range="false"
                                                                data-multiple-dates-separator=" - " data-language="en"
                                                                data-format="dd-mm-yyyy"
                                                                value="{{ old('pr_effective_date') }}"
                                                                data-position="bottom left" autocomplete="off"
                                                                value="" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input4" class="form-label">CPF No.</label>
                                                            <input type="text" name="cpf_no"
                                                                class="form-control form-control-sm"
                                                                value="{{ old('cpf_no') }}" id="input4"
                                                                placeholder="CPF No." />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input5" class="form-label">Tax No.</label>
                                                            <input type="text" name="tax_no"
                                                                class="form-control form-control-sm"
                                                                value="{{ old('tax_no') }}" id="input5"
                                                                placeholder="Tax No." />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="work_table_id" class="form-label">Work
                                                                Table</label>
                                                            <select
                                                                class="form-select js-example-basic-multiple form-control-sm"
                                                                name="work_table_id" id="work_table_id"
                                                                aria-label="Default select example" style="width: 100%"
                                                                required>
                                                                <option value="">Select Work Table</option>
                                                                @foreach ($workTabls as $workTable)
                                                                    <option value="{{ $workTable->id }}"
                                                                        {{ old('work_table_id') == $workTable->id ? 'selected' : '' }}>
                                                                        {{ $workTable->title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="leave_table_id" class="form-label">Leave
                                                                Table</label>
                                                            <select
                                                                class="form-select js-example-basic-multiple form-control-sm"
                                                                name="leave_table_id" aria-label="Default select example"
                                                                style="width: 100%" id="leave_table_id" required>
                                                                <option value="">Select Leave Table</option>
                                                                @foreach ($leaveTables as $leaveTable)
                                                                    <option value="{{ $leaveTable->id }}"
                                                                        {{ old('leave_table_id') == $leaveTable->id ? 'selected' : '' }}>
                                                                        {{ $leaveTable->title }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="cpf"
                                                                type="checkbox" value="yes"
                                                                {{ old('cpf') == 'yes' ? 'checked' : '' }}
                                                                id="flexCheckIndeterminate" />
                                                            <label class="form-check-label" for="flexCheckIndeterminate">
                                                                <strong>No SDL Contribution</strong>
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="shg"
                                                                value="{{ old('shg') }}" type="checkbox"
                                                                value="yes" id="flexCheckIndeterminate" />
                                                            <label class="form-check-label" for="flexCheckIndeterminate">
                                                                <strong>No Self-Help Groups (SHG) contribution</strong>
                                                            </label>
                                                            (CDAC, MBMF, SINDA, ECF)
                                                        </div>
                                                        <div class="form-check mt-1">
                                                            <input class="form-check-input" name="us_attendance"
                                                                type="checkbox" value="yes"
                                                                {{ old('us_attendance') == 'yes' ? 'checked' : '' }}
                                                                id="flexCheckIndeterminate" />
                                                            <label class="form-check-label" for="flexCheckIndeterminate">
                                                                <strong>Use Attendance Records to Calculate Days
                                                                    Work</strong>
                                                            </label>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input5" class="form-label">Max Pay to Calculate
                                                                OT</label>
                                                            <input type="number" name="tax_no"
                                                                class="form-control form-control-sm"
                                                                name="max_pay_calculate" id="input5"
                                                                placeholder="Max pay calculate"
                                                                value="{{ old('tax_no', 2000) }}" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="card mb-3">
                                                        <h6 class="mb-3">Allowance</h6>

                                                        <div class="mb-3">
                                                            <label for="input8" class="form-label">Food </label>
                                                            <input type="number" name="food_allowance"
                                                                value="{{ old('food_allowance', 0) }}"
                                                                class="form-control" id="input8"
                                                                placeholder="type..." />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input9" class="form-label">
                                                                Mobile</label>
                                                            <input type="number" name="mobile_allowance"
                                                                class="form-control"
                                                                value="{{ old('mobile_allowance', 0) }}" id="input9"
                                                                placeholder="type..." />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input9" class="form-label">OT Allowance</label>
                                                            <input type="number" name="ot_allowance"
                                                                value="{{ old('ot_allowance', 0) }}" class="form-control"
                                                                id="input12" placeholder="type..." />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input10" class="form-label">Trainer Fee
                                                            </label>
                                                            <input type="number" name="trainer_fee_allowance"
                                                                value="{{ old('trainer_fee_allowance', 0) }}"
                                                                class="form-control" id="input10"
                                                                placeholder="type..." />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input10" class="form-label">Transportation
                                                            </label>
                                                            <input type="number" name="transportation_allowance"
                                                                class="form-control"
                                                                value="{{ old('transportation_allowance', 0) }}"
                                                                id="input10" placeholder="type..." />
                                                        </div>
                                                    </div>
                                                    <div class="card mb-3">
                                                        <h6 class="mb-3">Deduction</h6>

                                                        <div class="mb-3">
                                                            <label for="input8" class="form-label">CDAC </label>
                                                            <input type="number" name="cdac_deduction"
                                                                value="{{ old('cdac_deduction', 0) }}"
                                                                class="form-control" id="input8"
                                                                placeholder="type..." />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input9" class="form-label">ECF</label>
                                                            <input type="number" name="ecf_deduction"
                                                                value="{{ old('ecf_deduction', 0) }}"
                                                                class="form-control" id="input9"
                                                                placeholder="type..." />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input9" class="form-label">
                                                                MBMF
                                                            </label>
                                                            <input type="number" name="mbmf_deduction"
                                                                value="{{ old('mbmf_deduction', 0) }}"
                                                                class="form-control" id="input12"
                                                                placeholder="type..." />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input10" class="form-label">
                                                                SINDA
                                                            </label>
                                                            <input type="number" name="sinda_deduction"
                                                                value="{{ old('sinda_deduction', 0) }}"
                                                                class="form-control" id="input10"
                                                                placeholder="type..." />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input10" class="form-label">Transportation
                                                            </label>
                                                            <input type="number" name="transportation_deduction"
                                                                value="{{ old('transportation_deduction', 0) }}"
                                                                class="form-control" id="input10"
                                                                placeholder="type..." />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="XRP" role="tabpanel"
                                            aria-labelledby="XRP-tab">
                                            <div class="row mb-4">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="job_title" class="form-label">Job Title
                                                                    </label>
                                                                    <input type="text" name="job_title"
                                                                        class="form-control"
                                                                        value="{{ old('job_title') }}" id="job_title"
                                                                        placeholder="type..." />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Job Category</label>
                                                                    <select name="job_category_id"
                                                                        class="form-control js-example-basic-multiple  w-100 from-select6"
                                                                        id="" style="width: 100%">
                                                                        <option value="" selected>Select Job Category
                                                                        </option>
                                                                        @foreach ($jobCategories as $jobCategory)
                                                                            <option value="{{ $jobCategory->id }}"
                                                                                {{ old('job_category_id') == $jobCategory->id ? 'selected' : '' }}>
                                                                                {{ $jobCategory->title }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="designation_id"
                                                                        class="form-label">Designation</label>
                                                                    <select name="designation_id"
                                                                        class="form-control from-select2 w-100 from-select6"
                                                                        id="designation_id" style="width: 100%">
                                                                        <option value="">Select Designation</option>
                                                                        @foreach ($designations as $designation)
                                                                            <option value="{{ $designation->id }}"
                                                                                {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                                                                {{ $designation->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="pay_basis" class="form-label">Pay basis
                                                                    </label>

                                                                    <select name="pay_basis"
                                                                        class="form-control form-select" id="pay_basis">
                                                                        <option selected value="">Select</option>
                                                                        <option value="daily"
                                                                            {{ old('pay_basis') == 'daily' ? 'selected' : '' }}>
                                                                            Daily </option>
                                                                        <option value="hourly"
                                                                            {{ old('pay_basis') == 'hourly' ? 'selected' : '' }}>
                                                                            Hourly</option>
                                                                    </select>
                                                                </div>


                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="basic_rate" class="form-label">
                                                                        Basic Rate
                                                                    </label>
                                                                    <input type="number" name="basic_rate"
                                                                        class="form-control"
                                                                        value="{{ old('basic_rate') }}" id="basic_rate"
                                                                        placeholder="0" required />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="input7" class="form-label">Salary Start
                                                                        Date</label>
                                                                    <input class="datepicker-here form-control"
                                                                        placeholder="Select" name="start_date"
                                                                        data-range="false"
                                                                        data-multiple-dates-separator=" - "
                                                                        data-language="en" readonly
                                                                        data-format="dd-mm-yyyy"
                                                                        data-position="bottom left" autocomplete="off"
                                                                        value="{{ old('start_date') }}" />
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="input6" class="form-label">Salary End
                                                                        Date
                                                                    </label>
                                                                    <input class="datepicker-here form-control"
                                                                        placeholder="Select" name="end_date"
                                                                        data-range="false"
                                                                        data-multiple-dates-separator=" - "
                                                                        data-language="en" readonly
                                                                        data-format="dd-mm-yyyy"
                                                                        data-position="bottom left" autocomplete="off"
                                                                        value="{{ old('end_date') }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="DOGE" role="tabpanel"
                                            aria-labelledby="DOGE-tab">
                                            <div class="row mb-4">
                                                <div class="col-lg-6">
                                                    <div class="card">

                                                        <div class="mb-3">
                                                            <label for="department_id" class="form-label">Main
                                                                Department</label>
                                                            <select name="department_id"
                                                                class="form-control w-100 from-select4"
                                                                name="department_id" id="department_id">
                                                                <option value="" disabled selected>Select Department
                                                                </option>
                                                                @foreach ($departments as $department)
                                                                    <option value="{{ $department->id }}"
                                                                        {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                                        {{ $department->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>



                                                        <div class="mb-3">
                                                            <label for="emplyee_status" class="form-label">
                                                                Status
                                                            </label>
                                                            <select name="emplyee_status" class="form-control form-select"
                                                                id="emplyee_status">
                                                                <option selected value="">Select</option>
                                                                <option value="Existing Employee"
                                                                    {{ old('emplyee_status') == 'Existing Employee' ? 'selected' : '' }}>
                                                                    Existing Employee</option>
                                                                <option value="Leaver"
                                                                    {{ old('emplyee_status') == 'Leaver' ? 'selected' : '' }}>
                                                                    Leaver</option>
                                                                <option value="New Joiner"
                                                                    {{ old('emplyee_status') == 'New Joiner' ? 'selected' : '' }}>
                                                                    New Joiner</option>
                                                                <option value="Join and leave in some month"
                                                                    {{ old('emplyee_status') == 'Join and leave in some month' ? 'selected' : '' }}>
                                                                    Join and leave in some month
                                                                </option>

                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="join_date" class="form-label">
                                                                Date Joined
                                                            </label>
                                                            <input class="datepicker-here form-control"
                                                                placeholder="Select" name="join_date" id="join_date"
                                                                data-range="false" data-multiple-dates-separator=" - "
                                                                data-language="en" data-format="dd-mm-yyyy" readonly
                                                                data-position="bottom left" autocomplete="off"
                                                                value="{{ old('join_date') }}" required />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input7" class="form-label">Date Left</label>
                                                            <input class="datepicker-here form-control"
                                                                placeholder="Select" name="left_date" id="left_date"
                                                                data-range="false" data-multiple-dates-separator=" - "
                                                                data-language="en" data-format="dd-mm-yyyy" readonly
                                                                data-position="bottom left" autocomplete="off"
                                                                value="{{ old('left_date') }}" />
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-6">
                                                    <div class="card">
                                                        <div class="mb-3">
                                                            <label for="employee_type" class="form-label">Employment Type
                                                            </label>
                                                            <select name="employee_type" class="form-control form-select"
                                                                id="employee_type">
                                                                <option selected value="">Select</option>
                                                                @foreach ($jobTypes as $jobType)
                                                                    <option value="{{ $jobType->id }}"
                                                                        {{ old('employee_type') == $jobType->id ? 'selected' : '' }}>
                                                                        {{ $jobType->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3 d-flex flex-column">
                                                            <label class="form-label">Direct Manager</label>
                                                            <select name="fromcountry"
                                                                class="form-control w-100 from-select5" id="fromcountry">
                                                                <option data-mobile_code="93" value="Afghanistan"
                                                                    data-code="AF">
                                                                    Digipixel</option>
                                                                <option data-mobile_code="358" value="Aland Islands"
                                                                    data-code="AX">
                                                                    Anonymous
                                                                </option>
                                                                <option data-mobile_code="355" value="Albania"
                                                                    data-code="AL">
                                                                    Graphics</option>
                                                                <option data-mobile_code="213" value="Algeria"
                                                                    data-code="DZ">
                                                                    Human Resource</option>
                                                            </select>
                                                        </div>



                                                        <div class="mb-3">
                                                            <label for="input6" class="form-label">
                                                                Probation From
                                                            </label>
                                                            <input class="datepicker-here form-control"
                                                                placeholder="Select" name="probation_from"
                                                                data-range="false" data-multiple-dates-separator=" - "
                                                                data-language="en" data-format="dd-mm-yyyy" readonly
                                                                data-position="bottom left" autocomplete="off"
                                                                value="{{ old('probation_from') }}" />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="input7" class="form-label">Probation To</label>
                                                            <input class="datepicker-here form-control"
                                                                placeholder="Select" name="probation_to"
                                                                data-range="false" data-multiple-dates-separator=" - "
                                                                data-language="en" data-format="dd-mm-yyyy" readonly
                                                                data-position="bottom left" autocomplete="off"
                                                                value="{{ old('probation_to') }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="Nuna" role="tabpanel"
                                            aria-labelledby="Nuna-tab">
                                            <div>
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#qualificationModal" class="btn btn-sm btn-base">
                                                    Add Qualification
                                                </button>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <table id="qualificationTable" class="w-100 table table-hover">
                                                            {{-- <thead>
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
                                                                @forelse($qualifications as $qualification)
                                                                    <tr>
                                                                        <td>11</td>
                                                                        <td>Anonymous</td>
                                                                        <td>High</td>
                                                                        <td>Education</td>
                                                                        <td>11/9/2024</td>
                                                                        <td>11/9/2024</td>
                                                                        <td>11/12/2024</td>
                                                                        <td>No Comment</td>
                                                                        <td>
                                                                            <div class="d-flex gap-1">
                                                                                <button
                                                                                    class="btn btn-outline-base btn-sm q_edit_btn"
                                                                                    data-bs-toggle="modal"
                                                                                    data-id="{{ $qualification->id }}"
                                                                                    data-bs-target="#qualificationEditModal">
                                                                                    <i class="far fa-edit"></i>
                                                                                </button>
                                                                                <form
                                                                                    action="{{ route('employee.qualification.destroy', $qualification->id) }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                        class="btn btn-outline-danger btn-sm delete">
                                                                                        <i class="far fa-trash-alt"></i>
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td class="text-center" colspan="9">No Data Found
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </tbody> --}}
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="LUNA" role="tabpanel"
                                            aria-labelledby="LUNA-tab">
                                            <div>
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#contactModal" class="btn btn-sm btn-base">
                                                    Add Contact
                                                </button>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <table id="contactTable" class="w-100 table table-hover">
                                                            {{-- <thead>
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
                                                                <tr>
                                                                    <td>11</td>
                                                                    <td>Anonymous</td>
                                                                    <td>Male</td>
                                                                    <td>Aunty</td>
                                                                    <td>015475222</td>
                                                                    <td>252554425</td>
                                                                    <td>+5577441165</td>
                                                                    <td>No Comment</td>
                                                                    <td>
                                                                        <div class="d-flex gap-1">
                                                                            <button class="btn btn-outline-base btn-sm">
                                                                                Edit
                                                                            </button>
                                                                            <button class="btn btn-outline-danger btn-sm">
                                                                                Delete
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>11</td>
                                                                    <td>Anonymous</td>
                                                                    <td>Male</td>
                                                                    <td>Aunty</td>
                                                                    <td>015475222</td>
                                                                    <td>252554425</td>
                                                                    <td>+5577441165</td>
                                                                    <td>No Comment</td>
                                                                    <td>
                                                                        <div class="d-flex gap-1">
                                                                            <button class="btn btn-outline-base btn-sm">
                                                                                Edit
                                                                            </button>
                                                                            <button class="btn btn-outline-danger btn-sm">
                                                                                Delete
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody> --}}
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        {{-- Employee Documents --}}
                                        <div class="tab-pane fade" id="LTC" role="tabpanel"
                                            aria-labelledby="LTC-tab">
                                            <div>
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#documentModal" class="btn btn-sm btn-base">
                                                    Add Document
                                                </button>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <table id="documentTable" class="w-100 table table-hover">

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- tabs -->
                                <div class="text-center">
                                    <button type="submit" id="submit" class="btn btn-base">Submit</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>


                <!--Qualification Modal -->
                <div class="modal fade" id="qualificationModal" tabindex="-1" aria-labelledby="exampleModalLabel2"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content qualification-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Qualification</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form id="addQualification" action="{{ route('employee.qualification.store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="mb-3">
                                                <label for="input1" class="form-label">Name of institution
                                                </label>
                                                <input type="text" name="q_institution" class="form-control"
                                                    id="input1" value="{{ old('q_institution') }}"
                                                    placeholder="Name of institution" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="input1" class="form-label">Level/Score
                                                </label>
                                                <input type="text" name="q_level" class="form-control" id="input1"
                                                    placeholder="Level/Score" value="{{ old('q_level') }}" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="input1" class="form-label">Type
                                                </label>
                                                <input type="text" name="q_type" class="form-control" id="input1"
                                                    placeholder="Type" value="{{ old('q_type') }}" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="input3" class="form-label">Start Date
                                                </label>
                                                <input class="datepicker-here form-control" placeholder="Select"
                                                    name="q_start_date" readonly data-range="false"
                                                    data-multiple-dates-separator=" - " data-language="en"
                                                    data-format="dd-mm-yyyy" data-position="bottom left"
                                                    autocomplete="off" value="{{ old('q_start_date') }}" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="input3" class="form-label">End Date
                                                </label>
                                                <input class="datepicker-here form-control" placeholder="Select"
                                                    name="q_end_date" readonly data-range="false"
                                                    data-multiple-dates-separator=" - " data-language="en"
                                                    data-format="dd-mm-yyyy" data-position="bottom left"
                                                    autocomplete="off" value="{{ old('q_end_date') }}" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="input3" class="form-label">Expire Date
                                                </label>
                                                <input class="datepicker-here form-control" placeholder="Select"
                                                    name="q_expire_date" readonly data-range="false"
                                                    data-multiple-dates-separator=" - " data-language="en"
                                                    data-format="dd-mm-yyyy" data-position="bottom left"
                                                    autocomplete="off" value="{{ old('q_expire_date') }}" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="input3" class="form-label">Comment
                                                </label>
                                                <textarea type="text" name="q_comment" id="input1" class="form-control" required placeholder="Comment">{{ old('q_comment') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-base">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- / Modal -->

                <!--Qualification edit Modal -->
                <div class="modal fade" id="qualificationEditModal" tabindex="-1"
                    aria-labelledby="qualificationEditModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Qualification</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div id="edit_section"></div>
                        </div>

                    </div>
                </div>
                <!-- / Modal -->


                <!--Contact Modal -->
                <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="exampleModalLabel1"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Contact</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form id="addContact" action="{{ route('employee.contact.store') }}" method="POST">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="mb-3">
                                                <label for="input1" class="form-label">Name
                                                </label>
                                                <input type="text" name="c_name" class="form-control"
                                                    id="input1" placeholder="type..." required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="input2" class="form-label">
                                                    Gender
                                                </label>
                                                <select name="c_gender" class="form-control form-select"
                                                    id="c_gender" required>
                                                    <option selected value="">Select</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="others">Others</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="input2" class="form-label">
                                                    Relationship
                                                </label>
                                                <select name="c_relationship_id" class="form-control form-select"
                                                    id="c_relationship_id" required>
                                                    <option selected value="">Select</option>
                                                    @foreach ($relationships as $relationship)
                                                        <option value="{{ $relationship->id }}">
                                                            {{ $relationship->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="input3" class="form-label">Home Telephone
                                                </label>
                                                <input type="text"
                                                    oninput="this.value=this.value.replace(/[^0-9 ]/g,'');"
                                                    name="c_home_telephone" id="input1" class="form-control"
                                                    required placeholder="Home Telephone" />
                                            </div>

                                            <div class="mb-3">
                                                <label for="input3" class="form-label">Mobile
                                                </label>
                                                <input type="text" name="c_mobile" id="input1"
                                                    oninput="this.value=this.value.replace(/[^0-9 ]/g,'');"
                                                    class="form-control" required placeholder="Mobile" />
                                            </div>

                                            <div class="mb-3">
                                                <label for="input3" class="form-label">Work Telephone
                                                </label>
                                                <input type="text" name="c_work_telephone" id="input1"
                                                    oninput="this.value=this.value.replace(/[^0-9 ]/g,'');"
                                                    class="form-control" required placeholder="Work Telephone" />
                                            </div>

                                            <div class="mb-3">
                                                <label for="input3" class="form-label">Email
                                                </label>
                                                <input type="email" name="c_email" id="input1"
                                                    class="form-control" required placeholder="Email" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-base">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- / Modal -->

                <!--Edit Contact Modal -->
                <div class="modal fade" id="contactEditModal" tabindex="-1" aria-labelledby="contactEditModal"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Contact</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div id="edit_contact_section"></div>
                        </div>
                    </div>
                </div>
                <!-- / Modal -->


                <!--Document Modal -->
                <div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModal"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Document</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <form id="addDocument" action="{{ route('employee.document.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="mb-3">
                                                <label for="input1" class="form-label">Title
                                                </label>
                                                <input type="text" name="d_title" class="form-control"
                                                    id="input1" placeholder="type..."
                                                    value="{{ old('d_title') }}" required />
                                            </div>
                                            <div class="mb-3">
                                                <label for="input2" class="form-label">
                                                    Category
                                                </label>
                                                <select name="d_category" class="form-control form-select"
                                                    id="d_category" required>
                                                    <option selected value="">Select</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="input3" class="form-label">Start Date
                                                </label>
                                                <input class="datepicker-here form-control" placeholder="Select"
                                                    name="d_start_date" data-range="false"
                                                    data-multiple-dates-separator=" - " data-language="en"
                                                    data-format="dd-mm-yyyy" readonly data-position="bottom left"
                                                    autocomplete="off" value="{{ old('d_start_date') }}" required />
                                            </div>
                                            <div class="mb-3">
                                                <label for="input4" class="form-label">End Date
                                                </label>
                                                <input class="datepicker-here form-control" placeholder="Select"
                                                    name="d_end_date" data-range="false"
                                                    data-multiple-dates-separator=" - " data-language="en"
                                                    data-format="dd-mm-yyyy" data-position="bottom left"
                                                    autocomplete="off" readonly value="{{ old('d_end_date') }}"
                                                    required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="input5" class="form-label">Expiry Date
                                                </label>
                                                <input class="datepicker-here form-control" placeholder="Select"
                                                    name="d_expiry_date" readonly data-range="false"
                                                    data-multiple-dates-separator=" - " data-language="en"
                                                    data-format="dd-mm-yyyy" data-position="bottom left"
                                                    autocomplete="off" value="{{ old('d_expiry_date') }}" required />
                                            </div>
                                            <div class="mb-3">
                                                <label for="formFile" class="form-label">File No
                                                </label>
                                                <input class="form-control" name="d_file" type="file"
                                                    id="formFile" />
                                            </div>

                                            <div class="mb-3">
                                                <label for="input7" class="form-label">
                                                    Remark</label>
                                                <textarea class="form-control" rows="3" name="d_remark" placeholder="type" id="floatingTextarea2">{{ old('d_remark') }}</textarea>
                                            </div>
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
                <!-- / Modal -->

                <!--Edit Document Modal -->
                <div class="modal fade" id="documentEditModal" tabindex="-1" aria-labelledby="documentEditModal"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Document</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div id="edit_document_section"></div>

                        </div>
                    </div>
                </div>
                <!-- / Modal -->
            </div>
        </section>
        <!-- / Employee List -->
    </div>
    @push('js')
        {{-- PAssword Toggle --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const togglePassword = document.querySelector('#togglePassword');
                const passwordField = document.querySelector('#id_number');

                togglePassword.addEventListener('click', function() {
                    // Toggle the type attribute
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);

                    // Toggle the eye icon
                    this.innerHTML = type === 'password' ? '<i class="fa fa-eye"></i>' :
                        '<i class="fa fa-eye-slash"></i>';
                });
            });
        </script>


        {{-- Qualification --}}
        <script>
            // Add Qualification
            $(document).ready(function() {
                $('#addQualification').submit(function(e) {
                    e.preventDefault();
                    var url = $(this).attr('action');
                    var request = $(this).serialize();

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: request,
                        success: function(data) {
                            $("#addQualification")[0].reset();
                            $("#qualificationModal").modal('hide');
                            showToast(data, "success", 3000);
                            loadQualificationTableData()

                        }
                    });
                });

                loadQualificationTableData()
            });


            // Edit Qualification

            $('body').on('click', '.q_edit_btn', function() {
                var id = $(this).data('id');

                $.get("{{ url('admin/employee-qualification/edit') }}/" + id,
                    function(data) {
                        $('#edit_section').html(data);
                    })
            });


            // Fetch Qualification
            function loadQualificationTableData() {
                $.ajax({
                    url: '{{ route('employee.qualification.index') }}',
                    type: 'GET',
                    success: function(data) {
                        $('#qualificationTable').html(data);
                    }
                });
            }
        </script>


        {{-- Contact --}}
        <script>
            // Add Contact
            $(document).ready(function() {
                $('#addContact').submit(function(e) {
                    e.preventDefault();
                    var url = $(this).attr('action');
                    var request = $(this).serialize();

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: request,
                        success: function(data) {
                            $("#addContact")[0].reset();
                            $("#contactModal").modal('hide');
                            showToast(data, "success", 3000);
                            loadContactTableData()

                        }
                    });
                });

                loadContactTableData()
            });


            // Edit Qualification

            $('body').on('click', '.c_edit_btn', function() {
                var id = $(this).data('id');

                $.get("{{ url('admin/employee-contact/edit') }}/" + id,
                    function(data) {
                        $('#edit_contact_section').html(data);
                    })
            });


            // Fetch Contact
            function loadContactTableData() {
                $.ajax({
                    url: '{{ url('admin/employee-contact') }}',
                    type: 'GET',
                    success: function(data) {
                        $('#contactTable').html(data);
                    }
                });
            }
        </script>

        {{-- Document --}}
        <script>
            // Add Document
            $(document).ready(function() {
                $('#addDocument').submit(function(e) {
                    e.preventDefault();

                    var url = $(this).attr('action');
                    var formData = new FormData(this); // Use FormData to handle file input

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        contentType: false, // Important for file upload
                        processData: false, // Important for file upload
                        success: function(data) {
                            $("#addDocument")[0].reset();
                            $("#documentModal").modal('hide');
                            showToast(data, "success", 3000);
                            loadDocumentTableData();
                        },
                        error: function(xhr, status, error) {
                            // Handle errors here
                            swal({
                                title: "Error!",
                                text: "An error occurred while uploading the file.",
                                icon: "error",
                                timer: 1000,
                                buttons: false
                            });
                        }
                    });
                });

                loadDocumentTableData();
            });



            // Edit Document

            $('body').on('click', '.d_edit_btn', function() {
                var id = $(this).data('id');

                $.get("{{ url('admin/employee-document/edit') }}/" + id,
                    function(data) {
                        $('#edit_document_section').html(data);
                    })
            });


            // Fetch Document
            function loadDocumentTableData() {
                $.ajax({
                    url: '{{ url('admin/employee-document') }}',
                    type: 'GET',
                    success: function(data) {
                        $('#documentTable').html(data);
                    }
                });
            }
        </script>

        <script>
            $(document).ready(function() {
                $('#image').on('change', function(event) {
                    const file = event.target.files[0];

                    if (file) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            $('#imagePreview').attr('src', e.target.result).show();
                        };

                        reader.readAsDataURL(file);
                    } else {
                        $('#imagePreview').hide();
                    }
                });
            });

            $(document).on('click', '#copyButton', function() {
                // Get the text content of the password and email
                var passwordText = $("#passwordText").text().trim(); // Get text from password div
                var emailText = $("#emailText").text().trim(); // Get text from email div

                // Combine the email and password into one string (you can format it as needed)
                var combinedText = "Email: " + emailText + "\nPassword: " + passwordText;

                // Create a temporary textarea element to facilitate the copy
                var $temp = $('<textarea>');
                $('body').append($temp);
                $temp.val(combinedText).select();

                // Copy the text
                document.execCommand('copy');

                // Remove the temporary element
                $temp.remove();

                // Optionally, show an alert to notify the user
                swal.fire({
                    title: "Copied!",
                    text: "Email and Password copied successfully!",
                    icon: "success",
                    timer: 1000, // Duration in milliseconds (1000ms = 1 second)
                    buttons: false, // Disable the button to close manually
                });
            });



            $("#autopassword").on("change", function() {
                const isChecked = $(this).is(":checked");

                if (isChecked) {
                    $("#password").attr('required', false);
                    $("#password_confirmation").attr('required', false);
                    $("#password").val('');
                    $("#password_confirmation").val('');
                } else {
                    $("#password").attr('required', true);
                    $("#password_confirmation").attr('required', true);
                }
            })
        </script>

        <script>
            $(document).ready(function() {
                $('#submit').on('click', function() {
                    // Clear previous invalid classes
                    $('input').removeClass('is-invalid');

                    var name = $('#name').val();
                    var employee_id = $('#employee_id').val();
                    var id_number = $('#id_number').val();
                    var id_type_id = $('#id_type_id').val();
                    var dob = $('#dob').val();
                    var gender = $('#gender').val();
                    var address = $('#address').val();
                    var phone = $('#phone').val();
                    var email = $('#email').val();
                    var cpf_id = $('#cpf_id').val();
                    var work_table_id = $('#work_table_id').val();
                    var leave_table_id = $('#leave_table_id').val();
                    var basic_rate = $('#basic_rate').val();
                    var join_date = $('#join_date').val();

                    // Array of fields and corresponding messages
                    var fields = [{
                            value: name,
                            message: "Name is required",
                            id: '#name'
                        },
                        {
                            value: employee_id,
                            message: "Employee ID is required",
                            id: '#employee_id'
                        },
                        {
                            value: id_number,
                            message: "ID Number is required",
                            id: '#id_number'
                        },
                        {
                            value: id_type_id,
                            message: "ID Type ID is required",
                            id: '#id_type_id'
                        },
                        {
                            value: dob,
                            message: "Date of Birth is required",
                            id: '#dob'
                        },
                        {
                            value: gender,
                            message: "Gender is required",
                            id: '#gender'
                        },
                        {
                            value: address,
                            message: "Address is required",
                            id: '#address'
                        },
                        {
                            value: phone,
                            message: "Phone number is required",
                            id: '#phone'
                        },
                        {
                            value: email,
                            message: "Email is required",
                            id: '#email'
                        },
                        {
                            value: cpf_id,
                            message: "CPF ID is required",
                            id: '#cpf_id'
                        },
                        {
                            value: work_table_id,
                            message: "Work Table ID is required",
                            id: '#work_table_id'
                        },
                        {
                            value: leave_table_id,
                            message: "Leave Table ID is required",
                            id: '#leave_table_id'
                        },
                        {
                            value: basic_rate,
                            message: "Basic Rate is required",
                            id: '#basic_rate'
                        },
                        {
                            value: join_date,
                            message: "Join Date is required",
                            id: '#join_date'
                        },
                    ];

                    // Check for empty fields
                    for (var i = 0; i < fields.length; i++) {
                        if (!fields[i].value) {
                            $(fields[i].id).addClass('is-invalid').focus(); // Add invalid class
                            showToast(fields[i].message, "error", 3000);
                            return false;
                        }
                    }

                    // If all fields are filled, you can proceed with form submission
                    // For example:
                    // $('#yourFormId').submit();
                });
            });
        </script>
    @endpush
@endsection
