@extends('adminlte::page')

@section('title', 'Meu perfil')

@section('content_header')
<h1>Meu perfil</h1>

<ol class="breadcrumb">
    <li><a href="">Dashboard</a></li>
    <li><a href="">Perfil</a></li>
</ol>
@stop

@section('content')
@include('includes.alerts')

<form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">

    <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    @if (auth()->user()->image != null)
                    <img class="img-responsive" src="{{url('storage/users/'.auth()->user()->image)}}" alt="">
                    @else
                    <img class="img-responsive" src="{{url('images/placeholder-user.png')}}" alt="">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" name="name" placeholder="Nome" class="form-control"
                            value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" placeholder="E-mail" class="form-control"
                            value="{{ auth()->user()->email }}">
                    </div>
                    <div class="form-group">
                        <label for="Senha">Senha</label>
                        <input type="password" name="password" placeholder="Senha" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="image">Imagem</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary">Atualizar perfil</button>
                </div>
            </div>
        </div>
</form>
@endsection