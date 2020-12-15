<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $fromAddress;
    protected $toAddress;
    protected $subjectText;
    protected $textContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fromAddress, $toAddress, $subjectText, $textContent)
    {
        $this->fromAddress = $fromAddress;
        $this->toAddress = $toAddress;
        $this->subjectText = $subjectText;
        $this->textContent = $textContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromAddress)
            ->to($this->toAddress)
            ->subject($this->subjectText)
            ->markdown('emails.send-email', ['content' => $this->textContent]);
    }
}
