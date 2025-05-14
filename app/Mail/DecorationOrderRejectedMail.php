<?php

namespace App\Mail;

use App\Models\DecorationOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DecorationOrderRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $reason;

    public function __construct(DecorationOrder $order, string $reason)
    {
        $this->order = $order;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Jūsų dekoravimo užklausa atmesta')
                    ->view('emails.decoration_order_rejected');
    }
}
