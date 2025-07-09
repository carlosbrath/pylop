@extends('layouts.master-public')
@section('title', $title ?? 'Dashboard')
@section('content')
    <section id="initialSection" class="signup-step-container py-4">
        <div class="container">
            <div class="row d-flex justify-content-center form-bg pb-4">
                <div class="row justify-content-center bg-primary green-gradient text-white py-3 mb-4">
                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <h2 class="mb-0 text-center w-100">
                            AJK PM Youth Loan Program - Application Form
                        </h2>
                    </div>
                </div>

                <div class="row mb-4" id="eligibility">
                    <div class="col-md-5">
                        <ul class="list-unstyled">
                            <li class="fw-bold">📌 Eligibility Criteria:</li>
                            <li>🔸 Applicant must be a resident of AJK and business must be within AJK.</li>
                            <li>🔸 Must have a valid computerized CNIC (within expiry date).</li>
                            <li>🔸 Age must be between 18 to 40 years.</li>
                            <li>🔸 Preference to candidates with business skills, certificates, diplomas, or degrees.</li>
                            <li>🔸 Men, Women, Disabled Persons, and Transgenders are eligible.</li>
                            <li>🔸 Government/semi-government employees and defaulters of any financial institution are not
                                eligible.</li>
                            <li>🔸 Incomplete or ineligible applications will not be considered.</li>

                        </ul>
                    </div>
                    <div class="col-md-2 text-center">
                        <img src="{{ asset('./images/logo.png') }}" class="img-fluid px-2" alt="PMYP Logo" />
                    </div>
                    <div class="col-md-5 text-end" dir="rtl">
                        <ul class="list-unstyled text-end">

                            <li class="fw-bold">📌 مطلوبہ معیار اہلیت:</li>
                            <li>🔸 قرضہ ایسے افراد کو دیا جائے گا جو آزاد کشمیر کے شہری ہوں اور مجوزہ کاروبار کا دائرہ کار
                                آزاد
                                کشمیر کی حدود میں ہو۔
                            </li>
                            <li>🔸 کمپیوٹرائزڈ شناختی کارڈ ہولڈر ہو ۔</li>
                            <li>🔸 عمر 18 سے 40 سال کے درمیان ہو۔</li>
                            <li>🔸 ایسے نوجوان جو کاروباری مہارت رکھتے ہوں۔ سرٹیفیکیٹ / ڈپلومہ / ڈگری ہولڈرز کو ترجیح دی
                                جائے
                                گی۔</li>
                            <li>🔸 مرد، خواتین، معذور اور خواجہ سرا درخواست دینے کے اہل ہوں گے۔</li>
                            <li>🔸 سرکاری / نیم سرکاری ملازمین اور مالیاتی اداروں کے نادہندہ افراد اہل نہیں ہوں گے۔</li>
                            <li>🔸 مطلوبہ معیار پر پورا نہ اترنے والی اور نامکمل درخواستیں زیر غور نہیں لائی جائیں گی۔</li>

                        </ul>
                    </div>
                </div>

                <div class="text-center mb-3">
                    <a href="#eligibility" class="btn btn-outline-primary mx-2">📘 Eligibility Criteria</a>
                    <a href="#loanDetails" class="btn btn-outline-success mx-2">📌 Loan Details:</a>
                    <a href="#" class="btn btn-outline-success mx-2">اردو ہدایت نامہ</a>
                    <a href="#" class="btn btn-outline-danger mx-2">Edit Application</a>
                </div>

                <form id="step1" class="row g-3 mt-3" method="POST" action="{{ route('storeForm') }}"
                    onsubmit="validateForm(event, this, 'step1')">
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

                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
                            <div class="form-floating flex-grow-1">
                                <input type="text" name="cnic" id="cnic" value="{{old('cnic') }}" class="form-control"
                                    placeholder="xxxxx-xxxxxxx-x" maxlength="15"  />
                                <label for="cnic">CNIC Number / شناختی کارڈ نمبر</label>
                            </div>
                        </div>
                        {{-- <p class="text-danger ms-5">Cnic Field required</p> --}}
                    </div>

                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            <div class="form-floating flex-grow-1">
                                <input type="date" name="issue_date" value="{{old('issue_date') }}" id="issue_date" class="form-control"
                                    placeholder="CNIC Issue Date"  />
                                <label for="issue_date">CNIC Issue Date / شناختی کارڈ کے اجراء کی تاریخ</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-diagram-3"></i></span>
                            <div class="form-floating flex-grow-1">
                                <select class="form-select" name="tier" id="tier">
                                    <option selected disabled value="">Select Tier</option>
                                    <option value="1" {{ old('tier') == 1 ? 'selected' : '' }}>Tier 1 (Up to 5 Lakh)</option>
                                    <option value="2" {{ old('tier') == 2 ? 'selected' : '' }}>Tier 2 (5 - 10 Lakh)</option>
                                    <option value="3" {{ old('tier') == 3 ? 'selected' : '' }}>Tier 3 (10 - 20 Lakh)</option>
                                </select>
                                <label for="tier">Tier / درجہ</label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="form_stage" value="step1">

                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-success px-5">
                            <i class="bi bi-save2"></i> Next
                        </button>
                    </div>
                </form>
                <div class="row mb-4" id="loanDetails">
                    <div class="col-md-5">
                        <ul class="list-unstyled">
                            <li class="fw-bold">📌 Loan Details:</li>
                            <li>💰 <strong>Loan Limit:</strong> From PKR 100,000 to PKR 2,000,000, depending on business
                                nature.</li>
                            <li>💸 <strong>Markup Rate:</strong> Interest-free loan — principal funded by Bank of AJK,
                                markup paid by GoAJK through Small Industries Corporation. Delay in repayment incurs markup
                                by borrower.</li>
                            <li>📊 <strong>Quota:</strong> Loans will be distributed by district population ratio and gender
                                quota.</li>
                            <li>🏪 <strong>Business Nature:</strong> 75% for new businesses, 25% for startup
                                expansion/branches.</li>
                            <li>📝 <strong>Form Fee:</strong> Offline applicants must submit fee receipt & CNIC copy. Online
                                applicants must upload scanned copy of both.</li>
                        </ul>
                    </div>
                    <div class="col-md-2 text-center">
                        {{-- <img src="{{ asset('./images/logo.png') }}" class="img-fluid px-2" alt="PMYP Logo" /> --}}
                    </div>
                    <div class="col-md-5 text-end" dir="rtl">
                        <ul class="list-unstyled text-end">
                            <li class="fw-bold">📌 قرضہ کی تفصیلات:</li>
                            <li>💰 <strong>قرضہ کی حد:</strong> 1 لاکھ سے 20 لاکھ روپے، کاروبار کی نوعیت کے مطابق۔</li>
                            <li>💸 <strong>شرح منافع:</strong> قرضہ بلا سود ہے، اصل رقم بینک آف اے جے کے فراہم کرے گا، مارک
                                جبکہ مارک اپ کی رقم حکومت آزاد کشمیر بذریعہ آزاد کشمیر سمال انڈسٹریز کارپوریشن ادا کرے
                                گی۔قرضہ
                                کی اقساط کی ریکوری میں تاخیر کی صورت میں زائد مارک اپ کی رقم مقروض ادا کرنے کا پابند ہوگا۔
                            </li>
                            <li>📊 <strong>کوٹہ:</strong>
                                قرضہ کی اجرائیگی ضلع وائز آبادی کے تناسب اور Gender کوٹہ کے مطابق ہوگی ۔</li>
                            <li>🏪 <strong>کاروباری نوعیت:</strong> نیا کاروبار (75 فیصد ) اور سٹارٹ اپ بزنس (25) فیصد )
                            </li>
                            <li>📝 <strong>قیمت فارم:</strong> قیمت فارم آزاد کشمیر سمال انڈسٹریز کارپوریشن بنام منیجنگ ڈائر
                                یکٹر آزاد کشمیر سمال انڈسٹریز کارپوریشن، اکاؤنٹ نمبر 14027001-040 بینک آف آزاد جموں وکشمیر
                                میں جمع کرواتے ہوئے آف لائن درخواست کی صورت میں بینک رسید اور شناختی کارڈ کی فوٹو کاپی
                                درخواست فارم کے ساتھ منسلک کی جانا ہوگی جبکہ آن لائن درخواست فارم کی صورت میں بینک رسید اور
                                شناختی کارڈ اپ لوڈ کیا جانا ضروری ہے۔</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @push('scripts')
    @endpush
@endsection
