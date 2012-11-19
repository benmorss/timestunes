<?php

class Duration {

	public $ticks;

	private $map4 = ['1' => 's', '2' => 'e', '3' => 'de', 4 =>'q', '6' => 'dq', '8' => 'h', '12' => 'dh', '16' => 'w'];

	public function __construct ($ticks) {
		$this->ticks = $ticks;
	}

	public function __toString() {
		global $subbeatsPerBeat;

		if ($subbeatsPerBeat == 4) {
			$letter = $map4[$this->ticks];
			if (!$letter)
				$letter = '?';
		} else {
			$letter = '?';
		}

		echo $letter;
	}

	public function minMeasures() {
		global $subbeatsPerBeat;
		global $beatsPerMeasure;

		return ceil($this->ticks / ($subbeatsPerBeat * $beatsPerMeasure));
	}
}

?>