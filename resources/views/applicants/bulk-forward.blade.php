@extends('layouts.master')

@section('title', $title ?? 'Bulk Forward to Bank')

@section('content')
    <main>
        @include('include.page_header')

        <div class="container-xl px-4 mt-4">
            @include('include.alerts')

            @if ($skipped->count() > 0)
                <div class="alert alert-warning">
                    <strong>{{ $skipped->count() }} applicant(s) were skipped</strong> because they are not eligible (must be Pending status with Paid fee):
                    <ul class="mb-0 mt-2">
                        @foreach ($skipped as $s)
                            <li>{{ $s->application_no }} - {{ $s->name }} (Status: {{ $s->status }}, Fee: {{ ucfirst($s->fee_status ?? 'Unpaid') }})</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($valid->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-building-columns me-1"></i>
                        {{ $valid->count() }} Applicant(s) Ready to Forward
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($valid as $applicant)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 border">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold">{{ $applicant->application_no }}</h6>
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <td class="text-muted" style="width:40%">Name</td>
                                                    <td>{{ $applicant->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Father Name</td>
                                                    <td>{{ $applicant->fatherName }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">CNIC</td>
                                                    <td>{{ $applicant->cnic }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">District</td>
                                                    <td>{{ $applicant->district->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Tehsil</td>
                                                    <td>{{ $applicant->tehsil->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Tier</td>
                                                    <td>
                                                        @switch($applicant->tier)
                                                            @case(1) Tier 1 @break
                                                            @case(2) Tier 2 @break
                                                            @default Tier 3
                                                        @endswitch
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="mt-2">
                                                {!! applicant_status_badge($applicant) !!}
                                                @php
                                                    $feeClass = $applicant->fee_status === 'paid' ? 'success' : 'danger';
                                                @endphp
                                                <span class="badge bg-{{ $feeClass }}">{{ ucfirst($applicant->fee_status ?? 'Unpaid') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-comment-dots me-1"></i>
                        Forward Remarks
                    </div>
                    <div class="card-body">
                        <form action="{{ route('applicants.bulkForward') }}" method="POST">
                            @csrf
                            @foreach ($valid as $applicant)
                                <input type="hidden" name="ids[]" value="{{ $applicant->id }}">
                            @endforeach

                            <div class="mb-3">
                                <label for="remarks" class="form-label">Remarks <span class="text-danger">*</span></label>
                                <textarea name="remarks" id="remarks" class="form-control" rows="3" required
                                    placeholder="Enter common remarks for all applicants...">{{ old('remarks') }}</textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-building-columns me-1"></i> Forward All to Bank
                                </button>
                                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    No eligible applicants to forward. All selected applicants were either already forwarded or have unpaid fees.
                </div>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Reports
                </a>
            @endif
        </div>
    </main>
@endsection
