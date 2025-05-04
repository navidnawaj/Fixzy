<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ChatController extends Controller
{
    public function index(Request $request)
{
    if ($request->isMethod('GET')) {
        return view('chat'); // Return a form for GET requests
    }

    // Handle POST request (your existing code)
    $apiKey = env('DEEPSEEK_API_KEY');
    $apiUrl = 'https://api.deepseek.com/v1/chat/completions';

    $client = new Client();
    try {
        $response = $client->post($apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'deepseek-chat',
                'messages' => [
                    ['role' => 'user', 'content' => $request->input('message', 'Hello')]
                ]
            ]
        ]);

        return response()->json(json_decode($response->getBody(), true));
    } catch (RequestException $e) {
        return response()->json([
            'error' => 'API Request Failed',
            'details' => $e->getMessage()
        ], 500);
    }
}
}

