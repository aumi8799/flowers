<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;

class InvoiceService
{
    public function generateInvoicePdf(Order $order): string
    {
        $pdf = Pdf::loadView('pdf.invoice', ['order' => $order]);
        $fileName = 'invoices/invoice_order_' . $order->id . '.pdf';

        Storage::disk('local')->put($fileName, $pdf->output());

        return storage_path('app/private/invoices/invoice_order_' . $order->id . '.pdf');
    }
}
