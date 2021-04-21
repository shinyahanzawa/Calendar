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

		// $int = 0;
		foreach ($weeks as $week) {
			$html[] = '<tr class="' . $week->getClassName() . '">';
			$days = $week->getDays();

			foreach ($days as $day) {
				$i = 0;
				$html[] = '<td class="' . $day->getClassName() . '">';
				$html[] = '<a href="http://localhost/create">';
				//登録データ取得
				$work = Schedules::all();
				foreach ($work as $key) {
					$time = strtotime($key->date);
					$num = date('y-m-d', $time);
					$data = mb_strtolower($day->carbon->format("y-m-d"));
					
					
					// $html[] = '<form method="post" name="form_1" id="form_1" action="/create">';
					// $html[] = '@csrf';
					// $html[] = '<input type="hidden" name="user_name" value="ユーザー名">';
					// $html[] = '<a href="javascript:form_1.submit()">リンク名</a>';
					// $html[] = '</form>';

					
					if ($num == $data) { //登録されたデータがあるとき、登録データを表示
						// $data = mb_strtolower($day->carbon->format("d"));
						// $num = strtotime($key->date);
						// $num = date('d', $time);
						// $html[] = '<form method="post" name="form1" action="/create">';
						// $html[] = '@csrf';
						// $int++;
						// $html[] = '<a href="javascript:form'.$int.'.submit()">' .date('d', $time). '</a>';
						
						// $html[] = '<inputs type="hidden" name="date" value='.date('d', $time).'>';
						$html[] = '<a href="javascript:form1.submit()">' .date('d', $time). '</a>';
						$html[] = '<br>';
						$html[] = '<a href="javascript:form1.submit()">' . $key->title . '</a>';

						// $html[] = '</form>';
						
						$i = 1;
					}
				}
				// $str[] = date('d', $time);
				
				if ($i != 1) { //登録されたデータがない時、カレンダーを表示
					$data = mb_strtolower($day->carbon->format("d"));
					$html[] = '<p class="day">' . $data . '</p>';
					// $da[] ="";
 					// $da[] = $data;
					// dd($da);
					// $html[] = '<input type="hidden" name="date" value='.$data.'>';
					// $html[] = '<a href="javascript:form1.submit()">' . $data . '</a>';
				}
				// $html[] = '</form>';
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
	
	// function post(){
		
		
		// 	$html[] = '<form method="post" name="form_1" id="form_1" action="/create">">';
		// 	$html[] = '{{!! csrf_field() !!}}';
		// 	$html[] = '<input type="hidden" name="user_name" value="ユーザー名">';
		// 	$html[] = '<a href="javascript:form_1.submit()">リンク名</a>';
		// 	$html[] = '</form>';
		
		// 	$html = [];
		// 	$html[] = '<form method="post" name="form_1" id="form_1" action="/create">';
		// 	$html[] = '@csrf';
		// 	$html[] = '<input type="hidden" name="user_name" placeholder="ユーザー名">';
		// 	$html[] = '<a href="javascript:form_1.submit()">リンク名</a>';
		// 	$html[] = '</form>';
	// 	return implode("", $html);
	
	
	// }
	
	
}
