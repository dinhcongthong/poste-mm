<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClassifyContact extends Mailable
{
    use Queueable, SerializesModels;

    public $email_message, $name_message, $subject_message, $contentMessage, $itemContent, $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_message, $name_message, $subject_message, $contentMessage, $itemContent, $link)
    {
        $this->email_message = $email_message;
        $this->name_message = $name_message;
        $this->subject_message = $subject_message;
        $this->contentMessage = $contentMessage;
        $this->itemContent = $itemContent;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject_message.'【POSTEミャンマー】')->replyTo($this->email_message)->view('emails.classify.contact');
    }
}
