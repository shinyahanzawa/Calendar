@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @guest
                        {{ __('Login not completed') }}
                    @else
                        {{ __('Login completed!') }}
                       <br><a href="/monthly">-Monthly-</a>
                       <br><a href="/weekly">-Weekly-</a>
                    @endguest

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
