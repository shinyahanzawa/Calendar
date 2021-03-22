<?php
namespace App\Calendar;

use Carbon\Carbon;

class CalendarViewDay {

	private $carbon;

	function __construct($date){
		$this->carbon = new Carbon($date);
	}


	/**
	 * 次の週
	 */
	public function getNextWeek(){
		return $this->carbon->copy()->addWeek();
	}
	/**
	 * 前の週
	 */
	public function getPreviousWeek(){
		return $this->carbon->copy()->subWeek();
	}


	/**
	 * タイトル
	 */
	public function getTitle(){
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
		while ($firstDay<$lastDay) {
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
	function render(){
		$html = [];
		$html[] = '<div class="calendar">';
		$html[] = '<table class="table">';
		$html[] = '<tbody>';				
		
		$weeks = $this->getWeeks();
		foreach ($weeks as $day) {
			$data = $day->carbon->format("D");
			$html[] = '<tr>';
			$html[] = '<td class="day-' . mb_strtolower($day->carbon->format("D")) . '">';
			$html[] = '<p >' . $data . '</p>';
			$html[] = '<p class="day">' . $day->carbon->format("n-j"). '</p>';
			$html[] = '</td>';
			$html[] = '</tr>';
		}

		$html[] = '</tbody>';
		$html[] = '</table>';
		$html[] = '</div>';
		return implode("", $html);
		
	}
}
