<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Siunčiam el. laišką į jūsų el. paštą
        Mail::raw("Žinutė nuo: {$validated['name']} ({$validated['email']})\n\n{$validated['message']}", function ($message) {
            $message->to('bloomandblissshoponline@gmail.com')
                    ->subject('Nauja žinutė iš kontaktų formos');
        });

        return back()->with('success', 'Jūsų žinutė išsiųsta sėkmingai!');
    }
}
