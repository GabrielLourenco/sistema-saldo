<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MoneyValidationFormRequest;
use App\Models\User;

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

    public function withdraw()
    {
        return view('admin.withdraw');
    }

    public function withdrawStore(MoneyValidationFormRequest $request)
    {
        $balance = Auth::user()->balance()->firstOrCreate([]);
        $totalBefore = $balance->amount;

        if ($balance->amount < $request->value) {
            return redirect()
            ->back()
            ->with('error', 'Não há saldo suficiente');
        }
        DB::beginTransaction();

        $action = $balance->withdraw($request->value);

        if ($action) {

            $action = Auth::user()->transactions()->create([
                'type' => 'O',
                'amount' => $request->value,
                'total_before' => $totalBefore,
                'total_after' => $balance->amount,
                'date' => date('Ymd'),
            ]);

            if ($action) {
                DB::commit();

                
                return redirect()
                    ->route('admin.balance')
                    ->with('success', 'Retirada realizada');
            }
        }

        DB::rollBack();

        return redirect()
            ->back()
            ->with('error', 'Falha ao retirar');
    }

    public function transfer()
    {
        return view('admin.transfer');
    }

    public function confirmTransfer(Request $request)
    {
        $to = $request->input('sender');
        $sender = User::where('name', 'LIKE', '%$to%')
            ->orWhere('email', $to)
            ->get()
            ->first();
        if (!$sender) {
            return redirect()
                ->back()
                ->with('error', 'Usuário informado não foi encontrado.');
            }
            
        if ($sender->id === Auth::user()->id) {
            return redirect()
                ->back()
                ->with('error', 'Você não pode transferir para você mesmo.');
        }

        $balance = Auth::user()->balance;

        return view('admin.transfer.confirm', compact('sender', 'balance'));
    }

    public function storeTransfer(MoneyValidationFormRequest $request)
    {
        $destinatary = User::find($request->sender_id);
        if (!$destinatary) {
            return redirect()
                ->back()
                ->with('error', 'Usuário não encontrado');
        }

        $balance = Auth::user()->balance()->firstOrCreate([]);
        $totalBefore = $balance->amount ? $balance->amount : 0;

        if ($balance->amount < $request->value) {
            return redirect()
                ->back()
                ->with('error', 'Não há saldo suficiente');
        }

        DB::beginTransaction();

        $action = $balance->withdraw($request->value);

        if ($action) {

            $action = Auth::user()->transactions()->create([
                'type' => 'T',
                'amount' => $request->value,
                'total_before' => $totalBefore,
                'total_after' => $balance->amount,
                'date' => date('Ymd'),
                'user_id_transaction' => $destinatary->id,
            ]);

            if ($action) {

                $destinataryBalance = $destinatary->balance()->firstOrCreate([]);
                $destinataryTotalBefore = $destinataryBalance->amount ? $destinataryBalance->amount : 0;

                $action = $destinataryBalance->deposit($request->value);

                if ($action) {
                    $action = $destinatary->transactions()->create([
                        'type' => 'I',
                        'amount' => $request->value,
                        'total_before' => $destinataryTotalBefore,
                        'total_after' => $destinataryBalance->amount,
                        'date' => date('Ymd'),
                        'user_id_transaction' => Auth::user()->id,
                    ]);

                    if ($action) {
                        DB::commit();
                        
                        return redirect()
                            ->route('admin.balance')
                            ->with('success', 'Transferência realizada');
                    }
                }
            }
        }

        DB::rollBack();

        return redirect()
            ->back()
            ->with('error', 'Falha ao transferir');
    }

}
