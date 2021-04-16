<?php

namespace App\Calendar;

use Carbon\Carbon;
use App\Models\Schedules;

class CalendarViewMonthly
{

	private $carbon;

	function __construct($date)
	{
		$this->carbon = new Carbon($date);
	}

	/**
	 * 次の月
	 */
	public function getNextMonth()
	{
		return $this->carbon->copy()->addMonthsNoOverflow()->format('Y-m');
	}
	/**
	 * 前の月
	 */
	public function getPreviousMonth()
	{
		return $this->carbon->copy()->subMonthsNoOverflow()->format('Y-m');
	}

	/**
	 * タイトル
	 */
	public function getTitle()
	{
		return $this->carbon->format('Y年n月');
	}

	protected function getWeeks()
	{
		$weeks = [];

		//初日
		$firstDay = $this->carbon->copy()->firstOfMonth();

		//月末まで
		$lastDay = $this->carbon->copy()->lastOfMonth();

		//1週目
		$week = new CalendarWeek($firstDay->copy());

		$weeks[] = $week;

		//作業用の日
		$tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();

		//月末までループさせる
		while ($tmpDay->lte($lastDay)) {
			//週カレンダーViewを作成する
			$week = new CalendarWeek($tmpDay, count($weeks));
			$weeks[] = $week;

			//次の週=+7日する
			$tmpDay->addDay(7);
		}
		return $weeks;
	}

	/**
	 * カレンダーを出力する
	 */
	function render()
	{
		$html = [];
		$html[] = '<div class="calendar">';
		$html[] = '<table class="table">';
		$html[] = '<thead>';
		$html[] = '<tr>';
		$html[] = '<th>Man</th>';
		$html[] = '<th>Tue</th>';
		$html[] = '<th>Web</th>';
		$html[] = '<th>Tur</th>';
		$html[] = '<th>Fri</th>';
		$html[] = '<th>Sat</th>';
		$html[] = '<th>Sun</th>';
		$html[] = '</tr>';
		$html[] = '</thead>';

		$html[] = '<tbody>';

		$weeks = $this->getWeeks();
		foreach ($weeks as $week) {
			$html[] = '<tr class="' . $week->getClassName() . '">';
			$days = $week->getDays();

			foreach ($days as $day) {
				$i = 0;


				$html[] = '<td class="' . $day->getClassName() . '">';
				$html[] = '<a href="http://localhost/create">';

				//データ取得
				$work = Schedules::all();
				foreach ($work as $key) {
					$num = strtotime($key->date);
					$num = date('y-m-d', $num);
					$data = mb_strtolower($day->carbon->format("y-m-d"));
					
					if ($num == $data) {//登録されたデータがあるとき、登録データを表示
						$html[] = '<p class="day">' . $key->title . '</p>';
						$i = 1;
					}
				}
				if ($i != 1) {//登録されたデータがない時、カレンダーを表示
					$data = mb_strtolower($day->carbon->format("d"));
					$html[] = '<p class="day">' . $data . '</p>';
				}

				$html[] = '</a>';
				$html[] = '</td>';
			}
		}
		$html[] = '</tr>';

		$html[] = '</tbody>';

		$html[] = '</table>';
		$html[] = '</div>';
		return implode("", $html);
	}
}
