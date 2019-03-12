@extends('adminlte::page')

@section('title', 'Histórico')

@section('content_header')
    <h1>Histórico</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Histórico</a></li>
    </ol>
@stop

@section('content')
<div class="box">
    <div class="box-body">
        @include('includes.alerts')
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Valor</td>
                    <td>Tipo</td>
                    <td>Autor</td>
                    <td>Data</td>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>R$ {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                    <td>{{ $transaction->type($transaction->type) }}</td>
                    <td>
                        @if ($transaction->user_id_transaction)
                        {{ $transaction->sender->name }}
                        @else
                        -
                        @endif
                    </td>
                    <td>{{ $transaction->date }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan>Nenhuma transação</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {!! $transactions->links() !!}
</div>


@stop