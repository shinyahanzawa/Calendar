<?php

namespace App\Calendar;

use Carbon\Carbon;
use App\Models\Schedules;

class CalendarViewDay
{

	private $carbon;

	function __construct($date)
	{
		$this->carbon = new Carbon($date);
	}

	public function getdate()
	{
		return $this->carbon;
	}

	/**
	 * 次の週
	 */
	public function getNextDay()
	{
		return $this->carbon->copy()->addDay();
	}
	/**
	 * 前の週
	 */
	public function getPreviousDay()
	{
		return $this->carbon->copy()->subDay();
	}


	/**
	 * タイトル
	 */
	public function getTitle()
	{
		return $this->carbon->format('n月d日');
	}


	public function getWeeks()
	{
		$weeks = [];

		//週初め
		$firstDay = $this->carbon->copy()->startOfWeek();

		//週末まで
		$lastDay = $this->carbon->copy()->endOfWeek();

		//週末までループさせる
		while ($firstDay < $lastDay) {
			//週カレンダーViewを作成する
			$week = new CalendarWeek($firstDay, count($weeks));
			$weeks[] = $week;
			//次の日=+1日する
			$firstDay->addDay(1);
		}
		return $weeks;
	}




	/**
	 * カレンダーを出力します
	 */
	function render()
	{
		$html = [];
		$html[] = '<div class="calendar">';
		$html[] = '<table class="table">';
		$html[] = '<tbody>';
		
		//登録データ取得
		$work = Schedules::all();
		
		for ($x = 0; $x <= 24; $x++) {
			$html[] = '<tr>';
			$html[] = '<td>';
			$html[] = '<a href="http://localhost/create">'.$x .":00".'</a>';


		foreach ($work as $key) {
			$time = strtotime($key->date);
			$num = date('y-m-d', $time);	
			$data = mb_strtolower($this->carbon->format("y-m-d"));
			
				if ($num == $data) { //登録されたデータがあるとき、登録データを表示
					$html[] = '<br>'.$key->title;
					$html[] = '<br>'.$key->schedule;
				}
			}
		}
		
		$html[] = '</td>';
		$html[] = '</tr>';
		$html[] = '</tbody>';
		$html[] = '</table>';
		$html[] = '</div>';
		return implode("", $html);
		}

		public function schedules()
		{
			return Schedules::all();
		}
	
}
