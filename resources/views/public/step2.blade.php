@extends('layouts.master-public')
@section('title', $title ?? 'Dashboard')
@section('style')
    <style>
        
    </style>
@endsection
@section('content')
    <section id="secondSection" class="signup-step-container py-4 ">
        <div class="container">
            <div class="row d-flex justify-content-center form-bg pb-4">
                <div class="row justify-content-center bg-primary green-gradient text-white py-3 mb-4">
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
                        <a href="{{ route('home') }}" style="cursor: pointer;">
                            <img src="{{ asset('./images/pmyp-01.png') }}" alt="PMYP Logo" class="img-fluid px-3">
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
                        <form id="initialForm" class="row g-3 mt-3 mx-2 px-3 pb-3 shadow-lg" method="POST"
                            action="{{ route('storeForm') }}" onsubmit="validateForm(event, this, 'step2')">
                            @csrf

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
                                    <div class="card shadow-sm border-0 mb-4">
                                        <div class="card-header bg-success text-white d-flex justify-content-between">
                                            <h5><i class="bi bi-person-badge-fill me-2"></i> Personal Information</h5>
                                            <h5 dir="rtl">ذاتی معلومات</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                @php
                                                    $formFields = [
                                                        [
                                                            'id' => 'name',
                                                            'icon' => 'person',
                                                            'type' => 'text',
                                                            'label' => "Applicant's Name",
                                                            'urdu' => 'درخواست گزار کا نام',
                                                        ],
                                                        [
                                                            'id' => 'fatherName',
                                                            'icon' => 'person-vcard',
                                                            'type' => 'text',
                                                            'label' => 'Father Name',
                                                            'urdu' => 'والد کا نام',
                                                        ],
                                                        [
                                                            'id' => 'cnic',
                                                            'icon' => 'credit-card-2-front',
                                                            'type' => 'text',
                                                            'label' => 'CNIC Number',
                                                            'urdu' => 'شناختی کارڈ نمبر',
                                                            'placeholder' => 'xxxxx-xxxxxxx-x',
                                                            'value' => old('cnic', $cnic ?? ''),
                                                        ],
                                                        [
                                                            'id' => 'cnic_issue_date',
                                                            'icon' => 'calendar-event',
                                                            'type' => 'date',
                                                            'label' => 'CNIC Issue Date',
                                                            'urdu' => 'شناختی کارڈ کے اجراء کی تاریخ',
                                                            'value' => old('cnic_issue_date', $issueDate ?? ''),
                                                        ],
                                                        [
                                                            'id' => 'dob',
                                                            'icon' => 'calendar-date',
                                                            'type' => 'date',
                                                            'label' => 'Date of Birth',
                                                            'urdu' => 'تاریخ پیدائش',
                                                        ],
                                                        [
                                                            'id' => 'phone',
                                                            'icon' => 'telephone',
                                                            'type' => 'tel',
                                                            'label' => 'Phone Number',
                                                            'urdu' => 'فون نمبر',
                                                            'placeholder' => '03XXXXXXXXX',
                                                        ],
                                                        [
                                                            'id' => 'businessName',
                                                            'icon' => 'briefcase',
                                                            'type' => 'text',
                                                            'label' => 'Business Name',
                                                            'urdu' => 'کاروبار کا نام',
                                                        ],
                                                        [
                                                            'id' => 'amount',
                                                            'icon' => 'currency-rupee',
                                                            'type' => 'number',
                                                            'label' => 'Loan Amount',
                                                            'urdu' => 'قرض کی رقم',
                                                        ],
                                                    ];

                                                    $selectFields = [
                                                        [
                                                            'id' => 'tier',
                                                            'label' => 'Tier / درجہ',
                                                            'icon' => 'diagram-3',
                                                            'options' => [
                                                                ['value' => '1', 'label' => 'Tier 1 (Up to 5 Lakhs)'],
                                                                ['value' => '2', 'label' => 'Tier 2 (5 - 10 Lakhs)'],
                                                                ['value' => '3', 'label' => 'Tier 3 (10 - 20 Lakhs)'],
                                                            ],
                                                        ],
                                                        [
                                                            'id' => 'gender',
                                                            'label' => 'Gender / صنف',
                                                            'icon' => 'gender-ambiguous',
                                                            'options' => [
                                                                ['value' => 'Male', 'label' => 'Male / مرد'],
                                                                ['value' => 'Female', 'label' => 'Female / عورت'],
                                                                ['value' => 'Other', 'label' => 'Other / دیگر'],
                                                            ],
                                                        ],
                                                        [
                                                            'id' => 'businessType',
                                                            'label' => 'Business Info / کاروبار کی نوعیت',
                                                            'icon' => 'building',
                                                            'options' => [
                                                                ['value' => 'New', 'label' => 'New / نیا'],
                                                                ['value' => 'Running', 'label' => 'Running / جاری'],
                                                            ],
                                                        ],
                                                        [
                                                            'id' => 'district',
                                                            'label' => 'District / ضلع',
                                                            'icon' => 'geo',
                                                            'options' => array_map(
                                                                function ($d) {
                                                                    return [
                                                                        'value' => $d,
                                                                        'label' => $d . ' / ' . __('urdu.' . $d),
                                                                    ];
                                                                },
                                                                [
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
                                                                ],
                                                            ),
                                                        ],
                                                        [
                                                            'id' => 'quota',
                                                            'label' => 'Quota / کوٹہ',
                                                            'icon' => 'people-fill',
                                                            'options' => [
                                                                ['value' => 'Men', 'label' => 'Men / مرد'],
                                                                ['value' => 'Women', 'label' => 'Women / خواتین'],
                                                                ['value' => 'Disabled', 'label' => 'Disabled / معذور'],
                                                                [
                                                                    'value' => 'Transgender',
                                                                    'label' => 'Transgender / خواجہ سرا',
                                                                ],
                                                            ],
                                                        ],
                                                    ];
                                                @endphp

                                                @foreach ($formFields as $field)
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="bi bi-{{ $field['icon'] }}"></i></span>
                                                            <div class="form-floating flex-grow-1">
                                                                <input type="{{ $field['type'] }}" class="form-control"
                                                                    id="{{ $field['id'] }}" name="{{ $field['id'] }}"
                                                                    placeholder="{{ $field['label'] }}"
                                                                    value="{{ $field['value'] ?? old($field['id']) }}"
                                                                    {{ isset($field['placeholder']) ? "placeholder='" . $field['placeholder'] . "'" : '' }}>
                                                                <label for="{{ $field['id'] }}">{{ $field['label'] }} /
                                                                    {{ $field['urdu'] }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                @foreach ($selectFields as $field)
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i
                                                                    class="bi bi-{{ $field['icon'] }}"></i></span>
                                                            <div class="form-floating flex-grow-1">
                                                                <select class="form-select" id="{{ $field['id'] }}"
                                                                    name="{{ $field['id'] }}">
                                                                    <option disabled selected value="">Select</option>
                                                                    @foreach ($field['options'] as $opt)
                                                                        <option value="{{ $opt['value'] }}"
                                                                            {{ old($field['id']) == $opt['value'] ? 'selected' : '' }}>
                                                                            {{ $opt['label'] }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <label
                                                                    for="{{ $field['id'] }}">{{ $field['label'] }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="col-md-6"></div>

                                                <div class="col-md-6">
                                                    <label for="PermanentAddress" class="form-label">Permanent Address /
                                                        مستقل پتہ</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                                        <div class="form-floating flex-grow-1">
                                                            <textarea class="form-control" id="PermanentAddress" name="PermanentAddress" placeholder="Permanent Address"
                                                                style="height: 100px">{{ old('PermanentAddress') }}</textarea>
                                                            <label for="PermanentAddress">Permanent Address / مستقل
                                                                پتہ</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="CurrentAddress" class="form-label">Current Address / عارضی
                                                        پتہ</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="bi bi-house-door"></i></span>
                                                        <div class="form-floating flex-grow-1">
                                                            <textarea class="form-control" id="CurrentAddress" name="CurrentAddress" placeholder="Current Address"
                                                                style="height: 100px">{{ old('CurrentAddress') }}</textarea>
                                                            <label for="CurrentAddress">Current Address / عارضی پتہ</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-end mt-4">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="bi bi-save2 me-1"></i> Submit
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
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
    @endpush
@endsection
