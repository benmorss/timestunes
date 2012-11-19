<?php

///TODO: probably create a superclass for both of these

class Note {
	
	// the pitch of the note - class Pitch
	public $pitch;

	// the duration of the note - class Duration
	public $duration;

	public function __construct($pitch, $duration) {
		$this->pitch = $pitch;
		$this->duration = $duration;
	}

	public function __toString() {
		echo "$pitch $duration";
	}

	/*
	 * transpose a note by transposing its pitch and keeping duration constant.
	 * this returns a new note object.
	 * @param int $interval
	 */

	public function transpose($interval) {
		$transposed_pitch = Pitch::addPitches($this->pitch, $interval);
		return new Note($transposed_pitch, $this->duration);
	}
}


// A class that allows you to create chords -- a duration with more than one pitch attached.

class Cluster {

	// an array of pitches
	public $pitches;

	public $duration;

	public function __construct($pitches, $duration) {
		$this->pitches = $pitches;
		$this->duration = $duration;
	}

	public function __toString() {
		echo '{' . implode(' ', $pitches) . '} '. $duration; 
	}

	public function transpose($interval) {
		foreach ($this->pitches as $pitch) {
			$transposed_pitch = Pitch::addPitches($this->pitch, $interval);
			$notes[] = new Note($transposed_pitch, $this->duration);
		}

		return $notes;
	}
}

?>