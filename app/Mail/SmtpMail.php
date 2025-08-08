<?php

namespace App\Mail;

use App\Models\General;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SmtpMail extends Mailable
{
    use Queueable, SerializesModels;
    public $from_email;
    public $web_name;
    public $subject;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_from, $subject, $message, $fromName = null)
    {
        $general = General::first();
        $this->from_email = $email_from;
        $this->web_name = ($fromName) ? : @$general->web_name;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return @$this->from($this->from_email, $this->web_name)->view('layouts.mail')->with('body', $this->message);
    }
}
