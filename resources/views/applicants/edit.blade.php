@extends('layouts.master')

@section('title', 'Edit Application')

@section('content')
    <main>
        @include('include.page_header')
        <div class="container-xl px-4 mt-4">
            <hr class="mt-0 mb-4" />
            <form method="POST" action="{{ route('applicant.update', $applicant->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header">Edit Application</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Applicant Name</label>
                                    <input class="form-control" type="text" name="name"
                                        value="{{ old('name', $applicant->name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Father's Name</label>
                                    <input class="form-control" type="text" name="fatherName"
                                        value="{{ old('fatherName', $applicant->fatherName) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CNIC</label>
                                    <input class="form-control" type="text" name="cnic"
                                        value="{{ old('cnic', $applicant->cnic) }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CNIC Issue Date</label>
                                    <input class="form-control" type="date" name="cnic_issue_date"
                                        value="{{ old('cnic_issue_date', $applicant->cnic_issue_date) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input class="form-control" type="date" name="dob"
                                        value="{{ old('dob', $applicant->dob) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input class="form-control" type="text" name="phone"
                                        value="{{ old('phone', $applicant->phone) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tier</label>
                                    <select class="form-control" name="tier" required>
                                        <option value="1" {{ $applicant->tier == '1' ? 'selected' : '' }}>Tier 1 (Up to
                                            5 Lakh)</option>
                                        <option value="2" {{ $applicant->tier == '2' ? 'selected' : '' }}>Tier 2 (5 -
                                            10 Lakh)</option>
                                        <option value="3" {{ $applicant->tier == '3' ? 'selected' : '' }}>Tier 3 (10 -
                                            20 Lakh)</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Loan Amount</label>
                                    <input class="form-control" type="number" name="amount"
                                        value="{{ old('amount', $applicant->amount) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Business Name</label>
                                    <input class="form-control" type="text" name="businessName"
                                        value="{{ old('businessName', $applicant->businessName) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Business Type</label>
                                    <select class="form-control" name="businessType" required>
                                        <option value="New" {{ $applicant->businessType == 'New' ? 'selected' : '' }}>
                                            New</option>
                                        <option value="Running"
                                            {{ $applicant->businessType == 'Running' ? 'selected' : '' }}>Running</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Quota</label>
                                    <select class="form-control" name="quota" required>
                                        <option value="Men" {{ $applicant->quota == 'Men' ? 'selected' : '' }}>Men
                                        </option>
                                        <option value="Women" {{ $applicant->quota == 'Women' ? 'selected' : '' }}>Women
                                        </option>
                                        <option value="Disabled" {{ $applicant->quota == 'Disabled' ? 'selected' : '' }}>
                                            Disabled</option>
                                        <option value="Transgender"
                                            {{ $applicant->quota == 'Transgender' ? 'selected' : '' }}>Transgender</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="business_category_id" class="small mb-1">Business Category</label>
                                    <select class="form-select" name="business_category_id" id="business_category_id"
                                        required>
                                        <option value="" disabled>Select Category</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ $cat->id == $applicant->business_category_id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="business_sub_category_id" class="small mb-1">Business Subcategory</label>
                                    <select class="form-select" name="business_sub_category_id"
                                        id="business_sub_category_id" required>
                                        <option value="" disabled>Select Subcategory</option>
                                        @foreach ($subcategories as $sub)
                                            <option value="{{ $sub->id }}"
                                                {{ $sub->id == $applicant->business_sub_category_id ? 'selected' : '' }}>
                                                {{ $sub->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="district_id" class="small mb-1">District</label>
                                    <select class="form-select" name="district_id" id="district_id" required>
                                        <option value="" disabled>Select District</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}"
                                                {{ $district->id == $applicant->district_id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tehsil_id" class="small mb-1">Tehsil</label>
                                    <select class="form-select" name="tehsil_id" id="tehsil_id" required>
                                        <option value="" disabled>Select Tehsil</option>
                                        @foreach ($tehsils as $tehsil)
                                            <option value="{{ $tehsil->id }}"
                                                {{ $tehsil->id == $applicant->tehsil_id ? 'selected' : '' }}>
                                                {{ $tehsil->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Business Address</label>
                                    <textarea class="form-control" name="businessAddress" rows="3" required>{{ old('businessAddress', $applicant->businessAddress) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Permanent Address</label>
                                    <textarea class="form-control" name="permanentAddress" rows="3" required>{{ old('permanentAddress', $applicant->permanentAddress) }}</textarea>
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-primary" type="submit">Update Application</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">Uploaded Documents</div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <label class="form-label">CNIC Front (Optional)</label><br>
                                    @if ($applicant->cnic_front)
                                        <img src="{{ asset('uploads/cnic/' . $applicant->cnic_front) }}"
                                            class="img-fluid mb-2" style="height:150px;">
                                    @endif
                                    <input type="file" name="cnic_front" class="form-control mt-2" accept="image/*">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CNIC Back (Optional)</label><br>
                                    @if ($applicant->cnic_back)
                                        <img src="{{ asset('uploads/cnic/' . $applicant->cnic_back) }}"
                                            class="img-fluid mb-2" style="height:150px;">
                                    @endif
                                    <input type="file" name="cnic_back" class="form-control mt-2" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const districtSelect = document.getElementById('district_id');
                const tehsilSelect = document.getElementById('tehsil_id');
                const categorySelect = document.getElementById('business_category_id');
                const subcategorySelect = document.getElementById('business_sub_category_id');
                const chosedBranch = document.getElementById('applicant_choosed_branch');

                districtSelect.addEventListener('change', function() {
                    fetchonChangeSelect(districtSelect, tehsilSelect, 'get.tehsils')
                    fetchonChangeSelect(districtSelect, chosedBranch, 'get.branches')
                });



                categorySelect.addEventListener('change', function() {
                    fetchonChangeSelect(categorySelect, subcategorySelect, 'get.subcategories')
                });
            });
        </script>
    @endpush
@endsection
