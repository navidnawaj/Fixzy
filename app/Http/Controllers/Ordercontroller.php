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

        return view('orders.customer', compact('orders'));
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





    public function providerAnalytics()
    {
        $user = auth()->user();

        if ($user->role !== 'seller') {
            abort(403, 'Unauthorized');
        }

        // Get all services created by this user
        $services = Service::where('user_id', $user->id)->pluck('id');

        // Get all completed orders for these services
        $completedOrders = Order::whereIn('service_id', $services)
                                ->where('status', 'completed')
                                ->with('service')
                                ->get();

        // Total revenue earned
        $totalRevenue = $completedOrders->sum(function($order) {
            return $order->service->ServicePrice ?? 0;
        });

        // Total jobs completed
        $totalCompletedJobs = $completedOrders->count();

        // Pending jobs
        $pendingJobs = Order::whereIn('service_id', $services)
                            ->where('status', 'pending')
                            ->count();

        return view('analytics', compact('totalRevenue', 'totalCompletedJobs', 'pendingJobs'));
    }

}
