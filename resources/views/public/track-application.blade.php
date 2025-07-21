@extends('layouts.master-public')
@section('title', 'Track Your Loan Application')
@section('content')
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-family: 'Times New Roman', Times, serif;
            }

            .page {
                width: 210mm;
                min-height: 297mm;
                padding: 20mm;
                margin: auto;
                border: 1px solid #ccc;
                border-radius: 5px;
                background: white;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            }

            .no-print {
                display: none;
            }
        }

        .page {
            background: white;
            padding: 30px;
            font-size: 14px;
            line-height: 1.6;
        }

        .section-title {
            font-weight: bold;
            font-size: 16px;
            border-bottom: 1px solid #000;
            margin-bottom: 10px;
            padding-bottom: 3px;
        }

        .info-row {
            display: flex;
            margin-bottom: 8px;
        }

        .info-label {
            width: 200px;
            font-weight: bold;
        }

        .info-value {
            flex: 1;
            border-bottom: 1px solid #ccc;
            padding-bottom: 2px;
        }
    </style>
    <section class="py-4">
        <div class="container">
            <div class="row justify-content-center form-bg pb-4">
                <div class="no-print">
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
                        class="col-md-10 bg-light p-4 rounded shadow-sm ">
                        @csrf
                        <div class="row g-3">

                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
                                    <div class="form-floating flex-grow-1">
                                        <input type="text" name="cnic" id="track_cnic" class="form-control"
                                            placeholder="xxxxx-xxxxxxx-x" value="{{ $applicant->cnic ?? old('cnic') }}"
                                            required maxlength="15">
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
                                            placeholder="Date of Birth" value="{{ $applicant->dob ?? old('dob') }}"
                                            required>
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
                </div>


                @if (isset($applicant))
                    <div class="page">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/ajklogo.png') }}" alt="AJK Logo" style="height: 70px; float: left;">
                            <div>
                                <h5>Government of Azad Jammu & Kashmir</h5>
                                <h4><strong>Small Industries Prime Minister Youth Loan Program</strong></h4>
                                <h6 class="text-muted">Application for the Loan</h6>
                            </div>
                            <img src="{{ asset('images/logo.png') }}" alt="Small Industries Logo"
                                style="height: 70px; float: right;">
                        </div>

                        <div class="section-title">Applicant Details</div>
                        <div class="info-row">
                            <div class="info-label">Applicant's Name:</div>
                            <div class="info-value">{{ $applicant->name }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Father's Name:</div>
                            <div class="info-value">{{ $applicant->fatherName }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">CNIC:</div>
                            <div class="info-value">{{ $applicant->cnic }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">CNIC Issue Date:</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($applicant->cnic_issue_date)->format('d-M-Y') }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Date of Birth:</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($applicant->dob)->format('d-M-Y') }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Phone:</div>
                            <div class="info-value">{{ $applicant->phone }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Address:</div>
                            <div class="info-value">{{ $applicant->permanentAddress }}</div>
                        </div>

                        <div class="section-title">Business Information</div>
                        <div class="info-row">
                            <div class="info-label">Business Name:</div>
                            <div class="info-value">{{ $applicant->businessName }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Business Type:</div>
                            <div class="info-value">{{ $applicant->businessType }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Business Address:</div>
                            <div class="info-value">{{ $applicant->businessAddress }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Tier:</div>
                            <div class="info-value">{{ $applicant->tier }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Quota:</div>
                            <div class="info-value">{{ $applicant->quota }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">District:</div>
                            <div class="info-value">{{ $applicant->district->name ?? '-' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Tehsil:</div>
                            <div class="info-value">{{ $applicant->tehsil->name ?? '-' }}</div>
                        </div>

                        <div class="section-title">Application Status</div>
                        <div class="info-row">
                            <div class="info-label">Fee Status:</div>
                            <div class="info-value">{{ $applicant->fee_status }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Loan Status:</div>
                            <div class="info-value">{{ $applicant->status }}</div>
                        </div>

                        @if ($applicant->fee_status === 'paid')
                            <div class="section-title">Challan Details</div>
                            <div class="info-row">
                                <div class="info-label">Branch Name:</div>
                                <div class="info-value">{{ $applicant->branch_name ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Branch Code:</div>
                                <div class="info-value">{{ $applicant->branch_code ?? '-' }}</div>
                            </div>
                            <div class="my-3">
                                @if ($applicant->challan_image && file_exists(public_path('images/challans/' . $applicant->challan_image)))
                                    <img src="{{ asset('images/challans/' . $applicant->challan_image) }}"
                                        style="max-width: 100%; height: auto; border: 1px solid #ccc;">
                                @else
                                    <p>Challan Image: Not Uploaded</p>
                                @endif
                            </div>
                        @endif

                        <div class="section-title no-print">Important Instructions</div>
                        <ul class="no-print">
                            <li>Please keep this page saved or printed for your records.</li>
                            <li>Only one application is allowed per CNIC.</li>
                            <li>All information provided will be verified from NADRA and relevant institutions.</li>
                        </ul>

                        <div class="no-print mt-3 text-end">
                            <button onclick="window.print()" class="btn btn-primary">Print Application</button>
                        </div>
                    </div>
                @endif

                <!-- Info Box -->
                <div class="col-md-10 mt-4 no-print">
                    <div class="alert alert-info border-0">
                        <strong>Note:</strong> Please enter the CNIC, issue date, and Date of Birth used in the original
                        application. The status will only appear if all details are correctly entered.
                    </div>
                </div>


            </div>

        </div>
    </section>

    @push('scripts')
    @endpush
@endsection
