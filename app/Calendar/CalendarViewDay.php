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
	public function getNextDay(){
		return $this->carbon->copy()->addDay();
	}
	/**
	 * 前の週
	 */
	public function getPreviousDay(){
		return $this->carbon->copy()->subDay();
	}


	/**
	 * タイトル
	 */
	public function getTitle(){
		return $this->carbon->format('n月d日');
	}



	/**
	 * カレンダーを出力します
	 */
	function render(){
		$html = [];
		$html[] = '<div class="calendar">';
		$html[] = '<table class="table">';
		$html[] = '<tbody>';						
		
		for($x=0;$x <= 24;$x++){
				$html[] = '<tr>';
				$html[] = '<td>';
				$html[] = '<p >' . $x.":00" . '</p>';
				$html[] = '</td>';
				$html[] = '</tr>';
		}
			
		$html[] = '</tr>';
		$html[] = '</tbody>';
		$html[] = '</table>';
		$html[] = '</div>';
		return implode("", $html);
		
	}
}
