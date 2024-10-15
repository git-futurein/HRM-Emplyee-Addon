@extends('layouts.app')
@section('title', '| Leave Table')
@section('header', 'Leave Table')
@section('content')
    @push('css')
        <style>
            .table {
                border: 1px solid black;
                border-collapse: collapse;
            }

            .table th,
            .table td {
                border: 1px solid black;
                padding: 8px;
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
                            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                                aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Leave Table Edit</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('leave.table.index') }}" class="btn btn-info">
                                    Back
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
                <div class="card">
                    <form action="{{ route('leave.table.update', $leaveTable->id) }}" method="POST">
                        @csrf
                        <div class="row d-flex justify-content-center align-items-center mb-3">
                            <div class="col-lg-8">
                                <div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Title</label>
                                        <input type="text" name="title" class="form-control form-control-sm"
                                            id="exampleInputEmail1" aria-describedby="emailHelp"
                                            value="{{ old('title', $leaveTable->title) }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Description</label>
                                        <textarea class="form-control form-control-sm" name="description" rows="4" id="exampleInputPassword1">{{ old('description', $leaveTable->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <table class="table" style="border: 1px solid black; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th style="border: 1px solid black;">Leave Type</th>
                                        <th colspan="2" style="border: 1px solid black;">Working Year</th>
                                        <th style="border: 1px solid black;">Entitlement</th>
                                        <th style="border: 1px solid black;">Carried Forward</th>
                                        <th style="border: 1px solid black;"></th>
                                    </tr>
                                    <tr>
                                        <th style="border: 1px solid black;"></th>
                                        <th style="border: 1px solid black;">From</th>
                                        <th style="border: 1px solid black;">To</th>
                                        <th colspan="2" style="border: 1px solid black;"></th>
                                        <th style="border: 1px solid black;"></th>
                                    </tr>
                                </thead>
                                <tbody id="leaveTableBody">
                                    @foreach ($leaveTable->leaveTableDetails as $entry)
                                        <tr>
                                            <td style="border: 1px solid black;">
                                                <select class="form-select form-control-sm" name="leave_type[]">
                                                    @foreach ($leaveTypes as $leaveType)
                                                        <option value="{{ $leaveType->id }}"
                                                            {{ $leaveType->id == $entry->leave_type_id ? 'selected' : '' }}>
                                                            {{ $leaveType->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td width="15%" style="border: 1px solid black;">
                                                <input type="number" name="from[]"
                                                    class="form-control form-control-sm me-1" placeholder="From"
                                                    value="{{ $entry->from }}">
                                            </td>
                                            <td width="15%" style="border: 1px solid black;">
                                                <input type="number" name="to[]" class="form-control form-control-sm"
                                                    placeholder="To" value="{{ $entry->to }}">
                                            </td>
                                            <td width="15%" style="border: 1px solid black;">
                                                <input type="text" name="entitlement[]"
                                                    class="form-control form-control-sm" value="{{ $entry->entitlement }}">
                                            </td>
                                            <td width="15%" style="border: 1px solid black;">
                                                <input type="text" name="carried_forward[]"
                                                    class="form-control form-control-sm"
                                                    value="{{ $entry->carried_forward }}">
                                            </td>
                                            <td width="5%" style="border: 1px solid black;">
                                                <button type="button" class="btn btn-danger remove-row">X</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <button type="button" id="addRow" class="addRow"> + Add More Row</button>
                        </div>
                        <div class="mt-4">
                            <p>Working Year: how many years working for company, 3 months ~ 3/12=0.25 year</p>

                            <p>For Incremental Leaves</p>
                            <p>Please key in Working Year From and To :</p>
                            <p>From 0 To 1 ----- Indicates < 1 year of employment </p>
                                    <p>From 1 To 2 ----- Indicates From>=1 to < 2 years of employment</p>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    @push('js')
        <script>
            $(document).ready(function() {
                // Function to add a new row
                $('.addRow').click(function() {
                    var newRow = `
                    <tr>
                        <td style="border: 1px solid black;">
                            <select class="form-select form-control-sm" name="leave_type[]">
                                @foreach ($leaveTypes as $leaveType)
                                    <option value="{{ $leaveType->id }}">{{ $leaveType->title }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td width="15%" style="border: 1px solid black;">
                            <input type="number" name="from[]" class="form-control form-control-sm me-1" placeholder="From" value="0">
                        </td>
                        <td width="15%" style="border: 1px solid black;">
                            <input type="number" name="to[]" class="form-control form-control-sm" placeholder="To" value="1">
                        </td>
                        <td width="15%" style="border: 1px solid black;">
                            <input type="text" name="entitlement[]" class="form-control form-control-sm">
                        </td>
                        <td width="15%" style="border: 1px solid black;">
                            <input type="text" name="carried_forward[]" class="form-control form-control-sm">
                        </td>
                        <td width="5%" style="border: 1px solid black;">
                            <button type="button" class="btn btn-danger remove-row">X</button>
                        </td>
                    </tr>
                `;
                    $('#leaveTableBody').append(newRow);
                });

                // Function to remove a row
                $('#leaveTableBody').on('click', '.remove-row', function() {
                    $(this).closest('tr').remove();
                });
            });
        </script>
    @endpush
@endsection
