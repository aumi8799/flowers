<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DecorationOrder; // Modelis užsakymui
use App\Mail\DecorationOrderSubmittedMail;
use Illuminate\Support\Facades\Mail;

class DecorationController extends Controller
{
    public function order(Request $request, $type)
{

    $request->validate([
        'event_date' => 'required|date',
        'location' => 'required|string|max:255',
        'budget' => 'required|numeric|min:0',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ]);
 
    $order = new DecorationOrder();
    $order->event_date = $request->input('event_date');
    $order->location = $request->input('location');
    $order->guests_count = $request->input('guests_count');
    $order->tables_count = $request->input('tables_count');
    $order->flowers = $request->input('flowers');
    $order->color_scheme = $request->input('color_scheme');
    $order->style = $request->input('style');
    $order->budget = $request->input('budget');
    $order->name = $request->input('name');
    $order->email = $request->input('email');
    $order->comments = $request->input('comments');
    $order->package = $request->input('package');  
    $order->type = $type;       
    $order->status = DecorationOrder::STATUS_PATEIKTAS;

    $order->save();

    Mail::to($order->email)->send(new DecorationOrderSubmittedMail($order));
    
    return back()->with('success', 'Jūsų užklausa buvo sėkmingai pateikta!');
}

}
