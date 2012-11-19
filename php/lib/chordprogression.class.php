<?php

///TODO: Rework this when you figure out where probabilities should live!

class chordProgression($model) {
	
	private $articleInfo;

	private $measuresCount;

	private $model;

	// an array of the chords in this chord progression
	public $chords;

	public function __construct($chords, $article_info, $measures_count) {
		$this->model = $model;
		$this->articleInfo = $article_info;
		$this->measuresCount = $measures_count;

		if (!$this->model) {
			$this->model = new Model();
		}

		$chords = $this->chords;

/*
		if ($this->chords)
			$chords = $this->chords;
		else
			$this->chords = this->chooseChordProgression();
*/
	}


	/*
	 * For now, just repeat the chord progression until we're out of measures.
	 */

	public function fillIntoScore($score) {
		for ($measure = 0, $chord = 0; $measure < $score->measuresCount; $score++, $chord++) {
			if ($chord > count($chords)) {
				$chord = 0;
			}

			$score->setNow($measure);
			$score->setNowChord($chords[$chord]);
		}

	}
}

?>