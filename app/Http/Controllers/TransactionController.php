<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = new Transaction();
        $types = $transaction->type();

        $transactions = Auth::user()->transactions()
            ->with('sender')
            ->paginate(5);

        return view('admin.transaction.index', compact('transactions', 'types'));
    }

    public function search(Request $request)
    {
        $data = $request->except('_token');

        $transactions = Transaction::where('user_id', Auth::user()->id)
            ->where(function ($query) use ($data) {
                if (isset($data['id'])) {
                    $query->where('id', $data['id']);
                }
                if (isset($data['date'])) {
                    $query->where('date', $data['date']);
                }
                if (isset($data['type'])) {
                    $query->where('type', $data['type']);
                }
            })
            ->with('sender')->paginate(5);

        $transaction = new Transaction();
        $types = $transaction->type();

        return view('admin.transaction.index', compact('transactions', 'types', 'data'));
    }
}
