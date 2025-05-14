<?php

namespace App\Mail;

use App\Models\DecorationOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DecorationOrderInProgressMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(DecorationOrder $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Jūsų dekoravimo užsakymas pradėtas vykdyti')
                    ->view('emails.decoration_order_in_progress');
    }
}
