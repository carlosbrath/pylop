@extends('layouts.master')

@section('title', 'Create Application')

@section('content')
    <main>
        @include('include.page_header')
        <div class="container-xl px-4 mt-4">
            <hr class="mt-0 mb-4" />

            <form method="POST" action="{{ route('applicant.store') }}" onsubmit="validateForm(event, this, 1)" enctype="multipart/form-data">
                @csrf

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
                    {{-- Left Column --}}
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header">Create New Application</div>
                            <div class="card-body">

                                <div class="mb-3">
                                    <label class="form-label">Applicant Name</label>
                                    <input class="form-control required" type="text" name="name" value="{{ old('name') }}"
                                       >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Father's Name</label>
                                    <input class="form-control required" type="text" name="fatherName"
                                        value="{{ old('fatherName') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">CNIC</label>
                                    <input class="form-control required" type="text" name="cnic" value="{{ old('cnic') }}"
                                        placeholder="12345-1234567-1">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">CNIC Issue Date</label>
                                    <input class="form-control required" type="date" name="cnic_issue_date"
                                        value="{{ old('cnic_issue_date') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input class="form-control required" type="date" name="dob" value="{{ old('dob') }}"
                                       >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input class="form-control required" type="text" name="phone" value="{{ old('phone') }}"
                                        placeholder="03XXXXXXXXX">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tier</label>
                                    <select class="form-control required" name="tier">
                                        <option value="">Select Tier</option>
                                        <option value="1" {{ old('tier') == '1' ? 'selected' : '' }}>Tier 1 (Up to 5
                                            Lakh)</option>
                                        <option value="2" {{ old('tier') == '2' ? 'selected' : '' }}>Tier 2 (5 - 10
                                            Lakh)</option>
                                        <option value="3" {{ old('tier') == '3' ? 'selected' : '' }}>Tier 3 (10 - 20
                                            Lakh)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Loan Amount</label>
                                    <input class="form-control required" type="text" name="amount" value="{{ old('amount') }}"
                                       >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Business Name</label>
                                    <input class="form-control required" type="text" name="businessName"
                                        value="{{ old('businessName') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Business Type</label>
                                    <select class="form-control required" name="businessType">
                                        <option value="">Select Type</option>
                                        <option value="New" {{ old('businessType') == 'New' ? 'selected' : '' }}>New
                                        </option>
                                        <option value="Running" {{ old('businessType') == 'Running' ? 'selected' : '' }}>
                                            Running</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Quota</label>
                                    <select class="form-control required" name="quota">
                                        <option value="">Select Quota</option>
                                        <option value="Men" {{ old('quota') == 'Men' ? 'selected' : '' }}>Men</option>
                                        <option value="Women" {{ old('quota') == 'Women' ? 'selected' : '' }}>Women
                                        </option>
                                        <option value="Disabled" {{ old('quota') == 'Disabled' ? 'selected' : '' }}>
                                            Disabled</option>
                                        <option value="Transgender" {{ old('quota') == 'Transgender' ? 'selected' : '' }}>
                                            Transgender</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="business_category_id" class="small mb-1">Business Category</label>
                                    <select class="form-select" name="business_category_id" id="business_category_id"
                                       >
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ old('business_category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="business_sub_category_id" class="small mb-1">Business Subcategory</label>
                                    <select class="form-select" name="business_sub_category_id"
                                        id="business_sub_category_id">
                                        <option value="">Select Subcategory</option>
                                        {{-- Will populate via AJAX --}}
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="district_id" class="small mb-1">District</label>
                                    <select class="form-select" name="district_id" id="district_id">
                                        <option value="">Select District</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}"
                                                {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tehsil_id" class="small mb-1">Tehsil</label>
                                    <select class="form-select" name="tehsil_id" id="tehsil_id">
                                        <option value="">Select Tehsil</option>
                                        {{-- Will populate via AJAX --}}
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Business Address</label>
                                    <textarea class="form-control required" name="businessAddress" rows="3">{{ old('businessAddress') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Permanent Address</label>
                                    <textarea class="form-control required" name="permanentAddress" rows="3">{{ old('permanentAddress') }}</textarea>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <div class="card-header mb-3 d-flex justify-content-between">
                                        <label class="form-label text-dark">Educational Background</label>
                                    </div>

                                    <div class="border rounded p-3 bg-white" id="adminEducationSection">
                                        <span class="text-primary d-block mb-4">
                                            * Add applicant’s highest level of education only.
                                        </span>

                                        <div id="adminEducationRepeater">
                                            <div class="row g-3 mb-3 admin-education-entry">
                                                {{-- Education Level --}}
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="small mb-1">Education Level<span
                                                                class="text-danger">*</span></label>
                                                        <select name="educations[0][education_level]"
                                                            class="form-select required admin-education-level">
                                                            <option value="">Select</option>
                                                            <option value="Illiterate">Illiterate / ناخواندہ</option>
                                                            <option value="Primary">Primary / پرائمری</option>
                                                            <option value="Middle">Middle / مڈل</option>
                                                            <option value="Matric">Matric / میٹرک</option>
                                                            <option value="Intermediate">Intermediate / انٹرمیڈیٹ</option>
                                                            <option value="Diploma">Diploma / ڈپلومہ</option>
                                                            <option value="Bachelor 14 Years">Bachelor (14 Years) / بیچلر
                                                                (14 سال)</option>
                                                            <option value="Bachelor 16 Years">Bachelor (16 Years) / بیچلر
                                                                (16 سال)</option>
                                                            <option value="Master 16 Years">Master (16 Years) / ماسٹر (16
                                                                سال)</option>
                                                            <option value="Master 18 Years">Master (18 Years) / ماسٹر (18
                                                                سال)</option>
                                                            <option value="MPhil">MPhil / ایم فل</option>
                                                            <option value="PhD">PhD / پی ایچ ڈی</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- Degree Title --}}
                                                <div class="col-md-4 admin-degree-fields">
                                                    <div class="mb-3">
                                                        <label class="small mb-1">Degree/Diploma Title
                                                            عنوان</label>
                                                        <input type="text" name="educations[0][degree_title]"
                                                            class="form-control required"
                                                            placeholder="Enter degree or diploma title">
                                                    </div>
                                                </div>

                                                {{-- Institute --}}
                                                <div class="col-md-3 admin-degree-fields">
                                                    <div class="mb-3">
                                                        <label class="small mb-1">Institute / ادارہ</label>
                                                        <input type="text" name="educations[0][institute]"
                                                            class="form-control required" placeholder="Enter institute name">
                                                    </div>
                                                </div>

                                                {{-- Remove Button --}}
                                                <div class="col-md-1 d-flex align-items-center">
                                                    <button type="button"
                                                        class="btn btn-danger remove-admin-education d-none">
                                                        <i data-feather="trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end admin-degree-fields">
                                            <button type="button" class="btn btn-success" id="addMoreAdminEducation"><i data-feather="plus-square"></i></button>
                                        </div>
                                    </div>
                                </div>


                                <div class="text-end">
                                    <button class="btn btn-primary" type="submit"><i data-feather="check-circle"></i> Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- Right Column --}}
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">Upload Documents</div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <label class="form-label">CNIC Front (Optional)</label>
                                    <input type="file" name="cnic_front" class="form-control required mt-2" accept="image/*">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">CNIC Back (Optional)</label>
                                    <input type="file" name="cnic_back" class="form-control required mt-2" accept="image/*">
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

                districtSelect.addEventListener('change', function() {
                    fetchonChangeSelect(districtSelect, tehsilSelect, 'get.tehsils');
                    fetchonChangeSelect(districtSelect, null, 'get.branches'); // if branch needed
                });

                categorySelect.addEventListener('change', function() {
                    fetchonChangeSelect(categorySelect, subcategorySelect, 'get.subcategories');
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                // Initial binding for the first select
                document.querySelectorAll('.admin-education-level').forEach(bindAdminEducationSelect);

                function bindAdminEducationSelect(selectEl) {
                    toggleAdminDegreeFields(selectEl);
                    selectEl.addEventListener('change', () => toggleAdminDegreeFields(selectEl));
                }

                function toggleAdminDegreeFields(selectEl) {
                    const entry = selectEl.closest('.admin-education-entry');
                    const degreeFields = entry.querySelectorAll('.admin-degree-fields');
                    if (selectEl.value === 'Illiterate') {
                        degreeFields.forEach(f => f.classList.add('d-none'));
                    } else {
                        degreeFields.forEach(f => f.classList.remove('d-none'));
                    }
                }

                let adminEducationIndex = 1;
                const repeater = document.getElementById('adminEducationRepeater');

                document.getElementById('addMoreAdminEducation').addEventListener('click', function() {
                    const template = repeater.querySelector('.admin-education-entry');
                    const clone = template.cloneNode(true);
                    const inputs = clone.querySelectorAll('input, select');

                    // Update names & reset values
                    inputs.forEach(input => {
                        const name = input.getAttribute('name');
                        if (name) {
                            input.setAttribute('name', name.replace(/\[\d+\]/,
                                `[${adminEducationIndex}]`));
                            input.value = '';
                        }
                    });

                    // Show & bind remove button
                    const removeBtn = clone.querySelector('.remove-admin-education');
                    removeBtn.classList.remove('d-none');
                    removeBtn.addEventListener('click', () => clone.remove());

                    // Rebind select change event
                    const selectEl = clone.querySelector('.admin-education-level');
                    bindAdminEducationSelect(selectEl);

                    repeater.appendChild(clone);
                    adminEducationIndex++;
                });

                // Remove handler for first row if needed
                document.querySelectorAll('.remove-admin-education').forEach(btn => {
                    btn.addEventListener('click', () => btn.closest('.admin-education-entry').remove());
                });
            });
        </script>
    @endpush
@endsection
