@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="post">
                @csrf

                <div class="card-body">
                    <h6>Date</h6>
                    <input type="datetime-local" name="date" value="{{ $date }}"><br><br>

                    <h6>Title</h6>
                    <input type="text" name="title" value="{{ $title }}"></input><br><br>

                    <h6>Schedule</h6>
                    <textarea name="schedule" cols="30" rows="10" value="">{{ $schedule }}</textarea><br><br>

                    <input class="btn btn-outline-secondary" type="submit" formaction="/store" value="save">
                    <input class="btn btn-outline-secondary" type="submit" formaction="/delete" value="delete">
                    <br>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection