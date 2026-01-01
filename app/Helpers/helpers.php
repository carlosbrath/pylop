<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

if (!function_exists("pd")) {
    function pd($obj, $d = true)
    {
        echo '<pre>';
        print_r(json_decode($obj));
        if ($d) {
            die;
        }
    }
}
if (!function_exists("ps")) {
    function ps($obj, $d = true)
    {
        echo '<pre>';
        print_r($obj);
        if ($d) {
            die;
        }
    }
}
function challanFee($tier)
{
    if ($tier == 1) {
        return 500;
    } elseif ($tier == 2) {
        return 1000;
    } else {
        return 2000;
    }
}
function applicant_status_badge($applicant)
{
    $cutoffDate = Carbon::parse('2026-01-21');
    switch ($applicant->status) {
        case 'Pending':
            return '<span class="badge bg-warning text-white">Pending</span>';
        case 'Forwarded':
            return '<span class="badge bg-info text-white">Forwarded</span>';
        case 'Rejected':
            if (!Auth::check() && Carbon::now()->lt($cutoffDate)) {
                return '<span class="badge bg-warning text-white">Pending</span>';
            }
            return '<span class="badge bg-danger">Rejected</span>';
        case 'Approved':
            return '<span class="badge bg-success">Approved</span>';
        default:
            return '<span class="badge bg-danger">' . e($applicant->status) . '</span>';
    }
}
function applicant_status_message($applicant)
{

    $cutoffDate = Carbon::parse('2026-01-21');

    switch ($applicant->status) {

        case 'NotCompleted':
            return '
                <div class="mt-1">
                    <strong>
                        Please review your application information, upload the challan,
                        and submit your application to proceed further.
                    </strong>
                </div>
            ';

        case 'Pending':
            return '
                <div class="mt-1">
                    <strong>
                        Your application has been received and is currently under process.
                        After verification, it will be forwarded to Bank of AJK for further
                        processing.
                    </strong>
                </div>
            ';

        case 'Forwarded':
            return '
                <div class="mt-1">
                    <strong>
                        Your application has been forwarded to Bank of AJK.
                        You may visit the concerned Bank of AJK branch for further
                        information or any additional requirements.
                    </strong>
                </div>
            ';

        case 'Rejected':
            if (!Auth::check() && Carbon::now()->lt($cutoffDate)) {
                return '
                    <div class="mt-1">
                        <strong>
                            Your application has been received and is currently under process.
                            After verification, it will be forwarded to Bank of AJK for further
                            processing.
                        </strong>
                    </div>
                ';
            }
            return '
                <div class="mt-1 text-danger">
                    <strong>
                        Your application has been rejected.
                        Please review the remarks for further details.
                    </strong>
                </div>
            ';

        case 'Approved':
            return '
                <div class="mt-1 text-success">
                    <strong>
                        Your application has been approved.
                        Bank of AJK will contact you for the next steps.
                    </strong>
                </div>
            ';

        default:
            return '';
    }
}

if (!function_exists('verifyRecaptcha')) {

    function verifyRecaptcha($recaptchaResponse)
    {
        if (!$recaptchaResponse) {
            return [
                'status' => false,
                'message' => 'Human verification failed. Please check the reCAPTCHA.'
            ];
        }

        $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';
        $secretKey = env('RECAPTCHA_SECRET_KEY');

        $response = file_get_contents(
            $verifyURL . '?secret=' . $secretKey . '&response=' . $recaptchaResponse
        );

        $responseKeys = json_decode($response, true);

        if (!isset($responseKeys['success']) || !$responseKeys['success']) {
            return [
                'status' => false,
                'message' => 'Human verification failed. Please try again.'
            ];
        }

        return [
            'status' => true,
            'message' => 'Verified'
        ];
    }
}
function tierLabel($tier)
{
    return match ($tier) {
        1 => 'Tier 1 (Up to 5 Lakh)',
        2 => 'Tier 2 (5 to 10 Lakh)',
        3 => 'Tier 3 (10 to 20 Lakh)',
        default => 'N/A',
    };
}
function generateApplicationNo($id)
{
    $date = now()->format('ymd');
    $paddedId = str_pad($id, 4, '0', STR_PAD_LEFT);
    return $date . $paddedId;
}
