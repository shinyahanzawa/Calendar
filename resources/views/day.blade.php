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

                                @for ($x = 0; $x <= 24; $x++) 
                                <tr>
                                    <td>
                                        <a href="http://localhost/create">{{$x}}:00</a>

                                        @foreach($calendar->schedules() as $key)
                                        <?php
                                        $num = date('y-m-d', strtotime($key->start_date));
                                        $data = mb_strtolower($calendar->getdate()->format("y-m-d"));
                                        ?>

                                        @if($num == $data)
                                        <br>{{$key->title}}
                                        <br>{{$key->schedule}}
                                        @endif

                                        @endforeach
                                @endfor
                                    </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>


                    <!-- {!! $calendar->render() !!} -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection