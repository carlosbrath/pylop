<?php

use App\Models\NotificationToken;

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

function firebasenotifications($notification) {
    $url = 'https://fcm.googleapis.com/fcm/send';
    $headers = array(
        'Authorization: key=' . "AAAAxd68FSg:APA91bGM6cDrNwJQEp2gUcrAXGwFJ3YWYTB75JIgWEAnO7TNl68nhqhembfIiRGib4xqjUlB5ht2K3ONOH-Mi4EelZZzp8QchmAkrjPPi2w4lQl9H9imbrBUenJlTgiHi4VpLFccS2uZ",
        'Content-Type: application/json'
    );
    $tokens = NotificationToken::all();
    foreach ($tokens as $key => $token) {

        $fields = array(
            "to" => $token->token_id,
            "notification" => $notification,
        );
        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $result = curl_exec($ch);
        pd($result);
        curl_close($ch);
    }
}
function challanFee($tier)  {
    if($tier==1){
        return 500;
    } elseif($tier==2){
        return 1000;
    } else {
        return 2000;
    }
}
function applicant_status_badge($applicant) {
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
            return '<span class="badge bg-secondary">'.e($applicant->status).'</span>';
    }
}
function tierLabel($tier) {
    return match($tier) {
        1 => 'Tier 1 (Up to 5 Lakh)',
        2 => 'Tier 2 (5 to 10 Lakh)',
        3 => 'Tier 3 (10 to 20 Lakh)',
        default => 'N/A',
    };
}
function generateApplicationNo($id) {
    $date = now()->format('ymd'); 
    $paddedId = str_pad($id, 4, '0', STR_PAD_LEFT); 
    return $date . $paddedId; 
}
