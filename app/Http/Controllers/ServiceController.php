<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Order;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {   
        $query = Service::query();

        // Search by keyword
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('ServiceName', 'LIKE', "%{$searchTerm}%")
                ->orWhere('ServiceDescription', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Filter by Price Range
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('ServicePrice', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('ServicePrice', '<=', $request->max_price);
        }

        $service = $query->get();

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
        $user = auth()->user();

        if ($user->role === 'seller') {
            $orders = Order::whereHas('service', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } else {
            $orders = collect(); // If not seller, no orders
        }

        return view('orders.provider_orders', compact('orders'));
    }

    //API 

    public function serviceapi()
    {
        $services = Service::all();
        return response()->json($services);
    }
}
