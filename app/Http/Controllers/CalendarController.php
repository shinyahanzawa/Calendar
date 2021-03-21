<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Calendar\CalendarViewMonthly;
use App\Calendar\CalendarViewWeekly;

class CalendarController extends Controller
{

   public function monthly(Request $request){

		//クエリーのdateを受け取る
		$date = $request->input("date");

		//dateがYYYY-MMの形式かどうか判定する
		if($date && preg_match("/^[0-9]{4}-[0-9]{2}$/", $date)){
			$date = strtotime($date . "-01");
		}else{
			$date = null;
		}

		//取得出来ない時は現在(=今月)を指定する
		if(!$date)$date = time();

		//カレンダーに渡す
		$calendar = new CalendarViewMonthly($date);
		return view('monthly', [
			"calendar" => $calendar
		]);
	
	}

	public function weekly(Request $request){

		// dd($request);

		$date = $request->input("date");


		// $calendar = new CalendarViewWeekly(time());
		$calendar = new CalendarViewWeekly(time());
	
		// $calendar = $calendar->getWeeks();

		return view('weekly', [
			"calendar" => $calendar
		]);
	}
}