<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar\CalendarViewMonthly;
use App\Calendar\CalendarViewWeekly;
use App\Calendar\CalendarViewDay;
use App\Models\Schedules;

use Auth;



class CalendarController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}


	public function monthly(Request $request)
	{

		//クエリーのdateを受け取る
		$date = $request->input("date");

		//dateがYYYY-MMの形式かどうか判定する
		if ($date && preg_match("/^[0-9]{4}-[0-9]{2}$/", $date)) {
			$date = strtotime($date . "-01");
		} else {
			$date = null;
		}
		//取得出来ない時は現在(=今月)を指定する
		if (!$date) $date = time();
		//カレンダーに渡す
		$calendar = new CalendarViewMonthly($date);

		return view('monthly', [
			"calendar" => $calendar
		]);
	}

	public function weekly(Request $request)
	{

		$date = $request->input("date");

		//取得出来ない時は現在(=今月)を指定する
		$date = strtotime($date);
		if (!$date) $date = time();

		$calendar = new CalendarViewWeekly($date);

		return view('weekly', [
			"calendar" => $calendar
		]);
	}

	public function day(Request $request)
	{

		$date = $request->input("date");

		//取得出来ない時は現在(=今月)を指定する
		$date = strtotime($date);
		if (!$date) $date = time();

		$calendar = new CalendarViewDay($date);

		return view('day', [
			"calendar" => $calendar
		]);
	}

	public function create(Request $request)
	{

		$schedules = Schedules::all();

		$x = 0;
		foreach ($schedules as $key) {
			$int = $request->start_date;
			$num = date('Y-m-d', strtotime($key->start_date));
			
			if ($num == $int && $x == 0) { //登録データが存在してるとき
				$start_date  = preg_replace("/( |　)/", "T", $key->start_date);
				$end_date  = preg_replace("/( |　)/", "T", $key->end_date);
				$title = $key->title;
				$schedule = $key->schedule;
				$x = 1;
			} elseif ($x != 1) {//データがない時、画面の日付を取得
				$start_date  = $int . "T00:00";
				$end_date  = $int . "T00:00";
				$title = "";
				$schedule = "";
			} 
		}
		return view('create', compact('start_date','end_date','title','schedule'));
	}


	public function store(Request $request)
	{

		date_default_timezone_set('Asia/Tokyo');

		$user = Auth::user();

		$schedules = Schedules::all();

		$x = 0;
		foreach ($schedules as $key) {
			$int  = strstr($request->start_date, 'T', true);//画面から送信されたデータ-1
			$time  = strstr($key->start_date, ' ', true);//scheduleテーブルデータ-2

			if ($time == $int) { //1と2が一致してるかy-m-dで確認
				$id = $key->id;
				$x = 1;
			} elseif ($time != $int && $x == 0) {
				$id = "";
			}
		}


		if ($id) { //id確認
			$items = schedules::where('id', $id)->get();
			foreach ($items as $item) {
				$item->start_date = $request->input('start_date');
				$item->end_date = $request->input('end_date');				
				$item->title = $request->input('title');
				$item->schedule = $request->input('schedule');
				$item->save();
			
			}

		} else {
			$str = new Schedules();
			$str->user_id = $user->id;
			$str->start_date = $request->input('start_date');
			$str->end_date = $request->input('end_date');				
			$str->title = $request->input('title');
			$str->schedule = $request->input('schedule');
			$str->save();

		}

		return redirect('create');
	}

	public function delete(Request $request)
	{
		$schedules = Schedules::all();

		foreach ($schedules as $key) {
			$int  = strstr($request->start_date, 'T', true);//画面から送信されたデータ-1
			$time  = strstr($key->start_date, ' ', true);//scheduleテーブルデータ-2

			if ($time == $int) { //1と2が一致してるかy-m-dで確認
				schedules::where('id', $key->id)->delete();
			}
		}

		return redirect('create');
	}


	
}
