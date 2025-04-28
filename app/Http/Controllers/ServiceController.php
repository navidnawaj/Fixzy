<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Order;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {   
        $service = Service::all();
        return view('service.services', [
            'services' => $service,
        ]);
    }

    public function create()
    {
        return view('service.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ServiceName' => 'required|string|max:255',
            'ServiceDescription' => 'required|string',
            'ServicePrice' => 'required|numeric|min:0',
            'ServiceCategory' => 'nullable|string|max:255',
        ]);

        // 🛠 Add the logged-in user's ID into the data
        $data['user_id'] = auth()->id(); 

        $newservice = Service::create($data);

        session()->flash('success', 'Service created successfully!');

        return back();
    }

    public function view_service($id)
    {
        $service = Service::findOrFail($id);
        return view('service.single_service', [
            'service' => $service,
        ]);
    }

    public function provider_orders()
    {
        // Fetch the logged-in user (service provider)
        $user = auth()->user();

        if ($user->role === 'seller') {
            // Fetch orders related to the services provided by this service provider (user)
            $orders = Order::whereHas('service', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } else {
            $orders = collect(); // If not seller, no orders
        }

        // Pass the orders to the view (orders.blade.php)
        return view('orders.provider_orders', compact('orders'));
    }
}
