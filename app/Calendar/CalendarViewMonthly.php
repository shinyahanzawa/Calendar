<?php

namespace App\Calendar;

use Carbon\Carbon;
use App\Models\Schedules;

class CalendarViewMonthly
{

	public $carbon;

	function __construct($date)
	{
		$this->carbon = new Carbon($date);
	}

	public function getdate()
	{
		return $this->carbon;
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

	public function getWeeks()
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


	public function schedules()
	{
		return Schedules::all();
	}


}
