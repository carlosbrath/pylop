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
                        class="col-md-12 bg-light p-4 rounded shadow-sm ">
                        @csrf
                        <div class="row g-3">

                            <div class="col-4 offset-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
                                    <div class="form-floating flex-grow-1">
                                        <input type="text" name="cnic" id="track_cnic" class="form-control required"
                                            placeholder="xxxxx-xxxxxxx-x" value="{{ $applicant?->cnic ?? old('cnic') }}"
                                            required maxlength="15">
                                        <label for="track_cnic">CNIC / شناختی کارڈ نمبر <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    <div class="form-floating flex-grow-1">
                                        <input type="date" name="issue_date" id="track_issue_date" class="form-control"
                                            placeholder="CNIC Issue Date"
                                            value="{{ $applicant->cnic_issue_date ?? old('issue_date') }}" required>
                                        <label for="track_issue_date">CNIC Issue Date / اجراء کی تاریخ</label>
                                    </div>
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                    <div class="form-floating flex-grow-1">
                                        <input type="date" name="dob" id="track_dob" class="form-control"
                                            placeholder="Date of Birth" value="{{ $applicant->dob ?? old('dob') }}"
                                            required>
                                        <label for="track_dob">Date of Birth / تاریخ پیدائش</label>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-4 mt-3 pt-3">
                                <button type="submit" class="btn btn-success px-5">
                                    <i class="bi bi-search me-1"></i> Track Application
                                </button>
                            </div>
                        </div>
                    </form>
                </div>


                @if (isset($applicant))
                    <div class="page">
                        <div class="d-flex align-items-center justify-content-between mb-4 text-center" style="gap: 10px;">
                            <img src="https://sic.ajk.gov.pk/pmylp/public/images/ajklogo.png" alt="AJK Logo"
                                style="height: 100px;">

                            <div class="flex-grow-1 text-center">
                                <h5 class="mb-1">Government of Azad Jammu & Kashmir</h5>
                                <h4 class="mb-1"><strong>Prime Minister Youth Loan Program</strong></h4>
                                <h6 class="text-muted">Application for the Loan</h6>
                            </div>

                            <img src="https://sic.ajk.gov.pk/pmylp/public/images/logo.png" alt="Small Industries Logo"
                                style="height: 100px;">
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
                            <div class="info-value">
                                @if($applicant->tier==1)
                                    Tier 1 (Up to 5  Lakh)
                                @elseif($applicant->tier==2)
                                    Tier 1 (5 to 10  Lakh)
                                @else
                                    Tier 1 (10 to 20  Lakh)
                                @endif
                            </div>
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
                        <div class="section-title">Educations</div>
                        @foreach ($applicant->educations as $ed)
                            <div class="info-row">
                                <div class="info-label">Education Level:</div>
                                <div class="info-value">{{ $ed->education_level }}</div>
                            </div>
                        @endforeach

                        <div class="section-title">Application Status</div>
                        <div class="info-row">
                            <div class="info-label">Challan Fee</div>
                            <div class="info-value">{{ challanFee($applicant->tier)}} {!!($applicant->fee_status=='paid'?'<span class="badge bg-success"">Paid</span>':'<span class="badge bg-danger">Unpaid</span>')!!}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Loan Status:</div>
                            <div class="info-value">{{ $applicant->status }}</div>
                        </div>

                        @if ($applicant->fee_status === 'paid')
                            <div class="section-title">Challan Details</div>
                            <div class="info-row">
                                <div class="info-label">Branch Name:</div>
                                <div class="info-value">{{ $applicant->feeBranch->branch_name ?? '-' }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Branch Code:</div>
                                <div class="info-value">{{ $applicant->feeBranch->branch_code ?? '-' }}</div>
                            </div>
                            <div class="my-3 d-flex justify-content-end no-print">
                                @if ($applicant->challan_image && file_exists(public_path('uploads/challans/' . $applicant->challan_image)))
                                    <img src="{{ asset('uploads/challans/' . $applicant->challan_image) }}"
                                        style="max-width: 100%; width:300px; height:400px; height: auto; border: 1px solid #ccc;">
                                @else
                                    <p>Challan Image: Not Uploaded</p>
                                @endif
                            </div>
                        @endif

                        <div class="section-title no-print">Important Instructions</div>
                        <ul class="no-print">
                           <li>
                                <strong>Submit your challan</strong> at the nearest <strong>Bank of AJK branch</strong>.<br>
                                After submission, <strong>please upload a scanned copy or clear image</strong> of the challan below.
                            </li>
                            <li><strong>All information provided</strong> will be verified from <strong>NADRA</strong> and relevant institutions.</li>
                        </ul>

                        <div class="no-print mt-3 text-end">
                            <button onclick="window.print()" class="btn btn-primary">Print Application</button>
                        </div>
                    </div>
                    @if ($applicant->fee_status != 'paid')
                        <div class="md-col-10 no-print">
                            <form action="{{ route('upload.challan') }}" method="POST" enctype="multipart/form-data"
                                class="my-4 p-4 bg-white shadow-sm rounded">
                                <h3 class="mb-5">Fee informations</h3>
                                @csrf
                                <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="input-group position-relative">
                                            <span class="input-group-text"><i class="bi bi-bank"></i></span>
                                            <div class="form-floating flex-grow-1">
                                                <select id="branch_id" name="branch_id"
                                                    class="form-select custom-select2" required>
                                                    <option value="" disabled selected hidden>Select Branch</option>
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}">{{$branch->branch_code .' '. $branch->branch_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="branch_id">Branch Name</label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                                            <div class="form-floating flex-grow-1">
                                                <input type="text" class="form-control" id="branch_code"
                                                    name="branch_code" placeholder="Branch Code" required>
                                                <label for="branch_code">Branch Code</label>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                                            <div class="form-floating flex-grow-1">
                                                <input type="text" class="form-control" id="challan_fee"
                                                    name="challan_fee" placeholder="Enter Challan Fee" required>
                                                <label for="challan_fee">Enter Challan Fee</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text"><i
                                                    class="bi bi-file-earmark-arrow-up"></i></span>
                                            <div class="form-floating  has-file flex-grow-1">
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
                        </div>
                    @endif
                @endif


              


            </div>

        </div>
    </section>

    @push('scripts')
    @endpush
@endsection
