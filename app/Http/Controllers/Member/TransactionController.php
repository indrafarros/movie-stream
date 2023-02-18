<?php

namespace App\Http\Controllers\Member;

use App\Models\Package;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $package = Package::findOrFail($request->package_id);
        $transaction = Transaction::create([
            'package_id' => $package->id,
            'user_id' => Auth::user()->id,
            'amount' => $package->price,
            'transaction_code' => 'TRX' . Str::random(10),
            'status' => 'pending'
        ]);
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVERKEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = (bool) env('MIDTRANS_IS_PRODUCTION');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = (bool) env('MIDTRANS_IS_SANITIZED');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = (bool) env('MIDTRANS_IS_3DS');

        $params = array(
            'transaction_details' => array(
                'order_id' => $transaction->transaction_code,
                'gross_amount' => $transaction->amount,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'last_name' => 'pratama',
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            ),
        );

        $midtransTransaction = \Midtrans\Snap::createTransaction($params);
        $midtransRedirect = $midtransTransaction->redirect_url;

        return redirect($midtransRedirect);

        // $snapToken = \Midtrans\Snap::getSnapToken($params);
    }
}
