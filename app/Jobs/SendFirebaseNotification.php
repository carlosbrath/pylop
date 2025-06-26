<?php

namespace App\Jobs;

use App\Models\NotificationToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFirebaseNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $notification;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        //
        $this->notification = $notification;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Authorization: key=' . "AAAAx5rqg7Q:APA91bHOGKgOl2ZnbrsZDiSqTAezCkk5D_l1Z5Z2t8u-bkrcyjdfjRmUo0aBCz7BoiHpTa0NeeJymk7m3xK9v-hsf_muUApBHQ71_LG2NsCcW2vGqMtjLFWoWNU7OTfrYWjeEuNtGNdA",
            'Content-Type: application/json'
        );
        $tokens = NotificationToken::all();
        foreach ($tokens as $key => $token) {

            $fields = array(
                "to" => "c7Zq8IkPZq5UdfrlOiCOBg:APA91bHDt6z0-tvv0cQWe2112-VDmw0FTKTraVPv4csts2ouh6ZcXQHTrF_RnFNFNTicN8iHZEaqJaWzP4IWXWee5uDz0M67hdn8NwNMl8VnDpDl_x4naZDIsu6dO57Au1Gx5Sg_hNiv",
                "notification" => $this->notification,
            );
            $fields = json_encode($fields);
            $ch = curl_init();
            // curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            // $result = curl_exec($ch);
            // if (curl_exec($ch) === false) {
            //     echo 'Curl error: ' . curl_error($ch);
            // } else {
            //     echo 'notification send';
            // }
            curl_close($ch);
        }
    }
}
