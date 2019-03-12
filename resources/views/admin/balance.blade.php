@extends('adminlte::page')

@section('title', 'Saldo')

@section('content_header')
    <h1>Saldo</h1>

    <ol class="breadcrumb">
        <li><a href="">Dashboard</a></li>
        <li><a href="">Saldo</a></li>
    </ol>
@stop

@section('content')
<div class="box">
    <div class="box-body">
        <a href="{{ route('admin.deposit-balance') }}" class="btn btn-success">
            <i class="fa fa-plus"></i>
            Recarregar
        </a>
        @if ($amount > 0)
        <a href="{{ route('admin.withdraw') }}" class="btn btn-danger">
            <i class="fa fa-minus"></i>
            Sacar
        </a>
        @endif
        @if ($amount > 0)
        <a href="{{ route('admin.transfer') }}" class="btn btn-info">
            <i class="fa fa-exchange"></i>
            Transferir
        </a>
        @endif
    </div>
</div>

@include('includes.alerts')

<div class="small-box bg-green">
    <div class="inner">
        <h3>R$ {{ $amount }}</h3>
    </div>
    <div class="icon">
        <i class="ion ion-stats-bars"></i>
    </div>
    <a href="#" class="small-box-footer">Histórico <i class="fa fa-arrow-circle-right"></i></a>
</div>
@stop