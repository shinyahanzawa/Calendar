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
                        <p>{{ __('Login not completed') }}</p>
                    @else
                        <p>{{ __('Login completed!') }}</p>
                       <a href="/monthly" class="btn btn-outline-secondary">Monthly</a>
                       <a href="/weekly" class="btn btn-outline-secondary">Weekly</a>
                       <a href="/day" class="btn btn-outline-secondary">Day</a>
                    @endguest

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
