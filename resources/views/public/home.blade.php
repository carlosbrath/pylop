@extends('layouts.master-public')
@section('title', $title ?? 'Dashboard')
@section('content')
    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center">
        <div class="overlay"></div>
        <div class="container text-white position-relative text-center">
            <h1 class="display-5 fw-bold mb-3">
                AJK Small Industries<br />Prime Minister Youth Loan Program
            </h1>
            <p class="lead mb-4">
                Empowering youth through accessible business and agriculture loans
                <br />
                under the vision of the Prime Minister.
            </p>
            <a href="#loan_links" class="btn btn-green px-4 py-2">Explore More</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">About the Program</h2>
            <p class="text-center mb-4">
                The AJK Small Industries Prime Minister Youth Loan Program is designed
                to provide subsidized business and agriculture loans to young
                entrepreneurs across Azad Jammu & Kashmir. The initiative aims to
                boost local industries, support innovation, and empower the youth
                financially.
            </p>
            <div class="row text-center">
                <div class="col-md-4">
                    <h4>0% Markup</h4>
                    <p>Enjoy 0% Markup for stress-free, interest-free repayments!</p>
                </div>
                <div class="col-md-4">
                    <h4>PKR 500K – 2 Million</h4>
                    <p>Flexible loan ranges based on tier system</p>
                </div>
                <div class="col-md-4">
                    <h4>Fast Digital Process</h4>
                    <p>Apply and track your application online</p>
                </div>
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
                <li class="list-group-item">Age between 21 to 45 years</li>
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
        <script></script>
    @endpush
@endsection
