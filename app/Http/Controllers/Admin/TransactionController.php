<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transaksi = Transaction::with(['user', 'package'])->get();
        return view('admin.transactions', ['transaksi' => $transaksi]);
    }
}
