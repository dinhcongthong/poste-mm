<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $company, $subject, $phone, $email, $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $company, $subject, $phone, $email, $content)
    {
        $this->name = $name;
        $this->company = $company;
        $this->phone = $phone;
        $this->email = $email;
        $this->content = $content;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->replyTo($this->email)->subject($this->subject)->view('emails.contact');
    }
}
