<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OfferTemplate extends Mailable
{
    use Queueable, SerializesModels;

    public $offer;

    /**
     * Create a new message instance.
     *
     * @param  Offer  $offer
     */
    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.offer')
            ->with([
                'offer' => $this->offer,
            ])
            ->subject('LS Tires Auto new offer');
    }
}
