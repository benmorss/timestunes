<?php

class Motif {
	
	// an array of the notes in the motif
	public $notes;

	// the chord the motif fits over.  I think we'll need this... perhaps
	public $chord;

	// the total duration of the motif
	public $duration;

	// minimum whole number of measures the motif would fit into
	public $measures;

	public function __construct($model, $notes, $chord = null) {
		if (!$notes)
			throw new Exception("Motif constructor must be passed some notes");

		$this->model = $model;
		$this->notes = $notes;
		$this->chord = $chord ? $chord : new Chord('C');

		foreach ($notes as $note)
			$duration += $note->duration;

		$this->duration = $duration;
		$this->measures = $duration->minMeasures();

/*		if ($notes)
			$this->notes = $notes;
		else
			$notes = choose_motif();
*/
	}

	public function __toString() {
		foreach ($this->notes as $note)
			echo "$note ";
	}

	/*
	 * return a new Motif consisting of this Motif's notes tranposed.
	 * @param int $interval
	 */

	public function transpose($interval) {
		foreach ($this->notes as $note)
			$notes_transposed[] = $note->transpose($interval);
		return new Motif($notes_transposed);
	}

	/*
	 * transpose our motif to a new chord.  Chord::fit_pitch() does the heavy lifting.
	 *
	 * @param Chord $new_chord
	 */

	public function transposeToChord($new_chord) {
		$interval = Pitch::smallestInterval($new_chord->rootPitch, $this->chord->rootPitch);	///TODO: change to smallestInterval - change 10 to -2, -8 to 4, etc...

		foreach ($this->notes as $note) {
			$transposed_pitch = new Pitch($note->pitch + $interval);
			$fit_pitch = $new_chord->fitPitch($transposed_pitch);
			$transposed_notes[] = new Note($fit_pitch, $note->duration);
		}

		return new Motif($transposed_notes);
	}

	/* 
	 * Copy the motif into the score again and again.
	 * Determine the smallest even number of measures that the motif will fit into -- say, 1 or 2.
	 * Copy one instance for each of those units.
	 * For each measure, check the chord assigned to that measure in the score and transpose the notes accordingly.
	 * Then call a subclass-defined helper function that allows you to modify that motif,
	 * as well as an environment we pass in.
	 * 
	 */

	public function fillIntoScore() {
		$lowest_pitch = $this->lowestPitch();
		$highest_pitch = $this->highestPitch();

		for ($measure = 0; $measure < $score->measuresCount; $measure += $this->measures) {
			$score->setNow($measure);
			$chord = $score->getNowChord();

			$transposed_motif = $this->transposeToChord($chord);

			foreach ($transposed_motif->notes as $note) {
				$octave_shift = null;
				$above_lowest = Pitch::subtractPitches($note->pitch, $lowest_pitch);

				if ($above_lowest >= 12 && Choices::choose(Choices::BASS_NOTE_TOO_LOW, $above_lowest, $octave_shift)) {
					$octave_shift = Choices::UP_OCTAVE;
					$note->pitch += 12;
				} else {
					$below_highest = Pitch::subtractPitches($highest_pitch, $note->pitch);
					if (below_highest >= 12 && Choices::choose(Choices::BASS_NOTE_TOO_HIGH, $below_highest, $octave_shift)) {
						$octave_shift = Choices::DOWN_OCTAVE;
						$note->pitch -= 12;
					}
				}
			}

			$score->setNowMotif($this);
		}
	}

	/*
	 * returns the lowest pitch of the motif
	 */

	public function lowestPitch() {
		$min_pitch = Pitch::ABOVE_HIGHEST;

		foreach ($this->notes as $note)
			if ($note->pitch < $min_pitch)
				$min_pitch = $note->pitch;

		return $min_pitch < Pitch::ABOVE_HIGHEST ? $min_pitch : null;
	}

	/*
	 * returns the highest pitch of the motif
	 */

	public function highestPitch() {
		$max_pitch = Pitch::BELOW_LOWEST;

		foreach ($this->notes as $note)
			if ($note->pitch > $max_pitch)
				$max_pitch = $note->pitch;

		return $max_pitch < Pitch::BELOW_LOWEST ? $max_pitch : null;
	}

	abstract public function fillIntoScore();
}



