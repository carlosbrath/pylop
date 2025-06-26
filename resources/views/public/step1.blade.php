@extends('layouts.master-public')
@section('title', $title ?? 'Dashboard')
@section('content')
    <section id="initialSection" class="signup-step-container py-4">
        <div class="container">
            <div class="row d-flex justify-content-center form-bg pb-4">
                <div class="row justify-content-center bg-primary blue-gradient text-white py-3 mb-4">
                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <h2 class="mb-0 text-center w-100">
                            AJK PM Youth Loan Program - Application Form
                        </h2>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-5">
                        <ul class="list-unstyled">
                            <li>
                                ✅ It is mandatory to fill all required fields marked with *
                            </li>
                            <li>
                                📲 Feedback/Complaints can be submitted at Citizen Portal App
                            </li>
                            <li>
                                🆔 cnic, Issue Date & dob will be verified from NADRA — fill
                                correctly
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2 text-center">
                        <img src="./images/pmyp-01.png" class="img-fluid px-2" alt="PMYP Logo" />
                    </div>
                    <div class="col-md-5 text-end">
                        <ul class="list-unstyled text-end">
                            <li>تمام فیلڈز کو * نشان کے ساتھ بھرنا لازمی ہے ✅</li>
                            <li>شکایات یا تجاویز کے لیے سٹیزن پورٹل استعمال کریں 📲</li>
                            <li>شناختی کارڈ کی معلومات نادرا سے تصدیق ہوں گی 🆔</li>
                        </ul>
                    </div>
                </div>

                <div class="text-center mb-3">
                    <a href="#" class="btn btn-outline-primary mx-2">📘 Instructions</a>
                    <a href="#" class="btn btn-outline-success mx-2">User Manual English</a>
                    <a href="#" class="btn btn-outline-success mx-2">اردو ہدایت نامہ</a>
                    <a href="#" class="btn btn-outline-danger mx-2">Edit Application</a>
                </div>

                <form id="initialForm" class="row g-3 mt-3" method="POST" action="{{ route('storeForm') }}">
                    @csrf
                    <div class="col-md-4">
                        <label class="form-label">
                            cnic <span class="text-danger">*</span>
                            <span class="float-end text-secondary" dir="rtl">شناختی کارڈ نمبر</span>
                        </label>
                        <input type="text" name="cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x"
                            maxlength="15" />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            cnic Issue Date <span class="text-danger">*</span>
                            <span class="float-end text-secondary" dir="rtl">شناختی کارڈ کے اجراء کی تاریخ</span>
                        </label>
                        <input type="date" name="issue_date" class="form-control" />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            Tier <span class="float-end text-secondary" dir="rtl">درجہ</span>
                        </label>
                        <select class="form-select" name="tier">
                            <option selected disabled>Select Tier</option>
                            <option value="1">Tier 1 (Up to 5 Lakhs)</option>
                            <option value="2">Tier 2 (5 Lakhs - 10 Lakhs)</option>
                            <option value="3">Tier 3 (10 Lakhs - 20 Lakhs)</option>
                        </select>
                    </div>

                    <input type="hidden" name="form_stage" value="step1">

                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-success px-5">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </section>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <script>
            $(document).ready(function() {
                $('input[name="cnic"]').mask('00000-0000000-0');
                $('input[name="phone"]').mask('0000-0000000');
            });
        </script>
    @endpush
@endsection
