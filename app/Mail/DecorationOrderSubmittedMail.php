<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\DecorationOrder;

class DecorationOrderSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(DecorationOrder $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Jūsų dekoravimo užklausa gauta')
                    ->view('emails.decoration_order_submitted');
    }
}
