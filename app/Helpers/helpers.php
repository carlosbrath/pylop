<?php

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
    switch ($applicant->status) {
        case 'Pending':
            return '<span class="badge bg-warning text-white">Pending</span>';
        case 'Forwarded':
            return '<span class="badge bg-info text-white">Forwarded</span>';
        case 'Rejected':
            return '<span class="badge bg-danger">Rejected</span>';
        case 'Approved':
            return '<span class="badge bg-success">Approved</span>';
        default:
            return '<span class="badge bg-secondary">' . e($applicant->status) . '</span>';
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
