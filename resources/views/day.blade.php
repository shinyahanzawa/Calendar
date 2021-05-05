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
                                    <?php $count = strlen($x);
                                    $count < 2  ? $hour = '0'.$x.':00' : $hour = $x . ':00';
                                    $int = mb_strtolower($calendar->getdate()->format("Y-m-d"))." ".$hour;//Y-m-dの日付に00:00を追加
                                    ?>

                                    <td>
                                        <form method="POST" action="/create">
                                            @CSRF
                                            <a href="javascript:void(0)" onclick="this.parentNode.submit()">
                                                <p class="day">{{$hour}}</p>
                                            </a>
                                            @foreach($schedules as $key)
                                            <input type="hidden" name="start_date" value="{{$int}}">

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


                                            @if($start <= $x && $x <=$end) 
                                            <strong>{{$key->title}}</strong><br>
                                            {{$key->schedule}}<br><br>
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