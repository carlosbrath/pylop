@extends('layouts.master-public')
@section('title', 'Track Your Loan Application')
@section('content')
    <section class="py-4">
        <div class="container">
            <div class="row justify-content-center form-bg pb-4">
                <!-- Header -->
                <div class="col-md-12  green-gradient text-white py-3 mb-4 rounded text-center">
                    <h3 class="mb-0">Track Your Loan Application</h3>
                    <p class="mt-1">Check status of your submitted loan application</p>
                </div>
                @if ($errors->any())
                    <div class="col-md-10">
                        <div class="alert alert-danger">
                            <strong>There were some errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>❌ {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('track.application') }}" method="POST"
                    class="col-md-10 bg-light p-4 rounded shadow-sm">
                    @csrf
                    <div class="row g-3">

                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
                                <div class="form-floating flex-grow-1">
                                    <input type="text" name="cnic" id="track_cnic" class="form-control"
                                        placeholder="xxxxx-xxxxxxx-x" value="{{ $applicant->cnic ?? old('cnic') }}" required
                                        maxlength="15">
                                    <label for="track_cnic">CNIC / شناختی کارڈ نمبر</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                <div class="form-floating flex-grow-1">
                                    <input type="date" name="issue_date" id="track_issue_date" class="form-control"
                                        placeholder="CNIC Issue Date"
                                        value="{{ $applicant->cnic_issue_date ?? old('issue_date') }}" required>
                                    <label for="track_issue_date">CNIC Issue Date / اجراء کی تاریخ</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                <div class="form-floating flex-grow-1">
                                    <input type="date" name="dob" id="track_dob" class="form-control"
                                        placeholder="Date of Birth" value="{{ $applicant->dob ?? old('dob') }}" required>
                                    <label for="track_dob">Date of Birth / تاریخ پیدائش</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-success px-5">
                                <i class="bi bi-search me-1"></i> Track Application
                            </button>
                        </div>
                    </div>
                </form>



                @if (isset($applicant))
                    <div class="col-md-10 my-5" style="background: #eeeded; padding: 30px;">
                        <!-- Header with Logos and Title -->
                        <div class="row align-items-center mb-4">
                            <div class="col-md-3 text-start">
                                <img src="{{ asset('images/ajklogo.png') }}" alt="AJK Logo" class="img-fluid"
                                    style="max-height: 80px;">
                            </div>
                            <div class="col-md-6 text-center">
                                <h5 class="mb-1 fw-bold">Government of Azad Jammu & Kashmir</h5>
                                <h4 class="mb-1 fw-bold">Small Industries Prime Minister Youth Loan Program</h4>
                                <h5 class="text-muted mt-2">Application for the Loan</h5>
                            </div>
                            <div class="col-md-3 text-end">
                                <img src="{{ asset('images/logo.png') }}" alt="Small Industries Logo" class="img-fluid"
                                    style="max-height: 80px;">
                            </div>
                        </div>

                        <!-- Application Data -->
                        <div class="card border-success shadow-sm">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">

                                        <div class="row mb-3">
                                            <div class="col-2"><strong>Applicant's Name:</strong></div>
                                            <div class="col-9">
                                                <div class="border-bottom pb-1">{{ $applicant->name }}</div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-2"><strong>Father's Name:</strong></div>
                                            <div class="col-9">
                                                <div class="border-bottom pb-1">{{ $applicant->fatherName }}</div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-2"><strong>CNIC:</strong></div>
                                            <div class="col-4">
                                                @php

                                                    $dob = \Carbon\Carbon::parse($applicant->dob);
                                                    $age = $dob->diff(\Carbon\Carbon::now());
                                                @endphp
                                                <span class="border-bottom pb-1">{{ $applicant->cnic }}</span>
                                                <strong>Date Of Birth</strong>
                                                <span
                                                    class="border-bottom pb-1">{{ \Carbon\Carbon::parse($applicant->dob)->format('d-M-Y') }}</span>
                                                <strong>Age</strong>

                                                <span class="border-bottom pb-1">{{ $age->y }}</span>
                                                <strong>Year</strong>
                                                <span class="border-bottom pb-1">{{ $age->m }}</span>
                                                <strong>Month</strong>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-2"><strong>Address:</strong></div>
                                            <div class="col-9">
                                                <div class="border-bottom pb-1">{{ $applicant->CurrentAddress }}</div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-2"><strong>Phone:</strong></div>
                                            <div class="col-9">
                                                <div class="border-bottom pb-1">{{ $applicant->phone }}</div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-2"><strong>Business Name:</strong></div>
                                            <div class="col-9">
                                                <div class="border-bottom pb-1">{{ $applicant->businessName }}</div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-2"><strong>Tier:</strong></div>
                                            <div class="col-9">
                                                <div class="border-bottom pb-1">{{ $applicant->tier }}</div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-2"><strong>Fee Status:</strong></div>
                                            <div class="col-9">
                                                <div class="border-bottom pb-1">
                                                    @php
                                                        $feeStatusclass= match(strtolower($applicant->fee_status)){
                                                            'unpaid'=>'bg-danger',
                                                            'paid'=>'bg-success',
                                                        }
                                                    @endphp
                                                    <span class="badge {{$feeStatusclass}}">{{ $applicant->fee_status }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-2"><strong>Status:</strong></div>
                                            <div class="col-9">
                                                <div class="border-bottom pb-1">
                                                    @php
                                                        $statusClass = match (strtolower($applicant->status)) {
                                                            'pending' => 'bg-info',
                                                            'approved' => 'bg-success',
                                                            'rejected' => 'bg-danger',
                                                            default => 'bg-secondary',
                                                        };
                                                    @endphp
                                                    <span class="badge {{$statusClass}}">{{ $applicant->status }}</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($applicant->fee_status === 'paid')
                            <div class="my-4 p-4 bg-light border rounded shadow-sm">
                                <h5 class="mb-3"><i class="bi bi-check-circle-fill text-success me-1"></i> Challan
                                    Submitted</h5>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><i class="bi bi-bank me-1"></i> Branch Name</label>
                                        <div class="form-control bg-white">{{ $applicant->branch_name ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label"><i class="bi bi-123 me-1"></i> Branch Code</label>
                                        <div class="form-control bg-white">{{ $applicant->branch_code ?? '-' }}</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="form-label d-block"><i class="bi bi-image me-1"></i> Challan
                                            Image</label>
                                        @if ($applicant->challan_image && file_exists(public_path('images/challans/' . $applicant->challan_image)))
                                            <img src="{{ asset('images/challans/' . $applicant->challan_image) }}"
                                                alt="Challan Image" class="img-fluid border rounded shadow-sm"
                                                style="max-height: 500px;">
                                        @else
                                            <div class="form-control bg-white">Not Uploaded</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('upload.challan') }}" method="POST" enctype="multipart/form-data"
                                class="my-4 p-4 bg-white shadow-sm rounded">
                                @csrf
                                <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">

                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-bank"></i></span>
                                            <div class="form-floating flex-grow-1">
                                                <input type="text" class="form-control" id="branch_name"
                                                    name="branch_name" placeholder="Branch Name" required>
                                                <label for="branch_name">Branch Name</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                                            <div class="form-floating flex-grow-1">
                                                <input type="text" class="form-control" id="branch_code"
                                                    name="branch_code" placeholder="Branch Code" required>
                                                <label for="branch_code">Branch Code</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i
                                                    class="bi bi-file-earmark-arrow-up"></i></span>
                                            <div class="form-floating flex-grow-1">
                                                <input type="file" class="form-control" id="challan_image"
                                                    name="challan_image" required>
                                                <label for="challan_image">Upload Challan Image</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 text-end mt-3">
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-upload"></i> Submit Challan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif



                        <!-- Footer Instructions -->
                        <div class="alert alert-warning mt-4">
                            <strong>Instructions:</strong>
                            <ul class="mb-0">
                                <li>Please keep this page saved or printed for your records.</li>
                                <li>Only one application is allowed per CNIC.</li>
                                <li>All information provided will be verified from NADRA and relevant institutions.</li>
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Info Box -->
                <div class="col-md-10 mt-4">
                    <div class="alert alert-info border-0">
                        <strong>Note:</strong> Please enter the CNIC, issue date, and Date of Birth used in the original
                        application. The status will only appear if all details are correctly entered.
                    </div>
                </div>


            </div>

        </div>
    </section>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script>
            $(document).ready(function() {
                $('input[name="cnic"]').mask('00000-0000000-0');
            });
        </script>
    @endpush
@endsection
