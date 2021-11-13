<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\AdRevenueShareGroup;
use App\Http\Resources\WalletResource;

class WalletController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * List all wallets
     *
     * @return Response
     */
    public function index()
    {
        return Wallet::get();
    }
    
    /**
     * Retrieve the wallet for the given ID.
     *
     * @param  mixed $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $wallet = Wallet::findOrFail($id);
            $wallet = new WalletResource($wallet);
        } catch (\Throwable $th) {
            report($th);
            return response()->json("resource not found", 500);
        }
        return response()->json($wallet);
    }
    
    /**
     * Retrieve the wallet for the given User ID.
     *
     * @param  mixed $user_id
     * @return Response
     */
    public function showByUser($user_id)
    {
        try {
            $wallet = Wallet::where('user_id', $user_id)->firstOrFail();
            $wallet = new WalletResource($wallet);
        } catch (\Throwable $th) {
            report($th);
            return response()->json("resource not found", 500);
        }
        return response()->json($wallet);
    }
}