class MainMotif extends Motif {

	/* 
	 * Someday, this method could, and should, be expanded into a whole new project: creating a melody.
	 * For now, our work is much more motif-based.
	 * Copy the motif into the score again and again.
	 * Determine the smallest even number of measures that the motif will fit into -- say, 1 or 2.
	 * Copy one instance for each of those units.
	 * For each measure, check the chord assigned to that measure in the score and transpose the notes accordingly.
	 *
	 * Essential rules, for each motif instance:
	 * * Don't just transpose.  Don't transpose at all.  Instead, start from our current pitch position,
	 * fix dissonance, and try to find ways to fit things.
	 * So:
	 * * Resolve any dissonance.
	 * * If the first pitch doesn't fit, consider transposing the whole motif in the direction needed to fit the first pitch.
	 * * Consider transposing diatonically??
	 * 
	 *
	 */

	public function fillIntoScore() {
		$lowest_pitch = $this->lowestPitch();
		$highest_pitch = $this->highestPitch();

		for ($measure = 0; $measure < $score->measuresCount; $measure += $this->measures) {
			$score->setNow($measure);
			$chord = $score->getNowChord();

			$transposed_motif = $this->transposeToChord($chord);

			foreach ($transposed_motif->notes as $note) {
				$octave_shift = null;
				$above_lowest = Pitch::subtractPitches($note->pitch, $lowest_pitch);

				if ($above_lowest >= 12 && Choices::choose(Choices::BASS_NOTE_TOO_LOW, $above_lowest, $octave_shift)) {
					$octave_shift = Choices::UP_OCTAVE;
					$note->pitch += 12;
				} else {
					$below_highest = Pitch::subtractPitches($highest_pitch, $note->pitch);
					if (below_highest >= 12 && Choices::choose(Choices::BASS_NOTE_TOO_HIGH, $below_highest, $octave_shift)) {
						$octave_shift = Choices::DOWN_OCTAVE;
						$note->pitch -= 12;
					}
				}
			}

			$score->setNowMotif($transposed_motif, Score::BASS_TRACK);
		}
	}
}

class BassMotif extends Motif {

	/* 
	 * Copy the motif into the score again and again.
	 * Determine the smallest even number of measures that the motif will fit into -- say, 1 or 2.
	 * Copy one instance for each of those units.
	 * For each measure, check the chord assigned to that measure in the score and transpose the notes accordingly.
	 *
	 * Essential rules:
	 * * Check the notes that result from transposing.  If any don't match the chord, move them til they do.
	 * Mostly we want to beware of minor-major shifts.
	 * 
	 * More rules, if time permits:
	 * * If there's time...we're about to go an octave over or above the starting pitch, transpose the note...
	 * ... or the note plus the rest of the motif... in the opposite direction.
	 * * Randomly consider changing a note or two, or consider displacing a note by an octave
	 * if the resulting interval isn't too large.
	 */

	public function fillIntoScore() {
		$lowest_pitch = $this->lowestPitch();
		$highest_pitch = $this->highestPitch();

		for ($measure = 0; $measure < $score->measuresCount; $measure += $this->measures) {
			$score->setNow($measure);
			$chord = $score->getNowChord();

			$transposed_motif = $this->transposeToChord($chord);

			foreach ($transposed_motif->notes as $note) {
				$octave_shift = null;
				$above_lowest = Pitch::subtractPitches($note->pitch, $lowest_pitch);

				if ($above_lowest >= 12 && Choices::choose(Choices::BASS_NOTE_TOO_LOW, $above_lowest, $octave_shift)) {
					$octave_shift = Choices::UP_OCTAVE;
					$note->pitch += 12;
				} else {
					$below_highest = Pitch::subtractPitches($highest_pitch, $note->pitch);
					if (below_highest >= 12 && Choices::choose(Choices::BASS_NOTE_TOO_HIGH, $below_highest, $octave_shift)) {
						$octave_shift = Choices::DOWN_OCTAVE;
						$note->pitch -= 12;
					}
				}
			}

			$score->setNowMotif($transposed_motif, Score::BASS_TRACK);
		}
	}

}

class AccompanimentPattern extends Motif {
	public $clusters;		///or just public $notes; ?

}

?>