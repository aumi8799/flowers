<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPaidConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $invoicePath;

    public function __construct(Order $order, string $invoicePath)
    {
        $this->order = $order;
        $this->invoicePath = $invoicePath;
    }

    public function build()
    {
        return $this->subject('Užsakymas #' . $this->order->id . ' apmokėtas')
            ->view('emails.order_paid_confirmation')
            ->attach($this->invoicePath, [
                'as' => 'faktura.pdf',
                'mime' => 'application/pdf',
            ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Užsakymas apmokėtas – Bloom & Bliss',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order_paid_confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
