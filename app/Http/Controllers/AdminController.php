<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\GiftCoupon;
use Illuminate\Support\Facades\Hash;
use App\Models\SpecialOffer;
use Illuminate\Support\Facades\Storage;
use App\Models\DecorationOrder;
use App\Mail\DecorationOrderRejectedMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\DecorationOrderInProgressMail;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function users(Request $request)
    {
        $query = User::query();
    
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
    
        $users = $query->withCount(['orders', 'reviews'])
        ->orderBy('created_at', 'desc')
        ->paginate(5); // arba bet koks kiekis per puslapį
        
        return view('admin.users', compact('users'));
    }
    

    public function orders(Request $request)
    {
        $query = Order::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(5); // arba kiek nori

        return view('admin.orders', compact('orders'));
    }

    public function reviews(Request $request)
    {
        $query = Review::with(['user', 'order'])
            ->orderBy('created_at', 'desc');

        // Filtravimas pagal įvertinimą
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->paginate(5);

        return view('admin.reviews', compact('reviews'));
    }
    public function editReview(Review $review)
    {
        return view('admin.review_edit', compact('review'));
    }

    public function updateReview(Request $request, Review $review)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update($validated);

        return redirect()->route('admin.reviews')->with('success', 'Atsiliepimas atnaujintas sėkmingai.');
    }
    public function destroyReview(Review $review)
{
    $review->delete();

    return redirect()->route('admin.reviews')->with('success', 'Atsiliepimas sėkmingai ištrintas.');
}
public function editUser(User $user)
{
    return view('admin.user_edit', compact('user'));
}

public function updateUser(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'role' => 'required|string|in:user,admin,courier'
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('admin.users')->with('success', 'Vartotojo duomenys atnaujinti.');
}

public function destroyUser(User $user)
{
    $user->delete();
    return redirect()->route('admin.users')->with('success', 'Vartotojas sėkmingai ištrintas.');
}
public function showOrder(Order $order)
{
    $order->load('user', 'items.product', 'bouquets', 'subscriptions'); // kad būtų pilna informacija
    return view('admin.order_show', compact('order'));
}
public function editOrder(Order $order)
{
    return view('admin.order_edit', compact('order'));
}

public function updateOrder(Request $request, Order $order)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'required|string|max:30',
        'email' => 'required|email|max:255',
        'delivery_city' => 'required|string|max:255',
        'delivery_address' => 'nullable|string|max:255',
        'postal_code' => 'nullable|string|max:255',
        'delivery_date' => 'nullable|date',
        'delivery_time' => 'nullable|string|max:255',
        'notes' => 'nullable|string',
        'status' => 'required|string|max:255',
    ]);

    $order->update($request->only([
        'first_name', 'last_name', 'phone', 'email',
        'delivery_city', 'delivery_address', 'postal_code',
        'delivery_date', 'delivery_time', 'notes', 'status'
    ]));

    return redirect()->route('admin.orders')->with('success', 'Užsakymas atnaujintas sėkmingai.');
}
public function coupons(Request $request)
{
    $query = GiftCoupon::query();

    if ($request->filled('used')) {
        $query->where('used', $request->used);
    }

    $coupons = $query->orderByDesc('created_at')->paginate(5);

    return view('admin.coupons.index', compact('coupons'));
}


public function createCoupon()
{
    return view('admin.coupons.create');
}

public function storeCoupon(Request $request)
{
    $request->validate([
        'code' => 'required|string|unique:gift_coupons,code',
        'value' => 'required|numeric|min:0.01',
        'order_id' => 'nullable|integer|exists:orders,id',
    ]);

    GiftCoupon::create([
        'code' => $request->code,
        'value' => $request->value,
        'order_id' => $request->order_id,
    ]);

    return redirect()->route('admin.coupons.index')->with('success', 'Kuponas sukurtas sėkmingai.');
}
public function destroy($id)
{
    $coupon = GiftCoupon::findOrFail($id);
    $coupon->delete();

    return redirect()->route('admin.coupons.index')->with('success', 'Kuponas ištrintas sėkmingai.');
}

public function editCoupon(GiftCoupon $coupon)
{
    return view('admin.coupons.edit', compact('coupon'));
}

public function updateCoupon(Request $request, GiftCoupon $coupon)
{
    $request->validate([
        'code' => 'required|string|unique:gift_coupons,code,' . $coupon->id,
        'value' => 'required|numeric|min:0.01',
        'used' => 'required|in:0,1',
        'used_in_order_id' => 'nullable|integer|exists:orders,id',
        'order_id' => 'nullable|integer|exists:orders,id',
    ]);

    $coupon->update([
        'code' => $request->code,
        'value' => $request->value,
        'used' => $request->used,
        'used_in_order_id' => $request->used_in_order_id,
        'order_id' => $request->order_id,
    ]);

    return redirect()->route('admin.coupons.index')->with('success', 'Kuponas atnaujintas sėkmingai.');
}

