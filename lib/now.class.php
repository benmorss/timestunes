<?php

class Now {

	// constants to indicate that we're past the end or before the start off the score
	const BEFORE_START;
	const PAST_END;

	// these all are counted from 0
	public $measure;
	public $beat;
	public $subbeat;
	public $tick;

	public $maxTicks;

	// maintain this as the total number of subbeats you'd need to get to Now
	private $totalSubbeats;
	private $subbeatsPerBeat;
	private $beatsPerMeasure;

	public function __construct($measuresCount, $beatsPerMeasure, $subbeatsPerBeat) {
		$this->subbeatsPerBeat = $subbeatsPerBeat;
		$this->beatsPerMeasure = $beatsPerMeasure;
		$this->totalSubbeats = 0;

		$this->maxTotalSubbeats = $measuresCount * $beatsPerMeasure * $subbeatsPerBeat;
		$this->measure = $this->beat = $this->subbeat = 1;
	}

	/**
	 * @param int $measure, int $beat, int $subbeat
	 */

	public function set($measure, $beat = 0, $subbeat = 0) {
		$this->measure = $measure;
		$this->beat = $beat;
		$this->subbeat = $subbeat;
	}

	// duration is measured in the same units as subbeats.
	public function fastForward($duration) {
		///todo: error-checking!

		if ($duration < 0)
			throw error;

		$new_duration = $this->tick + $duration;
		if ($new_duration > $maxTicks)
			throw error;

		$this->tick = $new_duration;
		$this->measure = floor($this->tick / ($beatsPerMeasure * $subbeatsPerBeat));
		

/*
		$newTotalSubbeats = $totalSubbeats + $duration;
		if ($newTotalSubbeats > $maxTotalSubbeats || $newTotalSubbeats < 0)
			return false;

		$this->totalSubbeats = $newTotalSubbeats;
		$measuresFloat = $newTotalSubbeats / $subbeatsPerBeat;
		$this->measure = intval($measuresFloat) + 1;

		$beatsFloat = ($measuresFloat - $this->measure) * $subbeatsPerBeat;
		$this->beat = intval($beatsFloat) + 1;

		$subbeats = ..... ;
*/
	}

}


?>