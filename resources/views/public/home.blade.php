@extends('layouts.master-public')
@section('title', 'Prime Minister Youth Loan Program – Empowering AJK Youth')
@section('meta_description', 'Learn how PMYP provides interest‑free loans (₨100K–2M) to AJK youth across sectors like
    IT, agriculture & tourism. Apply today!')
@section('meta_keywords', 'AJK youth loan, PMYP, interest free loan, AJK entrepreneurs, Pakistan AJK loans')
@section('og_title', 'PMYP: Interest‑Free Loans for AJK Youth Entrepreneurs')
@section('og_description', 'Explore PMYP’s 0% markup loans of ₨100K–2M for youth aged 18–40 in AJK. Business
    opportunities in tech, tourism, handicrafts & more supported.')
@section('og_image', asset('/assets/img/public/banner.webp'))
@section('content')
    <!-- Hero Section -->
    <section>
        <img src="{{ asset('/assets/img/public/banner.webp') }}" style="width: 100%">
    </section>
    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4 fw-bold">Features</h2>
            <p class="text-center mb-5 fs-5 text-muted">
                Prime Minister Youth Loan Program aims to empower the youth of Azad Jammu & Kashmir through
                subsidized financing. It encourages innovation, boost entrepreneurship and
                creat self-employment opportunities.
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
                            <p class="card-text">Loan limit under a structured tier system.</p>
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
                                <p class="card-text">Loan disbursement based on district-wise population ratio.</p>
                            </div>
                            {{-- <a href="#population-quota" class="btn btn-outline-success mt-3">View More</a> --}}
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
            @include('include.eligibility')
            @include('include.loandetails')
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
    <section id="loan_links" class="py-5 loan_links bg-light d-md-none ">
        <div class="container">
            <div class="row g-4">
                <!-- Apply Column -->
                <div class="col-lg-4 col-md-6">
                    <div class="link_card border-end h-100 shadow-sm bg-white rounded p-4 text-center">
                        <img src="{{asset('/assets/img/public/applyloan.png')}}" class="mb-3" alt="Apply" />
                        <a target="_blank" href="{{ route('loan.application') }}" style="cursor: pointer">
                            <h4 class="mt-3">Apply for Loan</h4>
                            <p class="text-muted">Fill online loan application</p>
                        </a>

                    </div>
                </div>

                <!-- Track Column -->
                <div class="col-lg-4 col-md-6">
                    <div class="link_card border-end h-100 shadow-sm bg-white rounded p-4 text-center">
                        <img src="{{asset('/assets/img/public/track.png')}}" class="mb-3" alt="Track" />
                        <a target="_blank" href="{{ route('track.application') }}" style="cursor: pointer">
                            <h4 class="mt-3">Track</h4>
                            <p class="text-muted">Check status of your loan application</p>
                        </a>
                        {{-- <a target="_blank" href="/PMYPHome/Dashboarddetails" style="cursor: pointer">
                            <h5 class="mt-4">Analytics</h5>
                            <p class="text-muted">Click here for Dashboard</p>
                        </a> --}}
                    </div>
                </div>

                <!-- Calculator Column -->
                <div class="col-lg-4 col-md-6">
                    <div class="link_card border-end h-100 shadow-sm bg-white rounded p-4 text-center">
                        <img src=" {{asset('/assets/img/public/calculator.png')}}" class="mb-3" alt="Calculator" />
                        <a target="_blank" href="#" style="cursor: pointer">
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
                            <p><strong>Loan Range:</strong> PKR 500,000 – 1,000,000</p>
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
                            <p><strong>Loan Range:</strong> PKR 1,000,000 – 2,000,000</p>
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
                        <img src="{{ asset('/assets/img/public/faqs.png') }}" class="img-fluid" alt="FAQ" />
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
                                    Applicants who prefer to apply in person can visit the nearest branch of Bank Of AJK.
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
                                    This scheme is only for resident Azad Kashmir.
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
                                    Government employees are not eligible under this scheme.
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
                                    However, Certificate / Diploma / Degree holders will be given preference.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column Image -->
                <div class="col-lg-6 text-center mt-4 mt-lg-0">
                    <img src="{{ asset('/assets/img/public/FAQsIllustration.png') }}" class="img-fluid"
                        alt="FAQ Illustration" />
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
