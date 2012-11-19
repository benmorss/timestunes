<?php

class Choices {

	const BASS_NOTE_TOO_LOW = 1;
	const BASS_NOTE_TOO_HIGH = 2;

	const UP_OCTAVE = 101;
	const DOWN_OCTAVE = 102;

	const BASS_NOTE_TOO_FAR_WEIGHT = 70;
	const BASS_NOTE_TOO_FAR_WEIGHT_INC = 15;
	const BASS_NOTE_TOO_FAR_ALREADY_SHIFTED_OCTAVE_WEIGHT = 85;

	private $articleInfo;
	
	public function __construct($article_info) {
		$this->articleInfo = $article_info;
		$this->seed();
	}

	private function seed() {
		srand(crc32($this->articleInfo->serialize()));
	}

	/*
	 * expect a weight from 0 to 100 - that's the percentage we're dealing with.
	 * @param int $weight;
	 */

	private function makeChoice($weight) {
		return rand(0, 99) < $weight;
	}

	public function choose($choice) {
		switch ($choice) {
			case self::BASS_NOTE_TOO_HIGH:
			case self::BASS_NOTE_TOO_LOW:

				$diff = func_get_arg(1);
				$octave_shift = func_get_arg(2);
				if (!$diff || $diff < 0)
					$diff = 0;

				$base_weight = ($choice == self::BASS_NOTE_TOO_HIGH && $octave_shift == self::OCTAVE_UP) ||
							   ($choice == self::BASS_NOTE_TOO_LOW && $octave_shift == self::OCTAVE_DOWN) ?
							   self::BASS_NOTE_TOO_FAR_ALREADY_SHIFTED_OCTAVE_WEIGHT : self::BASS_NOTE_TOO_FAR_WEIGHT;

				$weight = $this->incWeight($base_weight, self::BASS_NOTE_TOO_FAR_WEIGHT_INC, $diff);
				return $this->makeChoice($weight);
				break;

			deafult:
				throw new Exception("Unknown choice type '$choice' passed to Choices::choose()");
		}
	}


	/**
	 * Incremental weights are useful if you never want to quite reach an 100% chance.
	 * We do this by repeatedly adding a percentage of the distance to 100% - thus we never quite reach it.
	 * Say we start with 80%, with an increment of 10%.  100%-80% = 20%.  20% * 10% = 2%.
	 * So the next chance would be 82%.  Etc.
	 * 
	 */

	public function incWeight($base, $increment, $iterations) {
		if ($base >= 100)
			return 100;

		for ($i = 0; $i < $iterations; $i++) {
			$add = (100 - $base) * ($increment / 100);
			$base *= $add;
		}

		return $base;
	}

}

?>