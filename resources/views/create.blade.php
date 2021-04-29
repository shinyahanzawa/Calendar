@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-body">
                <form action="/store" method="post">
                    @csrf

                    <label>date<br>
                        <input type="date" name="date" value="{{ $calendar }}">
                    </label>
                    <br><br>

                    <div>
                        <input type="radio" id="job" name="schedule_flag" value="{{ old('schedule_flag','0') == '0' ? '0' : ''}}">
                        <label for="job">job</label>
                    </div>
                    <div>
                        <input type="radio" id="school" name="schedule_flag" value="{{ old('schedule_flag','1') == '1' ? '1' : ''}}">
                        <label for="school">school</label>
                    </div>
                    <div>
                        <input type="radio" id="holiday" name="schedule_flag" value="{{ old('schedule_flag','2') == '2' ? '2' : ''}}">
                        <label for="holiday">holiday</label>
                    </div>
                    <div>
                        <input type="radio" id="etc" name="schedule_flag" value="{{ old('schedule_flag','3') == '3' ? '3' : ''}}">
                        <label for="etc">etc</label>
                    </div>
                    <br>

                    <label>title<br>
                        <input type="text" name="title" value="{{ old('title') }}"></input>
                    </label>
                    <br>

                    <label>schedule<br>
                        <textarea name="schedule" cols="30" rows="5" value="{{ old('schedule') }}"></textarea>
                    </label>
                    <br>

                    <label>person<br>
                        <input type="text" name="person" value="{{ old('person') }}"></input>
                    </label>
                    <br>

                    <label>address<br>
                        <input type="text" name="address" value="{{ old('address') }}"></input>
                    </label>
                    <br><br>
                    <input type="submit" value="save">
                    <input type="submit" value="delete">
            </div>
            </form>
        </div>
    </div>
</div>
@endsection