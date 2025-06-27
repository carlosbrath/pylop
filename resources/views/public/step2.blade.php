@extends('layouts.master-public')
@section('title', $title ?? 'Dashboard')
@section('content')
    <section id="secondSection" class="signup-step-container py-4 ">
        <div class="container">
            <div class="row d-flex justify-content-center form-bg pb-4">
                <div class="row justify-content-center bg-primary blue-gradient text-white py-3 mb-4">
                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <h2 class="mb-0 text-center w-100">
                            AJK PM Youth Loan Program - Application Form
                        </h2>
                    </div>
                </div>

                <div class="row g-3 py-4">
                    <div class="col-md-5">
                        <ul class="list-unstyled text-muted">
                            <li>It is mandatory to fill the required information in all sections with * mark.</li>
                            <li>You can submit your suggestions/feedback/complaints regarding the (PMYB&amp;ALS) at Citizen
                                Portal App.</li>
                            <li>Please ensure to fill in the required fields of Applicant’s cnic Number, cnic Issue date and
                                dob correctly as they will be verified by NADRA.</li>
                        </ul>
                    </div>

                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                        <a href="/pmyphome/index" style="cursor: pointer;">
                            <img src="./images/pmyp-01.png" alt="PMYP Logo" class="img-fluid px-3">
                        </a>
                    </div>

                    <div class="col-md-5 text-end">
                        <ul class="list-unstyled" dir="rtl" style="text-align: right;">
                            <li>تمام سیکشن میں *کے نشان پر مطلوبہ معلومات درج کرنا لازم ہے</li>
                            <li>آپ سٹیزن پورٹل ایپ پر (PMYB&amp;ALS) سے متعلق اپنی تجاویز/فیڈبیک/شکایات جمع کرا سکتے ہیں۔
                            </li>
                            <li>براہ کرم درخواست دہندہ کے cnic نمبر، cnic جاری کرنے کی تاریخ اور dob کو درست طریقے سے پُر
                                کرنا یقینی بنائیں کیونکہ ان کی نادرا سے تصدیق کی جائے گی</li>
                        </ul>
                    </div>
                </div>


                <div class="col-12">
                    <div class="wizard">
                        <form id="initialForm" class="row g-3 mt-3" method="POST" action="{{ route('storeForm') }}">
                            @csrf

                            {{-- Validation Error Display --}}
                            @if ($errors->any())
                                <div class="alert alert-danger w-100">
                                    <strong>Whoops! Something went wrong:</strong>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="tab-content" id="main_form">
                                <div class="tab-pane active" role="tabpanel" id="step1">
                                    <!-- Section Header -->
                                    <div class="bg-success text-white py-2 px-3 mb-4 rounded">
                                        <div class="row">
                                            <h4 class="col-lg-6">A: PERSONAL INFORMATION</h4>
                                            <h4 class="col-lg-6 text-end"><strong>ذاتی معلومات</strong></h4>
                                        </div>
                                    </div>

                                    <!-- Form Fields -->
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">
                                                Applicant's Name <span class="text-danger">*</span>
                                                <span class="text-end float-end" dir="rtl">درخواست گزار کا نام</span>
                                            </label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name') }}" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="fatherName" class="form-label">
                                                Father Name <span class="text-danger">*</span>
                                                <span class="text-end float-end" dir="rtl">والد کا نام</span>
                                            </label>
                                            <input type="text" class="form-control" id="fatherName" name="fatherName"
                                                value="{{ old('fatherName') }}" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="cnic" class="form-label">
                                                CNIC Number <span class="text-danger">*</span>
                                                <span class="text-end float-end" dir="rtl">شناختی کارڈ نمبر</span>
                                            </label>
                                            <input type="text" class="form-control" id="cnic" name="cnic"
                                                placeholder="xxxxx-xxxxxxx-x" value="{{ old('cnic', $cnic ?? '') }}"
                                                required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="cnic_issue_date" class="form-label">
                                                CNIC Issue Date <span class="text-danger">*</span>
                                                <span class="float-end text-secondary" dir="rtl">شناختی کارڈ کے اجراء
                                                    کی تاریخ</span>
                                            </label>
                                            <input type="date" name="cnic_issue_date" id="cnic_issue_date"
                                                class="form-control" value="{{ old('cnic_issue_date', $issueDate ?? '') }}"
                                                required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="tier" class="form-label">
                                                Tier <span class="float-end text-secondary" dir="rtl">درجہ</span>
                                            </label>
                                            <select class="form-select" name="tier" id="tier" required>
                                                <option disabled selected>Select Tier</option>
                                                <option value="1"
                                                    {{ old('tier', $tier ?? '') == 1 ? 'selected' : '' }}>Tier 1 (Up to 5
                                                    Lakhs)</option>
                                                <option value="2"
                                                    {{ old('tier', $tier ?? '') == 2 ? 'selected' : '' }}>Tier 2 (5 - 10
                                                    Lakhs)</option>
                                                <option value="3"
                                                    {{ old('tier', $tier ?? '') == 3 ? 'selected' : '' }}>Tier 3 (10 - 20
                                                    Lakhs)</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="dob" class="form-label">
                                                Date of Birth <span class="text-danger">*</span>
                                                <span class="text-end float-end" dir="rtl">تاریخ پیدائش</span>
                                            </label>
                                            <input type="date" class="form-control" id="dob" name="dob"
                                                value="{{ old('dob') }}" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="gender" class="form-label">
                                                Gender <span class="text-danger">*</span>
                                                <span class="text-end float-end" dir="rtl">صنف</span>
                                            </label>
                                            <select class="form-select" id="gender" name="gender" required>
                                                <option disabled selected value="">Select Gender</option>
                                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>
                                                    Male / مرد</option>
                                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                                    Female / عورت</option>
                                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>
                                                    Other / دیگر</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">
                                                Phone Number <span class="text-danger">*</span>
                                                <span class="text-end float-end" dir="rtl">فون نمبر</span>
                                            </label>
                                            <input type="tel" class="form-control" id="phone" name="phone"
                                                placeholder="03XXXXXXXXX" value="{{ old('phone') }}" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="businessName" class="form-label">
                                                Business Name <span class="text-danger">*</span>
                                                <span class="text-end float-end" dir="rtl">کاروبار کا نام</span>
                                            </label>
                                            <input type="text" class="form-control" id="businessName"
                                                name="businessName" value="{{ old('businessName') }}" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="businessType" class="form-label">
                                                Business Info <span class="text-danger">*</span>
                                                <span class="text-end float-end" dir="rtl">کاروبار کی نوعیت</span>
                                            </label>
                                            <select class="form-select" id="businessType" name="businessType" required>
                                                <option disabled selected value="">Select Type</option>
                                                <option value="New"
                                                    {{ old('businessType') == 'New' ? 'selected' : '' }}>New / نیا</option>
                                                <option value="Running"
                                                    {{ old('businessType') == 'Running' ? 'selected' : '' }}>Running / جاری
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="district" class="form-label">
                                                District <span class="text-danger">*</span>
                                                <span class="text-end float-end" dir="rtl">ضلع</span>
                                            </label>
                                            <select class="form-select" id="district" name="district" required>
                                                <option disabled selected value="">Select District</option>
                                                @php
                                                    $districts = [
                                                        'Muzaffarabad',
                                                        'Neelum',
                                                        'Hattian Bala',
                                                        'Bagh',
                                                        'Haveli',
                                                        'Poonch',
                                                        'Sudhnoti',
                                                        'Kotli',
                                                        'Mirpur',
                                                        'Bhimber',
                                                    ];
                                                @endphp
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district }}"
                                                        {{ old('district') == $district ? 'selected' : '' }}>
                                                        {{ $district }} / {{ __('urdu.' . $district) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="quota" class="form-label">
                                                Quota <span class="text-danger">*</span>
                                                <span class="text-end float-end" dir="rtl">کوٹہ</span>
                                            </label>
                                            <select class="form-select" id="quota" name="quota" required>
                                                <option disabled selected value="">Select Quota</option>
                                                <option value="Men" {{ old('quota') == 'Men' ? 'selected' : '' }}>Men /
                                                    مرد</option>
                                                <option value="Women" {{ old('quota') == 'Women' ? 'selected' : '' }}>
                                                    Women / خواتین</option>
                                                <option value="Disabled"
                                                    {{ old('quota') == 'Disabled' ? 'selected' : '' }}>Disabled / معذور
                                                </option>
                                                <option value="Transgender"
                                                    {{ old('quota') == 'Transgender' ? 'selected' : '' }}>Transgender /
                                                    خواجہ سرا</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="PermanentAddress" class="form-label">
                                                Permanent Address <span class="text-danger">*</span>
                                                <span class="text-end float-end" dir="rtl">مستقل پتہ</span>
                                            </label>
                                            <textarea class="form-control" id="PermanentAddress" name="PermanentAddress" rows="2" required>{{ old('PermanentAddress') }}</textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="CurrentAddress" class="form-label">
                                                Current Address <span class="text-danger">*</span>
                                                <span class="text-end float-end" dir="rtl">عارضی پتہ</span>
                                            </label>
                                            <textarea class="form-control" id="CurrentAddress" name="CurrentAddress" rows="2" required>{{ old('CurrentAddress') }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
                $('input[name="phone"]').mask('00000000000');
            });
        </script>
    @endpush
@endsection
