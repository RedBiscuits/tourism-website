<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\OfferTemplate;

class SendOfferEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $offer;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $offer)
    {
        $this->email = $email;
        $this->offer = $offer;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Send the email using the Mail facade
        Mail::to($this->email)->send(new OfferTemplate($this->offer));
    }
}
