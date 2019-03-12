@extends('adminlte::page')

@section('title', 'Sacar')

@section('content_header')
    <h1>Fazer retirada</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Depositar</a></li>
    </ol>
@stop

@section('content')
<div class="box">
    <div class="box-header">
        <h3>Fazer retirada</h3>
    </div>
    
    @include('includes.alerts')
    
    <div class="box-body">
        <form method="POST" action="{{ route('withdraw.store') }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <input type="text" class="form-control" name="value" placeholder="Digite um valor">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Retirar</button>
            </div>
        </form>
    </div>
</div>
@stop