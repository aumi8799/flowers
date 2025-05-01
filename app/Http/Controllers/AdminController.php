<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;

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
    
        $users = $query->withCount(['orders', 'reviews'])->orderBy('created_at', 'desc')->get();
    
        return view('admin.users', compact('users'));
    }
    

    public function orders(Request $request)
    {
        $query = Order::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10); // arba kiek nori

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

        $reviews = $query->paginate(10);

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
}
