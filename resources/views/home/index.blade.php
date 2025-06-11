@extends('base')

@section('title', 'Home')

@section('content')
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h1><img src="{{ asset('img/logo.png') }}" alt="Aquatel"></h1>
        </div>
    </div>


    @auth
        <div class="row">
            <div class="col-12 text-center">
                <h2>Bonjour {{ auth()->user()->name }}</h2>
{{--                ul , immeubles, profil, se deconnecter bt5.3 style --}}
                <div class="list-group mt-3 col-3 mx-auto">
                    <a href="{{ route('immeubles.index') }}" class="list-group-item list-group-item-action list-group-item-light">Immeubles</a>
                    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action list-group-item-light">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="list-group-item list-group-item-action list-group-item-light" onclick="event.preventDefault(); this.closest('form').submit();">Se déconnecter</a>
                    </form>
                </div>
{{--                <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>--}}
            </div>
        </div>
        @else



    <div class="col-3 mx-auto bg-light-subtle p-4 rounded-3">

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                   name="email" value="{{ old('email') }}" aria-describedby="emailHelp">
{{--            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>--}}
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                   name="password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">Remember me</label>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    </div>
    @endauth
@endsection
