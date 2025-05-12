<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\LoyaltyPoint;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function reserve(Request $request)
    {
        $order = new Order();
        $order->user_id = auth()->id(); 
        $order->delivery_city = $request->delivery_city;
        $order->delivery_address = $request->delivery_address;
        $order->postal_code = $request->postal_code;
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->notes = $request->notes;
        $order->total_price = $request->total_price;
        $order->status = 'rezervuotas'; 
        $order->video = $request->delivery_video;
        $order->delivery_date = $request->delivery_date;
        $order->delivery_time = $request->delivery_time;    

        $order->save();

        $usedPoints = session('loyalty_points_used', 0);
        $order->used_loyalty_points = $usedPoints;
        $order->save();

        if ($usedPoints > 0) {
            LoyaltyPoint::create([
                'user_id' => auth()->id(),
                'points' => -$usedPoints,
                'description' => 'Naudota užsakymui #' . $order->id,
                'order_id' => $order->id,
                'used_loyalty_points' => 1,
            ]);
        }

        if (session('gift_coupon_code')) {
            $coupon = \App\Models\GiftCoupon::where('code', session('gift_coupon_code'))->first();
            if ($coupon && !$coupon->used) {
                $coupon->used = true;
                $coupon->used_in_order_id = $order->id;
                $coupon->save();
            }
        }

        session()->forget(['loyalty_points_used', 'loyalty_discount']);

        $cart = session()->get('cart', []);
        foreach ($cart as $item) {
            $orderItem = null;

            if ($item['type'] === 'product') {
                $orderItem = \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            } elseif ($item['type'] === 'custom_bouquet') {
                $orderItem = \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'custom_bouquet_id' => $item['id'],
                    'quantity' => $item['quantity'] ?? 1,
                    'price' => $item['price'],
                ]);

                \App\Models\CustomBouquet::where('id', $item['id'])->update([
                    'order_id' => $order->id,
                ]);
            } elseif ($item['type'] === 'giftcoupon') {
                \App\Models\GiftCoupon::create([
                    'order_id' => $order->id,
                    'value' => $item['price'],
                    'used' => false,
                    'code' => strtoupper(uniqid('GFT')),
                ]);
            }

            if (isset($item['postcard'])) {
                \App\Models\Postcard::create([
                    'order_id' => $order->id,
                    'order_item_id' => $orderItem?->id,
                    'method' => $item['postcard']['method'] ?? null,
                    'template' => $item['postcard']['template'] ?? null,
                    'message' => $item['postcard']['message'] ?? null,
                    'file_path' => $item['postcard']['file_path'] ?? null,
                ]);
            }
        }

        session()->forget([
            'cart', 'gift_coupon_code', 'gift_coupon_discount'
        ]);

        return redirect()->route('orders.index')->with('success', 'Užsakymas rezervuotas!');
    }
    
    public function processOrder(Request $request)
    {
        // Patikrinkite, ar visi reikalingi laukai užpildyti
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'delivery_address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'delivery_date' => 'required|date|after_or_equal:' . \Carbon\Carbon::now()->addDays(2)->toDateString(),
            'delivery_time' => 'required|string|in:10:00 - 12:00,12:00 - 15:00,15:00 - 18:00',
        ]);

        // Sukurkite naują užsakymą arba apdorokite pagal poreikį
        $order = Order::create([
            'user_id' => auth()->id(), // Jei vartotojas prisijungęs
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'delivery_address' => $request->delivery_address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'delivery_date' => $request->delivery_date,
            'delivery_time' => $request->delivery_time,
            'notes' => $request->notes,
            'total_price' => $request->total, // Priklausomai nuo to, kaip perduodate šią informaciją
            'status' => 'rezervuotas', // Pradinė būsena
            'video' => $request->delivery_video,
        ]);
        // Pridėkite atviruką priklausomai nuo pasirinkimo
        if ($request->has('postcard')) {
            \App\Models\Postcard::create([
                'order_id' => $order->id,
                'template' => $request->postcard_template,
                'message' => $request->postcard_message,
                'method' => $request->postcard_method,
                'file_path' => $request->postcard_file ? $request->file('postcard_file')->store('postcards') : null,
            ]);
        }

        // Peradresavimas į PayPal apmokėjimo puslapį
        return redirect()->route('paypal.payment', ['order_id' => $order->id, 'total' => $order->total_price]);
    }
    // Rodome užsakymus vartotojui
    public function myOrders(Request $request)
    {
        $query = Order::where('user_id', auth()->id());

        if ($request->has('status') && in_array($request->status, ['rezervuotas', 'apmokėtas', 'pristatytas', 'atšauktas'])) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderByDesc('created_at')->paginate(5); // ✅


        return view('orders', compact('orders'));
    }
    public function show($orderId)
    {
        $order = Order::findOrFail($orderId);
    
        return view('orders.show', compact('order'));
    }
    

    // Atšaukiame rezervaciją
    public function destroy(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Negalite atšaukti šio užsakymo.');
        }
    
        if ($order->status === 'atšauktas' || $order->status === 'pristatytas') {
            return redirect()->route('orders.index')->with('error', 'Šio užsakymo atšaukti nebegalima.');
        }
    
        // Atšaukiam užsakymą
        $order->status = 'atšauktas';
        $order->save();
    
        // GRĄŽINAM LOJALUMO TAŠKUS, jei buvo naudoti
        $loyalty = \App\Models\LoyaltyPoint::where('order_id', $order->id)->where('points', '<', 0)->first();
        if ($loyalty) {
            $order->user->increment('total_points', abs($loyalty->points));
            $loyalty->description = 'užsakymas atšauktas';
            $loyalty->points = 0;
            $loyalty->order_id = null;
            $loyalty->save();

        }
    
        // GRĄŽINAM DOVANŲ KUPONĄ, jei buvo naudotas
        $usedCoupon = \App\Models\GiftCoupon::where('used', true)->where('used_in_order_id', $order->id)->first();
        if ($usedCoupon) {
            $usedCoupon->used = false;
            $usedCoupon->used_in_order_id = null;
            $usedCoupon->save();
        }
    
        return redirect()->route('orders.index')->with('success', 'Užsakymas sėkmingai atšauktas.');
    }
    

    // Redaguoti užsakymą
    public function edit(Order $order)
        {
            if ($order->user_id !== auth()->id()) {
                abort(403, 'Neturite teisės redaguoti šio užsakymo.');
            }

            if ($order->status !== 'rezervuotas') {
                return redirect()->route('orders.index')->with('error', 'Tik rezervuotus užsakymus galima redaguoti.');
            }

            return view('orders.edit', compact('order'));
        }

    // Redaguoti rezervaciją

    public function update(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Negalite redaguoti šio užsakymo.');
        }
    
        if ($order->status !== 'rezervuotas') {
            return redirect()->route('orders.show', $order->id)->with('error', 'Tik rezervuotus užsakymus galima redaguoti.');
        }
    
        $request->validate([
            'delivery_city' => 'required|integer',
            'quantities' => 'required|array',
            // Nauji validacijos laukeliai
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'notes' => 'nullable|string|max:1000',
            'video' => 'nullable|boolean', // pridėjome validaciją vaizdo įrašui
            'delivery_date' => 'required|date|after_or_equal:' . now()->addDays(2)->toDateString(),
            'delivery_time' => 'required|string|in:10:00 - 12:00,12:00 - 15:00,15:00 - 18:00',
        ]);
    
        // Atnaujiname užsakymo duomenis
        $order->first_name = $request->first_name;
        $order->last_name = $request->last_name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->notes = $request->notes;
        $order->delivery_city = $request->delivery_city;
        $order->delivery_address = $request->delivery_address;
        $order->postal_code = $request->postal_code;
        $order->delivery_date = $request->delivery_date;
        $order->delivery_time = $request->delivery_time;

        // Jei pasirinktas vaizdo įrašas, pridedame 5 eurus
        if ($request->video == 1) {
            $order->video = 1;
        } else {
            $order->video = 0;
        }
    
        $order->save();
    
        // Atnaujinti prekių kiekius ir sumas
        foreach ($request->quantities as $itemId => $quantity) {
            $item = $order->items()->find($itemId);
            if ($item) {
                $item->quantity = $quantity;
                $item->save();
            }
        }
    
        // Apskaičiuoti bendra užsakymo kainą
        $total = 0;
        foreach ($order->items as $item) {
            $total += $item->price * $item->quantity;
        }
    
        // Jei pasirinktas vaizdo įrašas, pridedame 5 EUR
        if ($order->video == 1) {
            $total += 5;  // Pridedame 5 EUR, jei užsakytas vaizdo įrašas
        }
    
        // Pristatymo kaina priklauso nuo pasirinkto miesto
        $shippingCost = 0;
        if ($order->delivery_city == 7) {
            $shippingCost = 7; // Vilnius
        } elseif ($order->delivery_city == 10) {
            $shippingCost = 10; // Kaunas
        }
    
        $total += $shippingCost;  // Pridedame pristatymo kainą
    
        // Išsaugoti bendrą kainą (jei norite, galite sukurti atskirą lauką `total_price`)
        $order->total_price = $total;
        $order->save();
    
        return redirect()->route('orders.show', $order->id)->with('success', 'Užsakymas sėkmingai atnaujintas.');

    }

    public function courierTasks(Request $request)
    {
        // Užklausos pradžia su rūšiavimu pagal datą ir laiką
        $query = Order::orderBy('delivery_date')->orderBy('delivery_time');
    
        // Filtruojame pagal pasirinktą statusą arba rodom tik aktualius
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereIn('status', ['apmokėtas', 'pristatytas']);
        }
    
        // Paginuojame rezultatus (pvz., po 10 užsakymų)
        $ordersRaw = $query->paginate(6);
    
        // Apskaičiuojam ar kiekvienas užsakymas vėluoja
        foreach ($ordersRaw as $order) {
            $isLate = false;
    
            if ($order->status === 'apmokėtas' && $order->delivery_date && $order->delivery_time) {
                $timeParts = explode(' - ', $order->delivery_time);
                if (count($timeParts) === 2) {
                    try {
                        $endTime = Carbon::parse($order->delivery_date . ' ' . $timeParts[1]);
                        $isLate = now()->greaterThan($endTime);
                    } catch (\Exception $e) {
                        $isLate = false;
                    }
                }
            }
    
            $order->is_late = $isLate;
        }
    
        // Grupavimas pagal datą
        $orders = $ordersRaw->getCollection()->groupBy('delivery_date');
    
        // Suvestinės duomenys
        $summary = [
            'total' => $ordersRaw->total(),
            'today' => $ordersRaw->filter(fn($o) => $o->delivery_date === Carbon::today()->toDateString())->count(),
            'to_deliver' => $ordersRaw->filter(fn($o) => $o->status === 'apmokėtas')->count(),
            'delivered' => $ordersRaw->filter(fn($o) => $o->status === 'pristatytas')->count(),
            'late' => $ordersRaw->filter(fn($o) => $o->is_late)->count(),
        ];
    
        return view('courier.tasks', compact('orders', 'ordersRaw', 'summary'));
    }
    
        public function markAsDelivered($orderId)
        {
            $order = \App\Models\Order::findOrFail($orderId);

            // (Nebūtina) gali pridėti papildomą tikrinimą, ar tai kurjerio paskyra

            if ($order->status !== 'apmokėtas') {
                return redirect()->back()->with('error', 'Tik apmokėtus užsakymus galima pažymėti kaip pristatytus.');
            }

            $order->status = 'pristatytas';
            $order->save();

            return redirect('/courier/tasks')->with('success', 'Užsakymas pažymėtas kaip pristatytas.');

        }
        public function uploadVideo(Request $request, $id)
        {
            $request->validate([
                'video_file' => 'required|mimes:mp4|max:51200000',
            ]);
        
            $path = $request->file('video_file')->store('videos', 'public');
        
            
            $order = Order::findOrFail($id);
            $order->video_path = $path;
            $order->save();
        
            return back()->with('success', 'Vaizdo įrašas įkeltas sėkmingai.');
        }
        

        public function courierShow($id)
        {
            $order = Order::with(['user', 'items.product'])->findOrFail($id);

            if (!in_array($order->status, ['apmokėtas', 'pristatytas'])) {
                abort(403, 'Šio užsakymo peržiūrėti negalima.');
            }

            return view('courier.show', compact('order'));
        }
        public function index(Request $request)
        {
            $query = Order::where('user_id', auth()->id());
        
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }
        
            $orders = $query->orderBy('created_at', 'desc')->paginate(5); // mažiau nei default 15
        
            if ($request->ajax()) {
                return view('partials.order-items', compact('orders'))->render();
            }
        
            return view('orders.index', compact('orders'));
        }

}