public function createUser()
{
    return view('admin.user_create');
}

public function storeUser(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role' => 'required|in:user,admin,courier',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('admin.users')->with('success', 'Vartotojas sėkmingai sukurtas!');
}

public function showSpecialOffers()
{
    $offers = SpecialOffer::latest()->paginate(6);
    return view('admin.special_offers.index', compact('offers'));
}

public function createSpecialOffer()
{
    return view('admin.special_offers.create');
}

public function storeSpecialOffer(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:special_offers,code',
        'discount' => 'required|numeric|min:1|max:100',
        'description' => 'nullable|string',
        'valid_until' => 'nullable|date',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $imageName = null;
    if ($request->hasFile('image')) {
        $imageName = time() . '_' . $request->image->getClientOriginalName();
        $request->image->move(public_path('images/special_offers'), $imageName);
    }

    SpecialOffer::create([
        'title' => $request->title,
        'code' => strtoupper($request->code),
        'discount' => $request->discount / 100,
        'description' => $request->description,
        'valid_until' => $request->valid_until,
        'image' => $imageName,
    ]);

    return redirect()->route('admin.special_offers.index')->with('success', 'Pasiūlymas sukurtas sėkmingai!');
}

public function editSpecialOffer($id)
{
    $offer = SpecialOffer::findOrFail($id);
    return view('admin.special_offers.edit', compact('offer'));
}

public function updateSpecialOffer(Request $request, $id)
{
    $offer = SpecialOffer::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'code' => 'required|string|max:50|unique:special_offers,code,' . $offer->id,
        'discount' => 'required|numeric|min:1|max:100',
        'description' => 'nullable|string',
        'valid_until' => 'nullable|date',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        if ($offer->image) {
            @unlink(public_path('images/special_offers/' . $offer->image));
        }
        $imageName = time() . '_' . $request->image->getClientOriginalName();
        $request->image->move(public_path('images/special_offers'), $imageName);
        $offer->image = $imageName;
    }

    $offer->update([
        'title' => $request->title,
        'code' => strtoupper($request->code),
        'discount' => $request->discount / 100,
        'description' => $request->description,
        'valid_until' => $request->valid_until,
    ]);

    return redirect()->route('admin.special_offers.index')->with('success', 'Akcija atnaujinta.');
}

public function destroySpecialOffer($id)
{
    $offer = SpecialOffer::findOrFail($id);
    if ($offer->image) {
        @unlink(public_path('images/special_offers/' . $offer->image));
    }
    $offer->delete();
    return redirect()->route('admin.special_offers.index')->with('success', 'Akcija pašalinta.');
}

// Rodyti visus užsakymus
    public function showDecorOrders()
    {
        $orders = DecorationOrder::latest()->paginate(6); // Puslapiavimas
        return view('admin.decor_orders.index', compact('orders'));
    }

    // Rodyti užsakymo peržiūros puslapį
    public function viewDecorOrder($id)
    {
        $order = DecorationOrder::findOrFail($id);
        return view('admin.decor_orders.show', compact('order'));
    }

    // Rodyti užsakymo redagavimo formą
    public function editDecorOrder($id)
    {
        $order = DecorationOrder::findOrFail($id);
        return view('admin.decor_orders.edit', compact('order'));
    }

    // Atnaujinti užsakymą
    public function updateDecorOrder(Request $request, $id)
{
    $order = DecorationOrder::findOrFail($id);

    // Validacija
    $request->validate([
        'event_date' => 'required|date',
        'location' => 'required|string|max:255',
        'budget' => 'required|numeric|min:0',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'status' => 'required|in:pateiktas,vykdomas,atliktas,atmestas',
        'rejection_reason' => 'required_if:status,atmestas|string|nullable',
    ]);

    // Atnaujinti užsakymą
    $order->event_date = $request->event_date;
    $order->location = $request->location;
    $order->guests_count = $request->guests_count;
    $order->tables_count = $request->tables_count;
    $order->flowers = $request->flowers;
    $order->color_scheme = $request->color_scheme;
    $order->style = $request->style;
    $order->budget = $request->budget;
    $order->name = $request->name;
    $order->email = $request->email;
    $order->comments = $request->comments;
    $order->package = $request->package;
    $order->type = 'corporate';  // Įmonių renginio tipas
    $order->status = $request->status;

    $order->save();

    if ($request->status === 'atmestas' && $request->filled('rejection_reason')) {
        Mail::to($order->email)->send(new \App\Mail\DecorationOrderRejectedMail($order, $request->rejection_reason));
    }

    if ($request->status === 'vykdomas') {
        Mail::to($order->email)->send(new DecorationOrderInProgressMail($order));
    }

    return redirect()->route('admin.decor_orders')->with('success', 'Užsakymas sėkmingai atnaujintas!');
}


}
