@extends('adminlte::page')

@section('title', 'Confirmar transferência saldo')

@section('content_header')
    <h1>Confirmar transferir</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Transferir</a></li>
        <li><a href="">Confirmação</a></li>
    </ol>
@stop

@section('content')
<div class="box">
    <div class="box-header">
        <h3>Confirmar transferência de saldo</h3>
    </div>
    
    @include('includes.alerts')
    
    <div class="box-body">
        <div class="jumbotron">
            <p><b>Recebedor:</b> {{ $sender->name }}</p>
            <p><b>Saldo atual:</b> R$ {{ number_format($balance->amount, 2, '.', '') }}</p>
        </div>
        
        <form method="POST" action="{{ route('transfer.confirm') }}">
            <input type="hidden" name="sender_id" value="{{ $sender->id }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="sender">Informe o valor:</label>
                <input type="text" class="form-control" name="value" placeholder="R$ 0,00">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Transferir</button>
            </div>
        </form>
    </div>
</div>
@stop