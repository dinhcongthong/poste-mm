<?php

namespace App\Mail\Feedback;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;

    // Variable
    public $subject, $content, $url, $post_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $post_name, $url, $content) {
        $this->subject = $subject;
        $this->post_name = $post_name;
        $this->url = $url;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('emails.feedback.user_mail');
    }
}
