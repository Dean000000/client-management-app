<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $testMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->testMessage = 'This is a test email.';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.test')
                    ->subject('Test Email from Laravel');
    }
}
