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
                    <img src="{{ asset('/assets/img/public/logo.png') }}" height="60" style="float:left;"> 
                    <img src="{{ asset('/assets/img/public/bajk-logo.png') }}" height="60" style="float:right;"> 
                    <div class="challan-title">Azad Kashmir Small Industries Corporation</div>
                    <div>Prime Minister Youth Loan Program</div>
                    <div class="challan-copy mt-4">{{ $copy }}</div>
                    <div style="clear:both;"></div>
                </div>

                <table class="challan-info">
                    <tr>
                        <td><strong>Challan No (Form No):</strong></td>
                        <td><strong>Date:</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Applicant Name:</strong> </td>
                        <td><strong>CNIC:</strong> </td>
                    </tr>
                    <tr>
                        <td><strong>Loan Amount:</strong>
                            
                        </td>
                        <td><strong>Phone:</strong> </td>
                    </tr>
                    <tr>
                        <td><strong>Form Fee:</strong> </td>
                        <td><strong>Bank:</strong> Bank of AJK</td>
                    </tr>
                    <tr>
                        <td><strong>Account Title:</strong> MD AKSIC (CREDIT ASSIST SCHEME). </td>
                        <td><strong>Account No:</strong>
                            14027001 040
                        </td>
                        
                    </tr>
                    <tr>
                        <td  style="height:40px;"><strong>Depositor's Signature:</strong></td>
                        <td  style="height:40px;"><strong>Bank Officer’s Signature & Stamp:</strong></td>
                    </tr>
                </table>

                <div class="footer-note">
                    Please pay the fee at  Bank of AJK branch only.
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
