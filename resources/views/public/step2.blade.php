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
                            action="{{ route('storeForm') }}" onsubmit="validateForm(event, this, 'step2')"
                            enctype="multipart/form-data">
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

                                        <div class="card-body">
                                            <div
                                                class="card-header bg-success mb-3 text-white d-flex justify-content-between">
                                                <h5><i class="bi bi-person-badge-fill me-2"></i> Personal Information</h5>
                                                <h5 dir="rtl">ذاتی معلومات</h5>
                                            </div>
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
                                                            'icon' => 'cash-coin',
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
                                                                ['value' => '1', 'label' => 'Tier 1 (Up to 5 Lakh)'],
                                                                ['value' => '2', 'label' => 'Tier 2 (5 - 10 Lakh)'],
                                                                ['value' => '3', 'label' => 'Tier 3 (10 - 20 Lakh)'],
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
                                                            'id' => 'district_id',
                                                            'label' => 'District / ضلع',
                                                            'icon' => 'geo',
                                                            'options' => $districts
                                                                ->map(
                                                                    fn($d) => [
                                                                        'value' => $d->id,
                                                                        'label' => $d->name . ' / ' . $d->name_ur,
                                                                    ],
                                                                )
                                                                ->toArray(),
                                                        ],
                                                        [
                                                            'id' => 'tehsil_id',
                                                            'label' => 'Tehsil / تحصیل',
                                                            'icon' => 'geo-fill',
                                                            'options' => [], // Will be populated via AJAX
                                                        ],
                                                        [
                                                            'id' => 'business_category_id',
                                                            'label' => 'Business Category / کاروباری زمرہ',
                                                            'icon' => 'briefcase',
                                                            'options' => $categories
                                                                ->map(
                                                                    fn($c) => ['value' => $c->id, 'label' => $c->name],
                                                                )
                                                                ->toArray(),
                                                        ],
                                                        [
                                                            'id' => 'business_sub_category_id',
                                                            'label' => 'Business Subcategory / ذیلی زمرہ',
                                                            'icon' => 'list-task',
                                                            'options' => [], // Will be populated via AJAX
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
                                                <div class="col-md-12 mt-4">
                                                    <div
                                                        class="card-header bg-success mb-3 text-white d-flex justify-content-between">
                                                        <h5><i class="bi bi-person-badge-fill me-2"></i> Educational
                                                            Background</h5>
                                                        <h5 dir="rtl">تعلیمی معلومات</h5>
                                                    </div>
                                                    <div class="border rounded p-3 bg-white" id="educationSection">

                                                        <p class="text-muted text-center">
                                                            Add your highest level of education.
                                                        </p>

                                                        <div id="educationRepeater">
                                                            <div class="row g-3 mb-3 education-entry">
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i
                                                                                class="bi bi-mortarboard"></i></span>
                                                                        <div class="form-floating flex-grow-1">
                                                                            <select name="educations[0][education_level]"
                                                                                class="form-select">
                                                                                <option value="">Select</option>
                                                                                <option value="Primary">Primary / پرائمری
                                                                                </option>
                                                                                <option value="Middle">Middle / مڈل
                                                                                </option>
                                                                                <option value="Matric">Matric / میٹرک
                                                                                </option>
                                                                                <option value="Intermediate">Intermediate /
                                                                                    انٹرمیڈیٹ</option>
                                                                                <option value="Diploma">Diploma / ڈپلومہ
                                                                                </option>
                                                                                <option value="Bachelor">Bachelor / بیچلر
                                                                                </option>
                                                                                <option value="Master">Master / ماسٹر
                                                                                </option>
                                                                            </select>
                                                                            <label>Education Level / تعلیمی سطح</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Degree Title -->
                                                                <div class="col-md-6">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i
                                                                                class="bi bi-journal-text"></i></span>
                                                                        <div class="form-floating flex-grow-1">
                                                                            <input type="text"
                                                                                name="educations[0][degree_title]"
                                                                                class="form-control"
                                                                                placeholder="Degree Title">
                                                                            <label>Degree Title / ڈگری کا عنوان</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Institute -->
                                                                <div class="col-md-3">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i
                                                                                class="bi bi-bank"></i></span>
                                                                        <div class="form-floating flex-grow-1">
                                                                            <input type="text"
                                                                                name="educations[0][institute]"
                                                                                class="form-control"
                                                                                placeholder="Institute Name">
                                                                            <label>Institute / ادارہ</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Passing Year -->
                                                                <div class="col-md-3">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i
                                                                                class="bi bi-calendar2-check"></i></span>
                                                                        <div class="form-floating flex-grow-1">
                                                                            <input type="text"
                                                                                name="educations[0][passing_year]"
                                                                                class="form-control" placeholder="Year">
                                                                            <label>Passing Year / سال</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Grade or Percentage -->
                                                                <div class="col-md-4">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text"><i
                                                                                class="bi bi-graph-up"></i></span>
                                                                        <div class="form-floating flex-grow-1">
                                                                            <input type="text"
                                                                                name="educations[0][grade_or_percentage]"
                                                                                class="form-control"
                                                                                placeholder="Grade or Percentage">
                                                                            <label>Grade / Percentage / گریڈ یا فیصد</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-1 d-flex align-items-end">
                                                                    <button type="button"
                                                                        class="btn btn-danger remove-education d-none">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="text-end">
                                                            <button type="button" class="btn btn-success"
                                                                id="addMoreEducation">
                                                                <i class="bi bi-plus-circle"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-4">
                                                    <div
                                                        class="card-header bg-success mb-3 text-white d-flex justify-content-between">
                                                        <h5><i class="bi bi-file-earmark-image me-2"></i> CNIC Upload</h5>
                                                        <h5 dir="rtl">شناختی کارڈ اپلوڈ کریں</h5>
                                                    </div>

                                                    <div class="border rounded p-3 bg-white" id="cnic section">
                                                        <div class="row g-3">
                                                            <!-- CNIC Front -->
                                                            <div class="col-md-6">
                                                                <label for="cnic_front" class="form-label">CNIC Front Side
                                                                    /
                                                                    سامنے</label>
                                                                <div class="border p-3 rounded text-center bg-light dropzone"
                                                                    ondragover="event.preventDefault();"
                                                                    ondrop="handleDrop(event, 'cnic_front')"
                                                                    onclick="document.getElementById('cnic_front').click();">
                                                                    <div>
                                                                        <i class="bi bi-upload display-1"></i>
                                                                        <p class="mb-2">Drag & Drop or Click to Upload</p>
                                                                    </div>
                                                                    <img id="cnic_front_preview" src="#"
                                                                        alt="" class="img-fluid d-none"
                                                                        style="max-height: 350px;">
                                                                    <input type="file" name="cnic_front"
                                                                        id="cnic_front" class="d-none" accept="image/*"
                                                                        onchange="previewImage(this, 'cnic_front_preview')">
                                                                </div>
                                                            </div>

                                                            <!-- CNIC Back -->
                                                            <div class="col-md-6">
                                                                <label for="cnic_back" class="form-label">CNIC Back Side /
                                                                    پیچھے</label>
                                                                <div class="border p-3 rounded text-center bg-light dropzone"
                                                                    ondragover="event.preventDefault();"
                                                                    ondrop="handleDrop(event, 'cnic_back')"
                                                                    onclick="document.getElementById('cnic_back').click();">
                                                                    <i class="bi bi-upload display-1"></i>
                                                                    <p class="mb-2">Drag & Drop or Click to Upload</p>
                                                                    <img id="cnic_back_preview" src="#"
                                                                        alt="" class="img-fluid d-none"
                                                                        style="max-height: 150px;">
                                                                    <input type="file" name="cnic_back" id="cnic_back"
                                                                        class="d-none" accept="image/*"
                                                                        onchange="previewImage(this, 'cnic_back_preview')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-md-12 mt-4">
                                                    <div class="border rounded p-3 bg-light">
                                                        <h5 class="text-center mb-3">Declaration / حلف نامہ</h5>
                                                        <p class="mb-2">
                                                            <strong>English:</strong> I hereby solemnly declare that I am
                                                            not a government employee, nor a defaulter of any financial
                                                            institution. I commit to timely repayment of the loan
                                                            installments. In case of delay, I will be responsible for paying
                                                            the additional markup, and I will invest the loan amount solely
                                                            in the business for which it is provided.
                                                        </p>
                                                        <p dir="rtl" class="text-end mb-3">
                                                            <strong>اردو:</strong> میں اس امر کی حلفاً تصدیق دیتا / دیتی ہوں
                                                            کہ میں سرکاری ملازم نہیں ہوں، کسی بھی مالیاتی ادارہ کا نا دہندہ
                                                            نہیں ہوں ۔ قرضہ کی رقم کی اقساط بر وقت ادا کرنے کا پابند ہوں گا
                                                            / گی۔ تاخیر کی صورت میں زائد مارک اپ کی رقم ادا کرنے کا پابند
                                                            ہوں گا / گی اور جس کاروبار کے لیے قرضہ فراہم کیا جائے گا، اس
                                                            کاروبار میں قرضہ کی رقم کی سرمایہ کاری کروں گا / گی۔
                                                        </p>

                                                        <div class="form-check mt-3">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="declaration_agree" id="declarationAgree">
                                                            <label class="form-check-label" for="declarationAgree">
                                                                I have read and agree to the above statement / میں اوپر دیے
                                                                گئے بیان سے متفق ہوں
                                                            </label>
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const districtSelect = document.getElementById('district_id');
                const tehsilSelect = document.getElementById('tehsil_id');

                districtSelect.addEventListener('change', function() {
                    fetch(`/get-tehsils/${this.value}`)
                        .then(response => response.json())
                        .then(data => {
                            tehsilSelect.innerHTML = '<option value="">Select Tehsil</option>';
                            data.forEach(tehsil => {
                                tehsilSelect.innerHTML +=
                                    `<option value="${tehsil.id}">${tehsil.name} / ${tehsil.name_ur}</option>`;
                            });
                        });
                });

                const categorySelect = document.getElementById('business_category_id');
                const subcategorySelect = document.getElementById('business_sub_category_id');

                categorySelect.addEventListener('change', function() {
                    fetch(`/get-subcategories/${this.value}`)
                        .then(response => response.json())
                        .then(data => {
                            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                            data.forEach(sub => {
                                subcategorySelect.innerHTML +=
                                    `<option value="${sub.id}">${sub.name}</option>`;
                            });
                        });
                });
            });

            let educationIndex = 1;

            document.getElementById('addMoreEducation').addEventListener('click', function() {
                const template = document.querySelector('.education-entry');
                const clone = template.cloneNode(true);
                const inputs = clone.querySelectorAll('input, select');

                // Update names with new index
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace(/\[\d+\]/, `[${educationIndex}]`));
                        input.value = '';
                    }
                });

                // Show remove button
                const removeBtn = clone.querySelector('.remove-education');
                removeBtn.classList.remove('d-none');
                removeBtn.addEventListener('click', function() {
                    clone.remove();
                });

                document.getElementById('educationRepeater').appendChild(clone);
                educationIndex++;
            });

            // Initial remove handler (optional if you use only one row first)
            document.querySelectorAll('.remove-education').forEach(btn => {
                btn.addEventListener('click', function() {
                    btn.closest('.education-entry').remove();
                });
            });

            function previewImage(input, previewId) {
                const file = input.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById(previewId);
                        preview.src = e.target.result;
                        preview.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            }

            function handleDrop(event, inputId) {
                event.preventDefault();
                const fileInput = document.getElementById(inputId);
                const files = event.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    previewImage(fileInput, inputId + '_preview');
                }
            }
        </script>
    @endpush
@endsection
