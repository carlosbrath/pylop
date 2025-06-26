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

function formateLocation($locationData) {
    // Convert the comma-separated strings to an array of associative arrays
    $locationArray = $locationData->toArray();
   
    $formattedLocations = array_map(function($location) {
        $color = '%2335ce59';

        // Check if latest_location is not null
        if ($location['latest_location'] != null) {
            list($lat, $long) = array_map('trim', explode(',', $location['latest_location']['latlong']));
            // Determine role
                $role = 'Tourist';
                $icon= 'taxi';
            if($location['role_id']==3){
                $role = 'Tourist';
                $color = '%2335ce59';
                $icon= 'taxi';
            }
            if($location['role_id']==4){
                $role = 'Tourist Police Officer';
                $color = '%23092f99';
                $icon= 'taxi';
            }
            if($location['role_id']==5){
                $role = 'Entry Point Officers';
                $color = '%2335ce59';
                $icon= 'taxi';
            } elseif($location['role_id']==6) {
                $role = 'Tour Operator';
                $color = '%234cd73a';
                $icon= 'emergency_share';
            }
            $role= $location['name']. ' '. $role;
            return [
                'lat' => (float) $lat,
                'long' => (float) $long,
                'tooltip' => $role,
                'color' => $color,
                'icon' => $icon,
            ];
        }

        return null; // Return null if latest_location is null
    }, $locationArray);
    $formattedLocations = array_values(array_filter($formattedLocations));
    return $formattedLocations;
}
function tourlocations($locationData)  {
    $locationArray = $locationData->toArray();
    $formattedLocations = array_map(function($location) {
        list($lat, $long) = array_map('trim', explode(',', $location['latlong']));
         // Determine role
         $role = 'user';
         $icon= 'taxi';
         $color= '%23512424';
        $role= 'Tourist'. ' '. $role;
        return [
            'lat' => (float) $lat,
            'long' => (float) $long,
            'tooltip' => $role,
            'color' => $color,
            'icon' => $icon,
        ];
    }, $locationArray);
    return $formattedLocations;
}
