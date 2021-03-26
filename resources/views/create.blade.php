@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-body">
                <form action="/store" method="post">
                    @csrf

                    <label>date<br>
                        <input type="date" name="date">
                    </label>
                    <br><br>

                    <div>
                        <input type="radio" id="job" name="choice" value="job">
                        <label for="job">job</label>
                    </div>

                    <div>
                        <input type="radio" id="school" name="choice" value="school">
                        <label for="school">school</label>
                    </div>

                    <div>
                        <input type="radio" id="holiday" name="choice" value="holiday">
                        <label for="holiday">holiday</label>
                    </div>

                    <div>
                        <input type="radio" id="etc" name="choice" value="etc" checked>
                        <label for="etc">etc</label>
                    </div>

                    <label>title<br>
                    <input type="text" name="title"></input>
                    </label>
                    <br>

                    <label>schedule<br>
                    <textarea name="comment" cols="30" rows="5"></textarea>
                    </label>
                    <br>

                    <label>people<br>
                    <input type="number" style="width:50px;" min="1" max="100" value=""></input>
                    </label>
                    <br>

                    <label>address<br>
                    <input type="text" name="address"></input>
                    </label>
                    <br><br>

                    <input type="submit" value="save">
            </div>
            </form>
        </div>
    </div>
</div>
@endsection