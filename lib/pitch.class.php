<?php

///TODO: right now we translate pitch names into pitch classes - the octave can't be specified.

/**
 * This class handles anything to do with pitches.
 * A pitch-class is a numeric representation of the pitch in its octave, an integer between 0 and 11.
 *
 * @author Ben Morss
 */

class Pitch {

	const BELOW_LOWEST = -1;
	const ABOVE_HIGHEST = 256;

	// maps pitch names to their pitch-class representations
	private $nameToPitchClassMap = array( 
		'C' => 0, 'D' => 2, 'E' => 4, 'F' => 5, 'G' => 7, 'A' => 9, 'B' => 11
	);

	// useful to convert pitch names to pitch-classes.
	// will need to be expanded to handle flats as well.
	private $pitchClassToNameMap = array(
		'C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'
	);

	// the pitch's representation as text
	public $name;

	// the pitch's numeric representation
	public $pitch;

	// the chord the pitch is over
	// not currently used, but this will help someday with enharmonic notation issues
	// public $chord;

	/** 
	 * @param mixed $arg - a pitch in either numeric or text form
	 */

	public function __construct($arg) {
		if (is_numeric($arg)) {
			$this->pitch = $arg;
			$this->name = $this->pitchToName($arg);
		} else {
			$this->pitch = $this->nameToPitchClass($arg);
			$this->name = $arg;
		}
	}

	public function __toString() {
		return $this->name;
	}

	/** 
	 * Convert a pitch-class to its text representation, e.g. 1 to C#.
	 * @param int $pc - a pitch-class
	 */

	 private function pitchClassToName($pc) {
		return $this->pitchClassToNameMap[$pc];
	}

	/** 
	 * Convert a pitch to its text representation, e.g. 25 to C#.
	 * @param int $pitch - a pitch-class
	 */

	private function pitchToName($pitch) {
		return $this->pitchClassToName($pitch % 12);
	}

	// Assume no double accidentals.

	/** 
	 * Convert the text representation of a pitch to a pitch-class, e.g. C# to 1.
	 * This handles a single sharp or single flat, but not double accidentals.
	 * @param string $name - the text representation of a pitch
	 */

	private function nameToPitchClass($name) {
		$letter = strtoupper(substr($name, 0, 1));
		$pitchClass = $this->nameToPitchClassMap[$letter];
		$accidental = substr($name, 1);

		if ($accidental == 'b')
			$pitchClass--;
		elseif ($accidental == '#')
			$pitchClass++;

		return $pitchClass;
	}

	/** 
	 * Add two pitch objects or pitch-classes together.
	 * The result is a pitch-class.
	 * Simpe modulo arithmetic.
	 * Either parameter can be a pitch, pitch-class, or pitch object.
	 * @param mixed $pc1
	 * @param mixed $pc2
	 */

	public static function addPitchClasses($pc1, $pc2) {
		$a = is_object($pc1) ? $pc1->pitch : $pc1;
		$b = is_object($pc2) ? $pc2->pitch : $pc2;
		return new Pitch(($a + $b) % 12);
	}

	/**
	 * Add two pitches together.  Simple.
	 */

	public static function addPitches($p1, $p2) {
		$a = is_object($p1) ? $p1->pitch : $p1;
		$b = is_object($p2) ? $p2->pitch : $p2;
		return new Pitch($a + $b);
	}

	/**
	 * Subtract one pitch from another.
	 */

	public static function subtractPitches($p1, $p2) {
		$a = is_object($p1) ? $p1->pitch : $p1;
		$b = is_object($p2) ? $p2->pitch : $p2;
		return ($a - $b);		
	}

	/**
	 * the interval between two pitches is the absolute value of their difference
	 */

	public static function interval($p1, $p2) {
		return abs($this->subtractPitches($p1, $p2));		
	}

	/**
	 * the smallest of the interval or its inversion
	 */

	public static function smallestInterval($p1, $p2) {
		$interval = $this->interval($p1, $p2);
		return min($interval, 12 - $interval);
	}

}

?>