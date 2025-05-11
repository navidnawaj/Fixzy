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

        // Handle POST request for Gemini API
        $apiKey = env('GEMINI_API_KEY');
        $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

        $client = new Client();
        try {
            $response = $client->post($apiUrl, [
                'query' => ['key' => $apiKey],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $request->input('message', 'Hello')],
                            ],
                        ],
                    ],
                ],
            ]);

            $body = json_decode($response->getBody(), true);

            if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
                return response()->json(['response' => $body['candidates'][0]['content']['parts'][0]['text']]);
            } else {
                return response()->json(['error' => 'No response from Gemini'], 500);
            }

        } catch (RequestException $e) {
            return response()->json([
                'error' => 'Gemini API Request Failed',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}