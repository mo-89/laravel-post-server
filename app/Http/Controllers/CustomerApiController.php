<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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

    public function handlePost(Request $request)
    {
        Log::info(__METHOD__);
        return response('', 307)->header('Location', '/api/do-nothing');
    }

    public function doNothing(Request $request)
    {
        Log::info(__METHOD__);
        return response('Temporary Redirect', 307);
    }

    public function redirect(Request $request)
    {
        Log::info(__METHOD__);
        $response = $this->store($request);

        if ($response->status() === 201) {
            return redirect('/api/customers')->setStatusCode(307);
        }

        return $response;
    }

    public function redirectToStore(Request $request)
    {
        Log::info(__METHOD__);
        // そもそもURLをリダイレクトして、保存処理に成功した際に307を返すのは標準的ではない

        return Redirect::to('/api/customers', 307);
    }
}
