<?php

namespace App\Http\Controllers;

use App\Http\Middleware\OwnerOnly;
use App\Transaction;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(OwnerOnly::class)->only('delete');
    }

    public function index() {
        return view('transactionIndex');
    }

    public function store(Request $request) {
        $input = $request->input('cart');
        $transaction = Auth::user()->inChargeOf()->create([
            'total_price' => 0,
            'payment_type' => 'CASH',
            'unique_id' => uniqid(),
        ]);
        foreach($input as $cartItem) {
            $item = Item::find($cartItem['id']);
            if($cartItem['jumlah'] > $item->stok){
                $cartItem['jumlah'] = $item->stok;
            }
            $harga = $cartItem['jumlah'] * $item->harga;
            $transaction->items()->create([
                'item_id' => $item->id,
                'amount' => $cartItem['jumlah'],
                'total_price' => $harga,
            ]);
            $item->stok -= $cartItem['jumlah'];
            $item->save();
            $transaction->total_price += $harga;
        }
        $transaction->save();

        return response()->json(['status' => 'OK', 'data' => $transaction]);
    }

    public function getList() {
        $transactions = Transaction::all();
        return view('transactionList')->with('transactions', $transactions);
    }

    public function delete(Request $request) {
        $validated = $request->validate([
            'unique_id' => 'required|string'
        ]);
        $transaction = Transaction::where('unique_id', $validated['unique_id'])->firstOrFail();
        foreach ($transaction->items as $item){
            $itemModel = $item->item;
            $itemModel->stok += $item->amount;
            $itemModel->save();
            $item->delete();
        }
        $transaction->delete();
        return redirect('/transaction/list');
    }
}
