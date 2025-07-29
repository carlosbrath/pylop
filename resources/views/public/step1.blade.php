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

                @include('include.eligibility')
                <div class="p-3 px-5">
                    <form id="step1" class="row g-3 mb-3 shadow-lg shadow rounded p-3" method="POST"
                        action="{{ route('storeForm') }}" onsubmit="validateForm(event, this, 'step1')">
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
                                    <input type="text" name="cnic" id="cnic" value="{{ old('cnic') }}"
                                        class="form-control" placeholder="xxxxx-xxxxxxx-x" maxlength="15" />
                                    <label for="cnic">CNIC Number / شناختی کارڈ نمبر</label>
                                </div>
                            </div>
                            {{-- <p class="text-danger ms-5">Cnic Field required</p> --}}
                        </div>

                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                <div class="form-floating flex-grow-1">
                                    <input type="date" name="issue_date" value="{{ old('issue_date') }}" id="issue_date"
                                        class="form-control" placeholder="CNIC Issue Date" />
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
                                        <option value="1" {{ old('tier') == 1 ? 'selected' : '' }}>Tier 1 (Up to 5
                                            Lakh)</option>
                                        <option value="2" {{ old('tier') == 2 ? 'selected' : '' }}>Tier 2 (5 - 10 Lakh)
                                        </option>
                                        <option value="3" {{ old('tier') == 3 ? 'selected' : '' }}>Tier 3 (10 - 20
                                            Lakh)</option>
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
                </div>
                @include('include.loandetails')

            </div>
        </div>
    </section>

    @push('scripts')
    @endpush
@endsection
