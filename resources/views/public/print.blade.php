    @extends('layouts.master-print')
    @push('style')
        <style>
            @page {
                size: A4;
                margin: 0;
            }

            body {
                margin: 0;
                font-size: 12pt;
            }

            .page {
                width: 210mm;
                min-height: 297mm;
                padding: 8mm;
                margin: auto;
                background: #fff;
            }

            .page-heading {
                padding: 12px 0px;
                border-style: none none double none;
            }

            .section-title {
                font-weight: bold;
                font-size: 14pt;
                margin-top: 20px;
                border-bottom: 2px solid #222222;
                padding-bottom: 5px;
            }

            .info-row {
                display: flex;
                justify-content: space-between;
                padding: 6px 0;
                border-bottom: 1px dashed #514d4d;
            }

            .info-label {
                font-weight: 600;
                flex: 0 0 50%;
            }

            .info-value {
                flex: 1;
            }

            .no-print {
                display: none;
            }

            .footer-note {
                font-size: 12px;
                color: #555;
                border-top: 1px solid #ccc;
                padding-top: 8px;
                margin-top: 20px;
                text-align: center;
            }

            @media screen {
                .no-print {
                    display: block;
                }
            }

            @media print {
                .footer-note {
                    position: fixed;
                    bottom: 10px;
                    left: 0;
                    right: 0;
                }
            }
        </style>
    @endpush
    @section('content')
        <div class="page">
            {{-- Header --}}
            <div class="d-flex align-items-center justify-content-between page-heading mb-4 text-center" style="gap: 10px;">
                <img src="{{ asset('/assets/img/public/ajklogo.png') }}" alt="AJK Logo" style="height: 100px;">

                <div class="flex-grow-1 text-center">
                    <h5 class="mb-1">Government of Azad Jammu & Kashmir</h5>
                    <h4 class="mb-1"><strong>Prime Minister Youth Loan Program</strong></h4>
                    <h6 class="text-muted">Application for the Loan</h6>
                </div>

                <img src="{{ asset('/assets/img/public/logo.png') }}" alt="Small Industries Logo" style="height: 100px;">
            </div>
            {{-- Applicant Details --}}
            <div class="section-title">Applicant Details</div>
            <div class="row">
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">Applicant's Name:</div>
                        <div class="info-value">{{ $applicant->name }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">Father's Name:</div>
                        <div class="info-value">{{ $applicant->fatherName }}</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">CNIC:</div>
                        <div class="info-value">{{ $applicant->cnic }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">CNIC Issue Date:</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($applicant->cnic_issue_date)->format('d-M-Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">Date of Birth:</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($applicant->dob)->format('d-M-Y') }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">Phone:</div>
                        <div class="info-value">{{ $applicant->phone }}</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="info-row">
                        <div class="info-label">Address:</div>
                        <div class="info-value">{{ $applicant->permanentAddress }}</div>
                    </div>
                </div>
            </div>

            {{-- Business Information --}}
            <div class="section-title">Business Information</div>
            <div class="row">
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">Business Name:</div>
                        <div class="info-value">{{ $applicant->businessName }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">Business Type:</div>
                        <div class="info-value">{{ $applicant->businessType }}</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="info-row">
                        <div class="info-label">Business Address:</div>
                        <div class="info-value">{{ $applicant->businessAddress }}</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">Tier:</div>
                        <div class="info-value">
                            @if ($applicant->tier == 1)
                                Tier 1 (Up to 5 Lakh)
                            @elseif($applicant->tier == 2)
                                Tier 2 (5 to 10 Lakh)
                            @else
                                Tier 3 (10 to 20 Lakh)
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">Quota:</div>
                        <div class="info-value">{{ $applicant->quota }}</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">District:</div>
                        <div class="info-value">{{ $applicant->district->name ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">Tehsil:</div>
                        <div class="info-value">{{ $applicant->tehsil->name ?? '-' }}</div>
                    </div>
                </div>
            </div>

            {{-- Education --}}
            <div class="section-title">Educations</div>
            <div class="row">
                @foreach ($applicant->educations as $ed)
                    <div class="col-6">
                        <div class="info-row">
                            <div class="info-label">Education Level:</div>
                            <div class="info-value">{{ $ed->education_level }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Status --}}
            <div class="section-title">Application Status</div>
            <div class="row">
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">Challan Fee:</div>
                        <div class="info-value">
                            {{ challanFee($applicant->tier) }}
                            {!! $applicant->fee_status == 'paid'
                                ? '<span class="badge bg-success">Paid</span>'
                                : '<span class="badge bg-danger">Unpaid</span>' !!}
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="info-row">
                        <div class="info-label">Loan Status:</div>
                        <div class="info-value">{{ $applicant->status }}</div>
                    </div>
                </div>
            </div>

            {{-- Challan Details --}}
            @if ($applicant->fee_status === 'paid')
                <div class="section-title mb-3">Challan Details</div>
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="info-row d-flex">
                            <div class="info-label fw-bold me-2">Branch Name:</div>
                            <div class="info-value">{{ $applicant->feeBranch->branch_name ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-row d-flex">
                            <div class="info-label fw-bold me-2">Branch Code:</div>
                            <div class="info-value">{{ $applicant->feeBranch->branch_code ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Footer Note -->
            <div class="footer-note text-center mt-4">
                <small>
                    Empowering youth through accessible business loans under the vision of the Prime Minister.
                </small>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                window.print();
            });
        </script>
    @endpush
