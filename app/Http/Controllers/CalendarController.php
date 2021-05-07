<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Calendar\CalendarViewMonthly;
use App\Calendar\CalendarViewWeekly;
use App\Calendar\CalendarViewDay;
use App\Models\Schedules;

use DateTime;

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
		//取得出来ない時は現在(=今月)を指定
		if (!$date) {
			date_default_timezone_set('Asia/Tokyo');
			$date = new DateTime();
			$date->format("Y-m-d");
		}
		//カレンダーに渡す
		$calendar = new CalendarViewMonthly($date);

		return view('monthly', [
			"calendar" => $calendar
		]);
	}

	public function weekly(Request $request)
	{

		$date = $request->input("date");

		//取得出来ない時は現在(=今月)を指定
		if (!$date) {
			date_default_timezone_set('Asia/Tokyo');
			$date = new DateTime();
			$date->format("Y-m-d");
		}

		$calendar = new CalendarViewWeekly($date);

		return view('weekly', [
			"calendar" => $calendar
		]);
	}

	public function day(Request $request)
	{

		$date = $request->input("date");

		//取得出来ない時は現在(今月)を指定
		if (!$date) {
			date_default_timezone_set('Asia/Tokyo');
			$date = new DateTime();
			$date->format("Y-m-d");
		}

		$calendar = new CalendarViewDay($date);
		$schedules = Schedules::all();

		return view('day', [
			"calendar" => $calendar,
			"schedules" => $schedules
		]);
	}

	public function create(Request $request)
	{
		$schedules = Schedules::all();

		$x = 0;
		foreach ($schedules as $key) {
			
			//monthly
			if (!empty($request->monthly)) {
				$int = date('Y-m-d', strtotime($request->monthly)); //画面データ　開始"日"　取得
				$date = date('Y-m-d', strtotime($key->start_date)); //schedule table　開始"日"　取得
				if ($date == $int && $x == 0) {
					$id = $key->id;
					$start_date  = preg_replace("/( |　)/", "T", $key->start_date);
					$end_date  = preg_replace("/( |　)/", "T", $key->end_date);
					$title = $key->title;
					$schedule = $key->schedule;
					$x = 1;
				}
			}

			//weekly
			if (!empty($request->weekly)) {
				$int = date('Y-m-d', strtotime($request->weekly)); //画面データ　開始"日"　取得
				$date = date('Y-m-d', strtotime($key->start_date)); //schedule table　開始"日"　取得
				if ($date == $int && $x == 0) {
					$id = $key->id;
					$start_date  = preg_replace("/( |　)/", "T", $key->start_date);
					$end_date  = preg_replace("/( |　)/", "T", $key->end_date);
					$title = $key->title;
					$schedule = $key->schedule;
					$x = 1;
				}
			}

			//day
			if (!empty($request->day)) {
				$int = date('Y-m-d', strtotime($request->day)); //画面データ　開始"日"　取得
				$date = date('Y-m-d', strtotime($key->start_date)); //schedule table　開始"日"　取得
				$start = date('H', strtotime($key->start_date)); //schedule table　開始"時"　取得
				$end = date('H', strtotime($key->end_date)); //schedule table　終了"時"　取得
				$request_date = date('H', strtotime($request->day)); //画面データ　開始時刻　取得

				if ($date == $int && $start <= $request_date && $request_date <= $end  && $x == 0) { //登録データが存在してるとき
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
				$start_date  = str_replace("/", "T", $request->date);
				$end_date  = str_replace("/", "T", $request->date);
				$title = "";
				$schedule = "";
			}
		}

		return view('create', compact(
			'id',
			'start_date',
			'end_date',
			'title',
			'schedule',
		));
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
