@extends('layouts.master-public')

@section('title', $title ?? 'Application Closed')

@section('content')
<section id="initialSection" class="signup-step-container py-5 text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 bg-light rounded-3 shadow p-5">
                <h2 class="text-success mb-3">Prime Minister Youth Loan Program</h2>
                <h4 class="text-danger">Application Submission Closed</h4>
                <p class="mt-3 text-muted">
                    The application submission period for the Prime Minister Youth Loan Program has ended.
                    We appreciate your interest and encourage you to stay connected for future opportunities.
                </p>
                <p class="text-muted">
                    If you have already submitted an application, you can track its status using the button below.
                </p>
                <img src="{{ asset('/assets/img/public/applicantion-closed.jfif') }}" alt="Coming Soon" class="img-fluid mt-4" style="max-width: 300px;">

                <div class="mt-4">
                    <a href="{{ route('track.application') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-search"></i> Track Your Application
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
