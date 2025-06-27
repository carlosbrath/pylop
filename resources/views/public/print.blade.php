<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Application for Interest-Free Loan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            direction: ltr;
            line-height: 1.8;
            padding: 30px;
        }
        .border-box {
            border: 2px solid #000;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header img {
            height: 80px;
        }
        .section-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 22px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            display: inline-block;
            width: 250px;
            font-weight: bold;
        }
        .checkboxes {
            margin-top: 20px;
        }
        .signature {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="border-box">
        <div class="header">
            <img src="{{ asset('images/ajklogo.png') }}" alt="AJK Government Logo">
            <img src="{{ asset('images/logo.png') }}" alt="Small Industries Logo">
        </div>

        <div class="section-title">
            Azad Kashmir Small Enterprises Corporation<br>
            Prime Minister Youth Loan Program<br>
            Application for Interest-Free Loan
        </div>

        <div class="field"><span class="label">Applicant Name:</span> {{ $applicant->name }}</div>
        <div class="field"><span class="label">Father's Name:</span> {{ $applicant->father_name }}</div>
        <div class="field"><span class="label">CNIC Number:</span> {{ $applicant->cnic }}</div>
        <div class="field"><span class="label">CNIC Issue Date:</span> {{ \Carbon\Carbon::parse($applicant->cnic_issue_date)->format('d-m-Y') }}</div>
        <div class="field"><span class="label">Date of Birth:</span> {{ \Carbon\Carbon::parse($applicant->dob)->format('d-m-Y') }}</div>
        <div class="field"><span class="label">Phone Number:</span> {{ $applicant->phone }}</div>
        <div class="field"><span class="label">Business Name:</span> {{ $applicant->business_name }}</div>
        <div class="field"><span class="label">Business Type:</span> {{ $applicant->business_type }}</div>
        <div class="field"><span class="label">Permanent Address:</span> {{ $applicant->permanent_address }}</div>
        <div class="field"><span class="label">Current Address:</span> {{ $applicant->current_address }}</div>
        <div class="field"><span class="label">District:</span> {{ $applicant->district }}</div>
        <div class="field"><span class="label">Quota:</span> {{ $applicant->quota }}</div>
        <div class="field"><span class="label">Gender:</span> {{ $applicant->gender }}</div>
        <div class="field"><span class="label">Tier:</span> Tier {{ $applicant->tier }}</div>

        <div class="checkboxes">
            <strong>Applicant Signature:</strong> ___________________________
        </div>

        <div class="signature">
            <p>Date: ____________</p>
        </div>
    </div>

    <script>
        window.onload = function () {
            window.print();
        }
    </script>
</body>
</html>
