@extends('layouts.app')

@section('content')
    <div class="container height-100">
        @guest
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            @if (Route::has('login'))
                                <a class="btn btn-outline-success btn-lg btn-block" href="{{ route('login') }}">
                                    {{ __('Login') }}
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <a class="btn btn-outline-primary btn-lg btn-block" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        @else
            <main-page class="height-95"></main-page>

            <div class="d-flex justify-content-end">
                <form action="{{ route('logout') }}" method="POST">
                    <button class="btn btn-warning" type="submit">
                        {{ __('Logout') }} <b>{{ Auth::user()->name }}</b>
                    </button>
                    @csrf
                </form>
            </div>
        @endguest
    </div>
@endsection
