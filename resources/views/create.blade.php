@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-body">
                <form action="/store" method="post">
                    @csrf

                    <label>date<br>
                        <input type="date" name="date" value="{{ old('date') }}">
                    </label>
                    <br><br>

                    <div>
                        <input type="radio" id="job" name="choice" value="{{ old('choice','job') == 'job' ? 'job' : ''}}">
                        <label for="job">job</label>
                    </div>
                    <div>
                        <input type="radio" id="school" name="choice" value="{{ old('choice','school') == 'school' ? 'school' : ''}}">
                        <label for="school">school</label>
                    </div>
                    <div>
                        <input type="radio" id="holiday" name="choice" value="{{ old('choice','holiday') == 'holiday' ? 'holiday' : ''}}">
                        <label for="holiday">holiday</label>
                    </div>
                    <div>
                        <input type="radio" id="etc" name="choice" value="{{ old('choice','etc') == 'etc' ? 'etc' : ''}}">
                        <label for="etc">etc</label>
                    </div>
                    <br>

                    <label>title<br>
                    <input type="text" name="title" value="{{ old('title') }}"></input>
                    </label>
                    <br>

                    <label>schedule<br>
                    <textarea name="comment" cols="30" rows="5" value="{{ old('comment') }}"></textarea>
                    </label>
                    <br>

                    <label>people<br>
                    <input type="number" name="people" style="width:50px;" min="1" max="100" value="{{ old('people') }}"></input>
                    </label>
                    <br>

                    <label>address<br>
                    <input type="text" name="address" value="{{ old('address') }}"></input>
                    </label>
                    <br><br>

                    <input type="submit" value="save">
            </div>
            </form>
        </div>
    </div>
</div>
@endsection