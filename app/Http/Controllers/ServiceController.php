<?php

namespace App\Http\Controllers;
use App\Models\Service;

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
            'ServiceCategory' => 'nullable',
        ]);

        $newservice = Service::create($data);

        session()->flash('success', 'Service created successfully!');

        return back();
    }
}
