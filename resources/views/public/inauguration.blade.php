@extends('layouts.master-public')

@section('title', $title ?? 'Coming Soon')

@section('content')
<section id="initialSection" class="signup-step-container py-5 text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 bg-light rounded-3 shadow p-5">
                <h2 class="text-success mb-3"> Prime Minister Youth Loan Program</h2>
                <h4 class="text-secondary">We are waiting for the official inauguration.</h4>
                <p class="mt-3 text-muted">
                    The online application form will be available soon after the official announcement.
                </p>
                <img src="{{ asset('/assets/img/public/comming-soon.jpg') }}" alt="Coming Soon" class="img-fluid mt-4" style="max-width: 300px;">
            </div>
        </div>
    </div>
</section>
@endsection
