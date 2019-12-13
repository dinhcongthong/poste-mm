<?php

namespace App\Mail\Feedback;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OwnerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject, $url, $email, $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $url, $email, $content)
    {
        $this->subject = $subject;
        $this->url = $url;
        $this->email = $email;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('emails.feedback.owner_mail');
    }
}
