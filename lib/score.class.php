<?php

/*
	Two ways to access the score:
	Random access - get/set a note at a certain place
	In time - get/set a note at the current duration position
*/

class Score {

	const MELODY_TRACK = 1;
	const BASS_TRACK = 2;
	const ACCOMP_TRACK = 3;
	const DRUM_TRACK = 10;
	
	// an array of arrays: score[track][measure][beat][subbeat]  -- say, [16][4][8]
	// alternately: an array of arrays: score[subbeat] -- say, [512]
	// each entry can contain a note, or, in the case of an accompaniment track, an array of notes.
	private $score;

	// an array each entry of which provides the chord underlying a given measure.
	// someday we'll be able to do one chord per beat, but not now.
	public $chords;

	// current position in time in the score
	// properties = measure, beat, subbeat
	public $now;

	public $measuresCount;

	public function __construct($measuresCount, $beatsPerMeasure, $subbeatsPerBeat) {
		$this->now = new Now($measuresCount, $beatsPerMeasure, $subbeatsPerBeat)
	}

	/**
	 * @param int $measure, int $beat, int $subbeat
	 */

	public function setNow($measure, $beat = 0, $subbeat = 0) {
		$now->set($measure, $beat, $subbeat);
	}

	public function getNowNote($track) {
		return $score[$track][$now->measure][$now->beat][$now->subbeat];
	}

	public function putNowNote($note, $track) {
		$score[$track][$now->measure][$now->beat][$now->subbeat] = $note;
		$now->fastForward($note->duration);
	}

	public function getNote($measure, $beatPos, $track) {}

	public function putNote($measure, $beatPos, $track) {}

	/**
	 * Locate the previous note for a given track.  Return the note and its now position.
	 * @param void
	 */
	public function getPrevNote($track) {

	}


	/**
	 * @param int $chord
	 */

	public function setNowChord($chord) {
		$chords[$now->measure] = $chord;
	}


	public function getNowChord() {
		return $chords[$now->measure];
	}

	/**
	 * @param Motif $motif
	 */

	public function setNowMotif($motif, $track) {
		foreach($motif->notes as $note)
			$this->putNowNote($note);
	}


}

?>