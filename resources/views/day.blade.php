@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
                <div class="card-header text-center">
                    <a class="btn btn-outline-secondary float-left" href="{{ url('weekly/?date=' . $calendar->getPreviousWeek()) }}">前の週</a>

                    <span>{{ $calendar->getTitle() }}</span>

                    <a class="btn btn-outline-secondary float-right" href="{{ url('weekly/?date=' . $calendar->getNextWeek()) }}">次の週</a>
                </div>
                <div class="card-body">
                    {!! $calendar->render() !!}
                </div>
           </div>
       </div>
   </div>
</div>
@endsection