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

                <div class="calendar">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Man</th>
                                <th>Tue</th>
                                <th>Web</th>
                                <th>Tur</th>
                                <th>Fri</th>
                                <th>Sat</th>
                                <th>Sun</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($calendar->getWeeks() as $week)
                            <tr class={{$week->getClassName()}}>
                                <?php $days = $week->getDays(); ?>

                                @foreach ($days as $day)
                                <td class='{{$day->getClassName()}}'>
                                    <?php
                                    $check = mb_strtolower($day->carbon->format("y-m"));
                                    $now = $calendar->getdate()->format("y-m");
                                    ?>

                                    @if($check == $now)
                                    <form method="POST" action="/create">
                                        @CSRF
                                        <input type="hidden" name="start_date" value="{{$day->carbon->format("Y-m-d")}}">

                                        <a href="javascript:void(0)" onclick="this.parentNode.submit()">
                                            <p class="day">{{$day->carbon->format("d")}}</p>


                                            @foreach($calendar->schedules() as $key)
                                            <?php
                                            $start = date('Y-m-d', strtotime($key->start_date));                                          
                                            $data = mb_strtolower($day->carbon->format("Y-m-d"));
                                            ?>

                                            @if($start == $data)
                                            <p>{{$key->title}}</p>
                                            @endif

                                            @endforeach

                                        </a>
                                    </form>
                                    @endif
                                    @endforeach

                                    @endforeach
                        </tbody>
                    </table>
                </div>
                @endguest
            </div>
        </div>
    </div>
</div>

@endsection