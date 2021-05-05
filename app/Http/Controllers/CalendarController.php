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
		$schedules = Schedules::all();

		return view('day', [
			"calendar" => $calendar,
			"schedules" => $schedules
		]);
	}

	public function create(Request $request)
	{

		$request->start_date = preg_replace("/(T)/", " ", $request->start_date);

		$schedules = Schedules::all();

		$x = 0;
		foreach ($schedules as $key) {
			$int = date('Y-m-d', strtotime($request->start_date)); //画面データ　開始時刻　取得
			$date = date('Y-m-d', strtotime($key->start_date)); //schedule table　開始時刻　取得

			if ($date == $int) { //登録データが存在してるとき
				$start = date('H', strtotime($key->start_date)); //schedule table　開始時刻　取得
				$end = date('H', strtotime($key->end_date)); //schedule table　終了時刻　取得

				$request_date = date('H', strtotime($request->start_date)); //画面データ　開始時刻　取得

				if ($start <= $request_date && $request_date <= $end  && $x == 0) { //時刻で条件分岐
					$id = $key->id;
					$start_date  = preg_replace("/( |　)/", "T", $key->start_date);
					$end_date  = preg_replace("/( |　)/", "T", $key->end_date);
					$title = $key->title;
					$schedule = $key->schedule;
					$x = 1;
				}
			}
			if (empty($id)) {
				$id = "";
				$start_date  = preg_replace("/( |　)/", "T", $request->start_date);
				$end_date  = preg_replace("/( |　)/", "T", $request->start_date);
				$title = "";
				$schedule = "";
			}
		}
		return view('create', compact('id', 'start_date', 'end_date', 'title', 'schedule'));
	}


	public function store(Request $request)
	{

		date_default_timezone_set('Asia/Tokyo');

		$user = Auth::user();

		$schedules = Schedules::all();

		$x = 0;
		foreach ($schedules as $key) {
			if ($key->id == $request->id) { //request,IDとschedule,IDが一致していたときの処理
				$id = $key->id;
				$x = 1;
			} elseif ($key->id != $request->id && $x == 0) { ////request,IDとschedule,IDが一致しないときの処理
				$id = "";
			}
		}

		if ($id) { //schedule tableにデータがあれば更新
			$items = schedules::where('id', $id)->get();
			foreach ($items as $item) {
				$item->start_date = $request->input('start_date');
				$item->end_date = $request->input('end_date');
				$item->title = $request->input('title');
				$item->schedule = $request->input('schedule');
				$item->save();
			}
		} else { //schedule tableにデータがない時は新規登録
			$str = new Schedules();
			$str->user_id = $user->id;
			$str->start_date = $request->input('start_date');
			$str->end_date = $request->input('end_date');
			$str->title = $request->input('title');
			$str->schedule = $request->input('schedule');
			$str->save();
		}
		return redirect('home')->with('flash_message', 'success');
	}

	public function delete(Request $request)
	{
		$schedules = Schedules::all();

		foreach ($schedules as $key) {
			if ($key->id == $request->id) { //request,IDとschedule,IDが一致していたときの処理
				schedules::where('id', $key->id)->delete();
			}
		}

		return redirect('home')->with('flash_message', 'success');
	}
}
