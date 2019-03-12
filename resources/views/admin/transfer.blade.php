@extends('adminlte::page')

@section('title', 'Transferir saldo')

@section('content_header')
    <h1>Transferir</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
        <li><a href="">Transferir</a></li>
    </ol>
@stop

@section('content')
<div class="box">
    <div class="box-header">
        <h3>Transferir saldo</h3>
    </div>
    
    @include('includes.alerts')
    
    <div class="box-body">
        <form method="POST" action="{{ route('transfer.store') }}">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="sender">Informe o recebedor</label>
                <input type="text" class="form-control" name="sender" placeholder="(Nome ou e-mail)">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Próxima etapa</button>
            </div>
        </form>
    </div>
</div>
@stop