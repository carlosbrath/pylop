<?php

namespace App\Notifications;

use App\Models\NotificationToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class FcmNotification extends Notification implements ShouldQueue
{
    use Queueable;
    

    private $title;
    private $body;

    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toFcm($notifiable)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = env('FCM_SERVER_KEY');
        $headers = [
            'Authorization' => 'key=' . $serverKey,
            'Content-Type' => 'application/json',
        ];

        $tokens = NotificationToken::all()->pluck('token_id');
        pd($tokens);
        foreach ($tokens as $token) {
            $fields = [
                "to" => 'dglqVQmA6iY0tpNFjgsoBy:APA91bFFbNn84uYTqlw5iUCahl4IsdPwdbi8J43ZQaUSKjunf1cuDRx6YUIfQFd8hNdwIHSl5rvZX8LNkvK690jPYvEH07mVwEOtWoqjJ3agESMzd0VUvoHmvcV6Lmr69POcFLc2SCpy',
                "notification" => [
                    "title" => $this->title,
                    "body" => $this->body,
                ],
            ];

            Http::withHeaders($headers)->post($url, $fields);

            // Log the response for debugging
        \Log::info('FCM Response:', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
