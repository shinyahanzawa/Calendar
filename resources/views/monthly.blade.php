@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @guest
                <div class="card-body">
                    {{ __('Login not completed') }}
                </div>
                @else
                <div class="card-header text-center">
                    <a class="btn btn-outline-secondary float-left" href="{{ url('monthly/?date=' . $calendar->getPreviousMonth()) }}">先月</a>

                    <span>{{ $calendar->getTitle() }}</span>

                    <a class="btn btn-outline-secondary float-right" href="{{ url('monthly/?date=' . $calendar->getNextMonth()) }}">翌月</a>
                </div>
                </div>
                <div class="card-body">
                    {!! $calendar->render() !!}
                </div>
            @endguest
        </div>
    </div>
</div>
</div>
@endsection