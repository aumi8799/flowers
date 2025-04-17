<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class CancelExpiredReservations extends Command
{
    protected $signature = 'cancel:expired-reservations';
    protected $description = 'Atšaukia užsakymus, kurių rezervacijos galiojimas baigėsi.';

    public function handle()
    {
        $expiredOrders = Order::where('status', 'rezervuotas')
            ->where('created_at', '<', Carbon::now()->subMinutes(2)) // 2 min
            ->get();
    
        foreach ($expiredOrders as $order) {
            $order->status = 'atšauktas';
            $order->cancel_reason = 'Rezervacijos laikas baigėsi';
            $order->save();
    
            $this->info("Užsakymas {$order->id} buvo atšauktas, nes praleista 2 min.");
        }
    }
    
}
