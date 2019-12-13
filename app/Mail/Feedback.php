<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Feedback extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $email, $postType, $postId, $content, $subject, $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $postType, $postId, $content, $subject, $status)
    {
        $this->name = $name;
        $this->email = $email;
        $this->postType = $postType;
        $this->postId = $postId;
        $this->content = $content;
        $this->subject = $subject;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo($this->email)->subject($this->subject)->view('emails.feedback');
    }
}
