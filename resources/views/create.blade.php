@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="/store" method="post">
                @csrf

                <div class="card-body">
                    <h5>Date</h5>
                    <input type="datetime-local" name="date" value="{{ $date }}"><br><br>

                    <h5>Title</h5>
                    <input type="text" name="title" value="{{ $title }}"></input><br><br>

                    <h5>Schedule</h5>
                    <textarea name="schedule" cols="30" rows="10" value="">{{ $schedule }}</textarea><br><br>

                    <input class="btn btn-outline-secondary" type="submit" value="save">
                    <input class="btn btn-outline-secondary" type="submit" value="delete">
                    <br>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection