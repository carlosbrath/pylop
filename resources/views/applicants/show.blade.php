@extends('layouts.master')

@section('title', 'Application Details')

@section('content')
    <main>
        <div class="container-xl px-4 mt-4">
            @if (isset($applicant))
                <div class="row">
                    <!-- Left: Application Preview -->

                    <div class="col-lg-8  print-area">
                        @include('include.alerts')
                        <div class="card mb-4">
                            <div class="card-body page">
                                @if($applicant->status =='Pending' || $applicant->status =='NotCompleted')
                                <div class="d-flex justify-content-end mb-2 no-print">
                                    <a href="{{ route('applicant.edit', $applicant->id) }}" class="btn btn-outline-teal">
                                        <i class="bi bi-pencil-square"></i> Edit Application
                                    </a>
                                </div>
                                @endif
                                <div class="d-flex align-items-center justify-content-between mb-4 text-center"
                                    style="gap: 10px;">
                                    <img src="{{ asset('/assets/img/public/ajklogo.png') }}" style="height: 100px;"
                                        alt="AJK Logo">
                                    <div class="flex-grow-1">
                                        <h5>Government of Azad Jammu & Kashmir</h5>
                                        <h4><strong>Prime Minister Youth Loan Program</strong></h4>
                                        <h6 class="text-muted">Application for the Loan</h6>
                                    </div>
                                    <img src="{{ asset('/assets/img/public/logo.png') }}" style="height: 100px;"
                                        alt="Industry Logo">
                                </div>

                                <h5 class="mt-4">Applicant Details</h5>
                                <x-info-row label="Name" :value="$applicant->name" />
                                <x-info-row label="Father's Name" :value="$applicant->fatherName" />
                                <x-info-row label="CNIC" :value="$applicant->cnic" />
                                <x-info-row label="CNIC Issue Date" :value="\Carbon\Carbon::parse($applicant->cnic_issue_date)->format('d-M-Y')" />
                                <x-info-row label="Date of Birth" :value="\Carbon\Carbon::parse($applicant->dob)->format('d-M-Y')" />
                                <x-info-row label="Phone" :value="$applicant->phone" />
                                <x-info-row label="Permanent Address" :value="$applicant->permanentAddress" />

                                <h5 class="mt-4">Business Information</h5>
                                <x-info-row label="Business Name" :value="$applicant->businessName" />
                                <x-info-row label="Business Type" :value="$applicant->businessType" />
                                <x-info-row label="Business Address" :value="$applicant->businessAddress" />
                                <x-info-row label="Tier" :value="tierLabel($applicant->tier)" />
                                <x-info-row label="Quota" :value="$applicant->quota" />
                                <x-info-row label="District" :value="$applicant->district->name ?? '-'" />
                                <x-info-row label="Tehsil" :value="$applicant->tehsil->name ?? '-'" />

                                <h5 class="mt-4">Education</h5>
                                @foreach ($applicant->educations as $ed)
                                    <x-info-row label="Education Level" :value="$ed->education_level" />
                                @endforeach

                                <h5 class="mt-4">Application Status</h5>
                                <x-info-row label="Challan Fee" :value="number_format(challanFee($applicant->tier)) .
                                    ' ' .
                                    ($applicant->fee_status == 'paid' ? '(Paid)' : '(Unpaid)')" />
                                <x-info-row label="Loan Status" :value="$applicant->status" />

                                @if ($applicant->fee_status === 'paid')
                                    <h5 class="mt-4">Challan Details</h5>
                                    <x-info-row label="Branch Name" :value="$applicant->feeBranch->branch_name ?? '-'" />
                                    <x-info-row label="Branch Code" :value="$applicant->feeBranch->branch_code ?? '-'" />
                                @endif

                                <div class="no-print mt-4 text-end">
                                    <div id="approve-section">
                                        @if ($applicant->status === 'Approved' || $applicant->status === 'Pending' || $applicant->status === 'Approved' )
                                            <button type="button"
                                                onclick="remarks('{{ route('applicants.reject', $applicant->id) }}','approveForm', 'approve-section')"
                                                class="btn btn-success d-inline" id="approveBtn">Approve</button>
                                        @endif
                                        @if ($applicant->status === 'Pending')
                                            <button type="button"
                                                onclick="remarks('{{ route('applicants.approve', $applicant->id) }}','approveForm', 'approve-section')"
                                                class="btn btn-success d-inline" id="approveBtn">Approve</button>
                                        @endif

                                        @if ($applicant->status === 'Approved')
                                            <button type="button" class="btn btn-success d-inline"
                                                onclick="remarks('{{ route('applicants.forward', $applicant->id) }}','approveForm', 'approve-section')"
                                                id="forwordbtnBtn">Forward to Bank</button>
                                        @endif
                                        <button onclick="window.print()" class="btn btn-primary">Print Application</button>
                                    </div>
                                    <div id="remarks-section">
                                        <!-- Hidden form -->
                                        <form action="{{ route('applicants.approve', $applicant->id) }}" method="POST"
                                            id="approveForm" class="mt-2 d-none">
                                            @csrf
                                            <div class="mb-2">
                                                <textarea name="remarks" class="form-control" rows="3" placeholder="Enter approval remarks..." required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-success">Confirm</button>
                                            <button type="button" class="btn btn-secondary"
                                                id="cancelApprove">Cancel</button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Remarks History</h5>
                            </div>
                            <div class="card-body">
                                @if ($remarks->count())
                                    <div class="space-y-2">
                                        @foreach ($remarks as $log)
                                            <div class="border rounded p-3 mb-2">
                                                <x-info-row label="Old Status" :value="$log->old_status ?? '-'" />
                                                <x-info-row label="New Status" :value="$log->new_status ?? '-'" />
                                                <x-info-row label="Changed By" :value="$log->actor->name ?? 'System'" />
                                                <x-info-row label="Remarks" :value="$log->remarks ?? '-'" />
                                                <x-info-row label="Changed At" :value="$log->created_at->format('d M Y h:i A')" />
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">No remarks found.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right: Uploaded Images -->
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">Uploaded Documents</div>
                            <div class="card-body text-center">
                                <h6>CNIC Front</h6>
                                @if ($applicant->cnic_front)
                                    <img src="{{ asset('uploads/cnic/' . $applicant->cnic_front) }}"
                                        class="img-fluid mb-3 border" style="height: 200px;">
                                @else
                                    <p>Not Uploaded</p>
                                @endif

                                <h6>CNIC Back</h6>
                                @if ($applicant->cnic_back)
                                    <img src="{{ asset('uploads/cnic/' . $applicant->cnic_back) }}"
                                        class="img-fluid mb-3 border" style="height: 200px;">
                                @else
                                    <p>Not Uploaded</p>
                                @endif

                                <h6>Challan Image</h6>
                                @if ($applicant->challan_image)

                                    @if ($applicant->challan_image && file_exists(public_path('uploads/challans/' . $applicant->challan_image)))
                                        <img src="{{ asset('uploads/challans/' . $applicant->challan_image) }}"
                                            class="img-fluid border" style="height: 200px;">
                                    @else
                                        <p>Challan Image: Not Uploaded</p>
                                    @endif
                                @else
                                    <p>Not Uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
    @push('scripts')
        <script>
            function remarks(url, targetId, targetId2) {
                const form = document.getElementById(targetId);
                const approveSection = document.getElementById(targetId2);
                form.action = url;
                form.classList.remove("d-none");
                approveSection.classList.add("d-none");
                const cancelApprove = form.querySelector("#cancelApprove");
                if (cancelApprove) {
                    cancelApprove.addEventListener("click", function() {
                        approveSection.classList.remove("d-none");
                        form.classList.add("d-none");
                    });
                }
            }
        </script>
    @endpush

@endsection
