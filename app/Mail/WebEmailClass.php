<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WebEmailClass extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $view;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->subject = $data['subject'];
        $this->view = isset($data['view']) ? $data['view'] : 'emails.default';
        $this->data= $data;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->subject,
        );
    }
    public function build()
    {
         
        return $this->subject($this->subject)
                    ->view($this->view)->with($this->data);
    }
    public function attachments()
    {
        return [];
    }
}
