<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MoneyValidationFormRequest;

class BalanceController extends Controller
{
    public function index()
    {
        $userBalance = Auth::user()->balance;
        $amount = number_format($userBalance ? $userBalance->amount : 0, 2, ',', '');

        return view('admin.balance', compact('amount'));
    }

    public function deposit()
    {
        return view('admin.deposit-balance');
    }

    public function store(MoneyValidationFormRequest $request)
    {
        DB::beginTransaction();

        $balance = Auth::user()->balance()->firstOrCreate([]);
        $action = $balance->deposit($request->value);

        if ($action) {

            $action = Auth::user()->transactions()->create([
                'type' => 'I',
                'amount' => $request->value,
                'total_before' => $balance->amount - $request->value,
                'total_after' => $balance->amount,
                'date' => date('Ymd'),
            ]);

            if ($action) {
                DB::commit();

                
                return redirect()
                    ->route('admin.balance')
                    ->with('success', 'Recarga realizada');
            }
        }

        DB::rollBack();

        return redirect()
            ->back()
            ->with('error', 'Falha ao recarregar');
    }
}
