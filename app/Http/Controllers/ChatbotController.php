<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function ask(Request $request)
    {
        $userMessage = $request->input('message');

        $response = Http::post('http://127.0.0.1:5000/ask', ['message' => $userMessage]);

        $botResponse = $response->json('response');

        return response()->json(['userMessage' => $userMessage, 'botResponse' => $botResponse]);
    }
}
