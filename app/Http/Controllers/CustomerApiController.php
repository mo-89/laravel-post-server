<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerApiController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', ['customers' => $customers]);
    }

    public function store(Request $request)
    {
        try {
            Log::info(__METHOD__);
            $apiKey = $request->header('x-api-key');
            $correctKey = 'test';
            if ($apiKey != $correctKey) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            // バリデーション
            $validated = $request->validate([
                'name' => 'required|max:255',
                'age' => 'required|integer',
                'memo' => 'nullable|max:500'
            ]);

            // データの作成
            $customer = Customer::create($validated);
            return response()->json(['message' => 'Successfully created', 'customer' => $customer], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
