<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $reference;
    public $tracking;

    public function __construct($reference, $tracking)
    {
        $this->reference = $reference;
        $this->tracking = $tracking;
    }

    public function build()
    {
        return $this->subject('Inquiry Submitted Successfully')
            ->view('emails.inquiry-confirmation');
    }
}
