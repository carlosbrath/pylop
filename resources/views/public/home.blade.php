@extends('layouts.master-public')
@section('title', $title ?? 'Dashboard')
@section('content')
    <!-- Hero Section -->
    {{-- <section class="hero-section d-flex align-items-center"> --}}
    {{-- <div class="overlay"></div> --}}
    {{-- </section> --}}
    <section>
        <div class="container-fluid">
            <div class="row" style="height: 100vh;">
                <!-- Left Column with Background Image -->
                <div class="col-md-5  left-hero d-none d-md-block d-sm-none"></div>

                <!-- Right Column -->
                <div class="col-md-7 right-hero d-flex flex-column justify-content-center">
                    <h1 class="mb-3 text-secondary">Prime Minister Youth Loan Program</h1>
                    <!-- AJK Logo in Center -->
                    <img src="{{ asset('/images/ajklogo.png') }}" alt="AJK Logo" class="ajk-logo">

                    <h3 class="mt-3 text-white">
                        Subsidized Financing By Azad Kashmir Small Industries &<br> Bank of Azad Jammu and Kashmir
                    </h3>
                    <!-- Apply Now Button -->
                    <a href="{{ route('loan.application') }}" class="btn btn-secondary mt-4 px-4 py-2 w-20 fw-bold btn-lg">
                        Apply Now
                    </a>

                    <!-- Bottom Logos Row -->
                    <div class="d-flex justify-content-between align-items-center mt-5 bottom-logos">
                        <img src="{{ asset('/images/logo.png') }}" alt="Small Industries Logo">
                        <img src="{{ asset('/images/bankajk.png') }}" alt="BAJK Logo">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4 fw-bold">Feature of the Program</h2>
            <p class="text-center mb-5 fs-5 text-muted">
                The Prime Minister Youth Loan Program aims to empower the youth of Azad Jammu & Kashmir through
                subsidized financing. It encourages innovation, boost local industries, and
                supports self-employment opportunities.
            </p>

            <div class="row g-4 justify-content-center">

                <!-- Card 1 -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-success">💸 0% Markup</h5>
                            <p class="card-text">Interest-free financing subsidized by GOVT of AJK.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-success">📊 PKR 1 – 20 Lakh</h5>
                            <p class="card-text">Loan limits under a structured tier system.</p>
                            <a href="#tier-info" class="btn btn-outline-success mt-3">View More</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-success">👥 Gender Quota</h5>
                            <ul class="list-unstyled mb-0">
                                <li>Male – 48%       Female – 48%</li>
                                <li>Special Persons – 2%       Transgender – 2%</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body">
                            <div>

                                <h5 class="card-title fw-bold text-success">🌍 Population Quota</h5>
                                <p class="card-text">Loan distribution based on district-wise population ratio.</p>
                            </div>
                            <a href="#population-quota" class="btn btn-outline-success mt-3">View More</a>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm text-center">
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-success">🏪 Business Nature</h5>
                            <p class="card-text mb-1">New business – 75%</p>
                            <p class="card-text">Startup – 25%</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="schemes" class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4" id="eligibility">
                <div class="col-md-5">
                    <ul class="list-unstyled">
                        <li class="fw-bold">📌 Eligibility Criteria:</li>
                        <li>🔸 Loan will be granted to youth of Azad jammu & Kashmir having business
                            juridiction in AJK.</li>
                        <li>🔸 Must hold a valid computerized CNIC (not expired).</li>
                        <li>🔸 Applicant’s age must be between 18 to 40 years.</li>
                        <li>🔸 Preference will be given to youth with business skills, certificate diplomas, or degrees.
                        </li>
                        <li>🔸 Men, Women, Persons with Disabilities, and Transgenders are eligible to apply.</li>
                        <li>🔸 Government/semi-government employees and defaulters of any financial institution are not
                            eligible.</li>
                        <li>🔸 Incomplete applications or those not meeting the criteria will not be considered.</li>
                    </ul>
                </div>
                <div class="col-md-2 text-center">
                    <img src="{{ asset('./images/logo.png') }}" class="img-fluid px-2" alt="PMYP Logo" />
                </div>
                <div class="col-md-5 text-end" dir="rtl">
                    <ul class="list-unstyled text-end">

                        <li class="fw-bold">📌 مطلوبہ معیار اہلیت:</li>
                        <li>🔸 قرضہ ایسے افراد کو دیا جائے گا جو آزاد کشمیر کے شہری ہوں اور مجوزہ کاروبار کا دائرہ کار آزاد
                            کشمیر کی حدود میں ہو۔
                        </li>
                        <li>🔸 کمپیوٹرائزڈ شناختی کارڈ ہولڈر ہو ۔</li>
                        <li>🔸 عمر 18 سے 40 سال کے درمیان ہو۔</li>
                        <li>🔸 ایسے نوجوان جو کاروباری مہارت رکھتے ہوں۔ سرٹیفیکیٹ / ڈپلومہ / ڈگری ہولڈرز کو ترجیح دی جائے
                            گی۔</li>
                        <li>🔸 مرد، خواتین، معذور اور خواجہ سرا درخواست دینے کے اہل ہوں گے۔</li>
                        <li>🔸 سرکاری / نیم سرکاری ملازمین اور مالیاتی اداروں کے نادہندہ افراد اہل نہیں ہوں گے۔</li>
                        <li>🔸 مطلوبہ معیار پر پورا نہ اترنے والی اور نامکمل درخواستیں زیر غور نہیں لائی جائیں گی۔</li>

                    </ul>
                </div>
            </div>
            <div class="row mb-4" id="loanDetails">
                <div class="col-md-5">
                    <ul class="list-unstyled">
                        <li class="fw-bold">📌 Loan Details:</li>
                        <li>💰 <strong>Loan Limit:</strong> From PKR 100,000 to PKR 2,000,000, based on the type of
                            business.</li>
                        <li>💸 <strong>Markup Rate:</strong> The loan is interest-free. The principal amount will be
                            provided by
                            Bank of AJK, and markup will be paid by the Government of AJK through Azad kashmir Small
                            Industries
                            Corporation. In case of late repayment, the borrower must pay the additional markup.</li>
                        <li>📊 <strong>Quota:</strong> Loans will be issued based on district-wise population ratio and
                            gender quota.</li>
                        <li>🏪 <strong>Business Nature:</strong> 75% for new businesses and 25% for startup.
                        </li>
                        <li>📝 <strong>Form Fee:</strong> For offline applications, the form fee must be deposited in the
                            name of Managing Director, AJK Small Industries Corporation, Account No. 040-14027001 (Bank of
                            AJK). Attach the bank receipt and CNIC copy with the form. For online applications, both must be
                            uploaded.</li>
                    </ul>
                </div>
                <div class="col-md-2 text-center">
                    {{-- <img src="{{ asset('./images/logo.png') }}" class="img-fluid px-2" alt="PMYP Logo" /> --}}
                </div>
                <div class="col-md-5 text-end" dir="rtl">
                    <ul class="list-unstyled text-end">
                        <li class="fw-bold">📌 قرضہ کی تفصیلات:</li>
                        <li>💰 <strong>قرضہ کی حد:</strong> 1 لاکھ سے 20 لاکھ روپے، کاروبار کی نوعیت کے مطابق۔</li>
                        <li>💸 <strong>شرح منافع:</strong> قرضہ بلا سود ہے، اصل رقم بینک آف اے جے کے فراہم کرے گا،
                            جبکہ مارک اپ کی رقم حکومت آزاد کشمیر بذریعہ آزاد کشمیر سمال انڈسٹریز کارپوریشن ادا کرے گی۔قرضہ
                            کی اقساط کی ریکوری میں تاخیر کی صورت میں زائد مارک اپ کی رقم مقروض ادا کرنے کا پابند ہوگا۔</li>
                        <li>📊 <strong>کوٹہ:</strong>
                            قرضہ کی اجرائیگی ضلع وائز آبادی کے تناسب اور Gender کوٹہ کے مطابق ہوگی ۔</li>
                        <li>🏪 <strong>کاروباری نوعیت:</strong> نیا کاروبار (75 فیصد ) اور سٹارٹ اپ بزنس (25) فیصد )</li>
                        <li>📝 <strong>قیمت فارم:</strong> قیمت فارم آزاد کشمیر سمال انڈسٹریز کارپوریشن بنام منیجنگ ڈائر
                            یکٹر آزاد کشمیر سمال انڈسٹریز کارپوریشن، اکاؤنٹ نمبر 14027001-040 بینک آف آزاد جموں وکشمیر میں
                            جمع کرواتے ہوئے آف لائن درخواست کی صورت میں بینک رسید اور شناختی کارڈ کی فوٹو کاپی درخواست فارم
                            کے ساتھ منسلک کی جانا ہوگی جبکہ آن لائن درخواست فارم کی صورت میں بینک رسید اور شناختی کارڈ اپ
                            لوڈ کیا جانا ضروری ہے۔</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="business" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Loan Scheme Business Categories</h3>
                <p class="text-muted">Priority will be given to potential, capital & labour intensive businesses.</p>
            </div>

            <div class="row">
                @foreach ($businessCategories as $category)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $category->name }}</h5>
                                @if ($category->children->count())
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($category->children as $sub)
                                            <li>{{ $sub->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- Loan Links Section -->
    <section id="loan_links" class="py-5 loan_links bg-light">
        <div class="container">
            <div class="row g-4">
                <!-- Apply Column -->
                <div class="col-lg-4 col-md-6">
                    <div class="link_card border-end h-100 shadow-sm bg-white rounded p-4 text-center">
                        <img src="./images/applyloan.png" class="mb-3" alt="Apply" />
                        <a target="_blank" href="{{ route('loan.application') }}" style="cursor: pointer">
                            <h4 class="mt-3">Apply for Loan</h4>
                            <p class="text-muted">Fill online loan application</p>
                        </a>

                    </div>
                </div>

                <!-- Track Column -->
                <div class="col-lg-4 col-md-6">
                    <div class="link_card border-end h-100 shadow-sm bg-white rounded p-4 text-center">
                        <img src="./images/track.png" class="mb-3" alt="Track" />
                        <a target="_blank" href="{{ route('track.application') }}" style="cursor: pointer">
                            <h4 class="mt-3">Track</h4>
                            <p class="text-muted">Check status of your loan application</p>
                        </a>
                        <a target="_blank" href="/PMYPHome/Dashboarddetails" style="cursor: pointer">
                            <h5 class="mt-4">Analytics</h5>
                            <p class="text-muted">Click here for Dashboard</p>
                        </a>
                    </div>
                </div>

                <!-- Calculator Column -->
                <div class="col-lg-4 col-md-6">
                    <div class="link_card border-end h-100 shadow-sm bg-white rounded p-4 text-center">
                        <img src="./images/calculator.png" class="mb-3" alt="Calculator" />
                        <a target="_blank" href="./images/image.png" style="cursor: pointer">
                            <h4 class="mt-3">Calculator</h4>
                            <p class="text-muted">Calculate loan repayment schedule</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Eligibility Section -->
    <section id="eligibility" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Eligibility Criteria</h2>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Age between 18 to 40 years</li>
                <li class="list-group-item">
                    Must be a resident of Azad Jammu & Kashmir
                </li>
                <li class="list-group-item">Possess a valid CNIC</li>
                <li class="list-group-item">
                    Business plan required for loan approval
                </li>
                <li class="list-group-item">
                    Applicable for both new and existing businesses
                </li>
            </ul>
        </div>
    </section>
    <section id="population-quota" class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-4">📊 District-wise Population Quota</h2>

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle shadow-sm">
                    <thead class="table-success">
                        <tr>
                            <th scope="col">Sr.#</th>
                            <th scope="col">District</th>
                            <th scope="col">Population (%)</th>
                            <th scope="col">District-wise Quota of Beneficiaries (Proposed)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Muzaffarabad</td>
                            <td>16%</td>
                            <td>449</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Neelum</td>
                            <td>5%</td>
                            <td>140</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Jhelum Valley</td>
                            <td>6%</td>
                            <td>168</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Bagh</td>
                            <td>9%</td>
                            <td>252</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Haveli</td>
                            <td>4%</td>
                            <td>112</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Poonch</td>
                            <td>12%</td>
                            <td>337</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Sudhnoti</td>
                            <td>7%</td>
                            <td>196</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Kotli</td>
                            <td>19%</td>
                            <td>533</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Mirpur</td>
                            <td>11%</td>
                            <td>309</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Bhimber</td>
                            <td>11%</td>
                            <td>309</td>
                        </tr>
                        <tr class="table-light fw-bold">
                            <td colspan="2">Total</td>
                            <td>100%</td>
                            <td>2,805</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- Tier Information Section -->
    <section id="tier-info" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">📊 Tiers of Loan Limit</h2>

            <div class="row text-center g-4">
                <!-- Tier 1 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-success">
                        <div class="card-body">
                            <h4 class="text-success fw-bold">Tier 1</h4>
                            <p><strong>Loan Range:</strong> PKR 100,000 – 500,000</p>
                            <p><strong>Markup:</strong> 0% (Interest-Free)</p>
                            <p><strong>Type:</strong> Clean Loan</p>
                        </div>
                    </div>
                </div>

                <!-- Tier 2 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-success">
                        <div class="card-body">
                            <h4 class="text-success fw-bold">Tier 2</h4>
                            <p><strong>Loan Range:</strong> PKR 500,000 – 1,500,000</p>
                            <p><strong>Markup:</strong> 0% (Interest-Free)</p>
                            <p><strong>Type:</strong> Secured Loan</p>
                        </div>
                    </div>
                </div>

                <!-- Tier 3 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-success">
                        <div class="card-body">
                            <h4 class="text-success fw-bold">Tier 3</h4>
                            <p><strong>Loan Range:</strong> PKR 1,500,000 – 2,000,000</p>
                            <p><strong>Markup:</strong> 0% (Interest-Free)</p>
                            <p><strong>Type:</strong> Secured Loan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- FAQ Section -->
    <section id="faq" class="faq p-0 bg-white">
        <div class="py-5 faq_banner" style="background-color: #f3f5f7">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="title mb-4">
                            <h4 class="text-success">How can we help you?</h4>
                            <h2 class="fw-bold">Frequently Asked Questions</h2>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <img src="./images/FAQs.png" class="img-fluid" alt="FAQ" />
                    </div>
                </div>
            </div>
        </div>

        <div class="container py-5">
            <div class="row faq-list">
                <!-- Left Column -->
                <div class="col-lg-6">
                    <div class="accordion" id="faqAccordion">
                        <!-- FAQ 1 -->
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq1" aria-expanded="true">
                                    Can loan be applied physically in branches?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, physical application submission is also available.<br>
                                    Applicants who prefer to apply in person can visit the nearest designated bank branch or
                                    facilitation center for the PM Youth Loan Program.
                                    <br />

                                </div>
                            </div>
                        </div>

                        <!-- FAQ 2 -->
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq2">
                                    Can a non-resident Azad Kashmir apply?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    No. This scheme is only for resident Azad Kashmir.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 3 -->
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq3">
                                    Can government employees apply?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    No. Government employees are not eligible under this scheme.
                                </div>
                            </div>
                        </div>

                        <!-- FAQ 4 -->
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq4">
                                    What is the minimum educational requirement for an
                                    applicant?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    There is no general minimum educational requirement.
                                    However, if the business requires specific qualifications or
                                    certifications, they must be held by the applicant.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column Image -->
                <div class="col-lg-6 text-center mt-4 mt-lg-0">
                    <img src="./images/FAQsIllustration.png" class="img-fluid" alt="FAQ Illustration" />
                </div>
            </div>
        </div>
    </section>
    <!-- Financial Calculators Section -->
    <section class="f-cal bg-light">
        <div class="container">
            <div class="row align-items-center py-5">
                <!-- Left: Image -->
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <img src="./images/F.Calculator.png" class="img-fluid" alt="Financial Calculator" />
                </div>

                <!-- Right: Content -->
                <div class="col-lg-7">
                    <div class="section-title mb-4">
                        <h2 class="fw-bold text-success">
                            Financial Calculators / Templates
                        </h2>
                        <p>
                            This section includes a collection of free financial calculators
                            and templates to help you compute essential business metrics.
                            Our tools assist in analyzing income statements, cash flows,
                            balance sheets, and loan repayment schedules.
                        </p>
                        <p><strong>Please download from the links below:</strong></p>
                    </div>

                    <!-- Download Links -->
                    <div class="downloads_links">
                        <a target="_blank" href="/downloads/balancesheettemplate.xlsx" style="cursor: pointer"
                            class="d-block mb-2 text-decoration-none">
                            <h5>
                                <i class="bi bi-circle-fill text-success me-2"></i> Balance
                                Sheet
                            </h5>
                        </a>

                        <a target="_blank" href="/downloads/cashflowstatemettemplate.xlsx" style="cursor: pointer"
                            class="d-block mb-2 text-decoration-none">
                            <h5>
                                <i class="bi bi-circle-fill text-success me-2"></i> Cashflow
                                Statement
                            </h5>
                        </a>

                        <a target="_blank" href="/downloads/incomestatementtemplate.xlsx" style="cursor: pointer"
                            class="d-block mb-2 text-decoration-none">
                            <h5>
                                <i class="bi bi-circle-fill text-success me-2"></i> Income
                                Statement
                            </h5>
                        </a>

                        <a target="_blank" href="/downloads/loanrepaymenttemplatev.xlsx" style="cursor: pointer"
                            class="d-block mb-2 text-decoration-none">
                            <h5>
                                <i class="bi bi-circle-fill text-success me-2"></i> Loan
                                Repayment
                            </h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            window.onload = function() {
                var myModal = new bootstrap.Modal(document.getElementById('announcementModal'));
                myModal.show();
            };
        </script>
    @endpush
@endsection
