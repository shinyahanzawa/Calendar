<?php

namespace App\Calendar;

use Carbon\Carbon;
use App\Models\Schedules;

class CalendarViewWeekly
{

	private $carbon;

	function __construct($date)
	{
		$this->carbon = new Carbon($date);
	}


	/**
	 * 次の週
	 */
	public function getNextWeek()
	{
		return $this->carbon->copy()->addWeek();
	}
	/**
	 * 前の週
	 */
	public function getPreviousWeek()
	{
		return $this->carbon->copy()->subWeek();
	}


	/**
	 * タイトル
	 */
	public function getTitle()
	{
		return $this->carbon->format('Y年n月');
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

		$weeks = $this->getWeeks();
		foreach ($weeks as $day) {
			$html[] = '<tr>';

			//登録データ取得
			$work = Schedules::all();

			$html[] = '<td class="day-' . mb_strtolower($day->carbon->format("D")) . '">';
			$html[] = '<a href="http://localhost/create">';

			//月日
			$html[] = '<p class="day">' . mb_strtolower($day->carbon->format("m-d")) . '</p>';
			$html[] = '</a>';

			//曜日
			// $html[] = '<p class="day">' . mb_strtolower($day->carbon->format("D")).'</p>';

			foreach ($work as $key) {
				$time = strtotime($key->date);
				$num = date('y-m-d', $time);
				$data = mb_strtolower($day->carbon->format("y-m-d"));

				if ($num == $data) { //登録されたデータがあるとき、登録データを表示
					$html[] = $key->title;
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
}
