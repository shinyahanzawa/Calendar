@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <a class="btn btn-outline-secondary float-left" href="{{ url('day/?date=' . $calendar->getPreviousDay()) }}">前日</a>

                    <span>{{ $calendar->getTitle() }}</span>

                    <a class="btn btn-outline-secondary float-right" href="{{ url('day/?date=' . $calendar->getNextDay()) }}">翌日</a>
                </div>
                <div class="card-body">
                    <div class="calendar">
                        <table class="table">
                            <tbody>

                                @for ($x = 0; $x <= 24; $x++) <tr>
                                    <?php $hour = $x.':00';?>
                                    <td>
                                        <form method="POST" action="/create">
                                            @CSRF
                                            <input type="hidden" name="start_date" value="{{$calendar->getdate()->format("Y-m-d")}}">
                                            <a href="javascript:void(0)" onclick="this.parentNode.submit()">
                                                <p class="day">{{$hour}}</p>
                                            </a>
                                                @foreach($calendar->schedules() as $key)
                                                <?php
                                                $num = date('Y-m-d', strtotime($key->start_date));
                                                $data = mb_strtolower($calendar->getdate()->format("Y-m-d"));
                                                ?>

                                                @if($num == $data)
                                                <?php 
                                                $start = date('H', strtotime($key->start_date));
                                                $end = date('H', strtotime($key->end_date));
                                                $end = str_replace("00", "24", $end);
                                                ?>
                                                    @if($start <= $x && $x <= $end)
                                                    <p>{{$key->title}}</p>
                                                    <p>{{$key->schedule}}</p>
                                                    @endif                                                
                                                @endif

                                                @endforeach
                                        </form>
                                        @endfor
                                    </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection