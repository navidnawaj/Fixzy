<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Store a new order
    public function store(Request $request, $serviceId)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'booking_datetime' => 'required|string',
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'service_id' => $serviceId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'booking_datetime' => $request->booking_datetime,
            'status' => 'in progress', // Default status
        ]);

         // Flash success message to session
    session()->flash('success', 'Your order has been placed successfully!');

        return redirect()->back()->with('success', 'Service booked successfully!');
    }

    // Show orders for service provider (seller)
    public function providerOrders()
    {
        $user = Auth::user();

        if ($user->role !== 'seller') {
            abort(403, 'Unauthorized');
        }

        // Corrected: Find services where user_id matches logged-in user
        $services = Service::where('user_id', $user->id)->pluck('id');

        // Get orders for those services
        $orders = Order::whereIn('service_id', $services)->with('user', 'service')->get();

        return view('orders.provider_orders', compact('orders'));
    }


    // Show order history for customer
    public function customerOrders()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)->with('service')->get();

        return view('orders.seller_orders', compact('orders'));
    }


    public function markCompleted($id)
    {
        $order = Order::findOrFail($id);

        // Optional: You can add a check to ensure that the logged-in user owns this service
        $user = auth()->user();

        if ($user->role !== 'seller') {
            abort(403, 'Unauthorized');
        }

        // Check if this order belongs to seller's service
        if ($order->service->user_id != $user->id) {
            abort(403, 'Unauthorized');
        }

        // Mark order as completed
        $order->status = 'completed';
        $order->save();

        return redirect()->back()->with('success', 'Order marked as completed.');
    }



    //Seller Analytics
    // This function will show the analytics for the seller
    // It will show the total revenue earned, total jobs completed, and pending jobs

    public function providerAnalytics()
    {
        $user = auth()->user();

        if ($user->role !== 'seller') {
            abort(403, 'Unauthorized');
        }

        $services = Service::where('user_id', $user->id)->pluck('id');

        $completedOrders = Order::whereIn('service_id', $services)
                                ->where('status', 'completed')
                                ->with('service')
                                ->get();

        $totalRevenue = $completedOrders->sum(function($order) {
            return $order->service->ServicePrice ?? 0;
        });

        $totalCompletedJobs = $completedOrders->count();

        $pendingJobs = Order::whereIn('service_id', $services)
                            ->where('status', 'in progress')
                            ->count();

        return view('analytics', compact('totalRevenue', 'totalCompletedJobs', 'pendingJobs'));
    }


    public function platformAnalytics()
    {
        $user = Auth::user();

        // Optional: protect this route (e.g., only admin can see platform-wide analytics)

        $totalRevenue = Order::where('status', 'completed')
        ->with('service') // eager load service
        ->get()
        ->sum(function ($order) {
            return $order->service->ServicePrice ?? 0;
        });
        $totalOrders = Order::count();
        $totalServices = Service::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalSellers = User::where('role', 'seller')->count();

        return view('admindashboard', [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalServices' => $totalServices,
            'totalCustomers' => $totalCustomers,
            'totalSellers' => $totalSellers,
        ]);
    }


    public function view_order($id)
    {
        $order = Order::findOrFail($id);

        // Check if the logged-in user is either the customer or the service provider
        if (Auth::id() !== $order->user_id && Auth::id() !== $order->service->user_id) {
            abort(403, 'Unauthorized');
        }

        return view('orders.single_order', [
            'order' => $order,
        ]);
    }

    public function store_feedback (Request $request, $id)
    {
        $request->validate([
            'review' => 'required|string|max:255',
        ]);

        $order = Order::findOrFail($id);

        // Check if the logged-in user is the customer
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Unauthorized');
        }

        $order->review = $request->review;
        $order->save();

        return redirect()->back()->with('success', 'Feedback submitted successfully!');
    }

}



