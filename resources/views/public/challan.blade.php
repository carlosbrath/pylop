@extends('layouts.master-print')
@push('style')
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .challan-container {
            border: 2px solid #000;
            margin-bottom: 20px;
            padding: 10px;
        }

        .challan-header {
            text-align: center;
            border-bottom: 1px dashed #000;
            margin-bottom: 8px;
            padding-bottom: 5px;
        }

        .challan-title {
            font-weight: bold;
            font-size: 14px;
        }

        .challan-copy {
            text-align: right;
            font-style: italic;
            font-size: 11px;
        }

        .challan-info {
            width: 100%;
            margin-top: 8px;
        }

        .challan-info td {
            padding: 4px;
            border-bottom: 1px dashed #999;
        }

        .footer-note {
            font-size: 10px;
            text-align: center;
            margin-top: 8px;
            border-top: 1px solid #aaa;
            padding-top: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="page">
        @php
            $copies = ['Bank Copy', 'Department Copy', 'Applicant Copy'];
        @endphp

        @foreach ($copies as $copy)
            <div class="challan-container">
                <div class="challan-header">
                    <img src="{{ asset('/assets/img/public/ajklogo.png') }}" height="60" style="float:left;">
                    <div class="challan-title">Government of Azad Jammu & Kashmir</div>
                    <div>Prime Minister Youth Loan Program</div>
                    <div class="challan-copy">{{ $copy }}</div>
                    <div style="clear:both;"></div>
                </div>

                <table class="challan-info">
                    <tr>
                        <td><strong>Challan No:</strong> {{ $applicant->application_no }}</td>
                        <td><strong>Date:</strong> {{ now()->format('d-M-Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Applicant Name:</strong> {{ $applicant->name }}</td>
                        <td><strong>CNIC:</strong> {{ $applicant->cnic }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tier:</strong>
                            @if ($applicant->tier == 1)
                                Tier 1 (Up to 5 Lakh)
                            @elseif($applicant->tier == 2)
                                Tier 2 (5–10 Lakh)
                            @else
                                Tier 3 (10–20 Lakh)
                            @endif
                        </td>
                        <td><strong>Phone:</strong> {{ $applicant->phone }}</td>
                    </tr>
                    <tr>
                        <td><strong>Challan Fee:</strong> {{ challanFee($applicant->tier) }}</td>
                        <td><strong>Account No:</strong>
                            040-14027001
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Bank</strong> Bank of AJK</td>
                        
                    </tr>
                    <tr>
                        <td colspan="2" style="height:40px;"><strong>Bank Officer’s Signature & Stamp:</strong></td>
                    </tr>
                </table>

                <div class="footer-note">
                    This challan is computer generated. Please pay the fee at  Bank of AJK branch only.
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.print();
        });
    </script>
@endpush
