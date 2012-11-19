<?php

/**
 * This class handles anything to do with chords.
 *
 * @author Ben Morss
 */

class Chord {
	
	// the chord's representation as text
	public $text;

	// the chord's pitches
	public $chordPitches = array();

	// the chord root
	public $rootPitch;

	// the note in the bass
	public $bassPitch;

	// a map of chord symbols to pitch-class sets
	private $chordSymbolsMap = 
		array('M' => array(0, 4, 7),
			  'm' => array(0, 3, 7),
			  'add2' => array(0, 2, 4, 7),
			  '6' => array(0, 4, 7, 9),
			  '7' => array(0, 4, 7, 10),
			  '9' => array(0, 2, 4, 7, 10),
			  '11' => array(0, 2, 5, 7, 10),
			  '13' => array(0, 2, 5, 9, 10),
			  'M7' => array(0, 4, 7, 11),
			  'm7' => array(0, 3, 7, 10),
			  'M9' => array(0, 2, 4, 7, 11),
			  'm9' => array(0, 2, 3, 7, 10),
		);

	private $chordNameRegEx = '/^([A-Ga-g][b#]?)([Mm]?(?:7|9|11|13)?)(?:\/([A-Ga-g][b#]?))?$/';

	/**
	 * Construct a chord given a text representation of a chord.
	 * Parse the text into its components.
	 * And create the chord pitch-classes by looking up what pitch-classes the symbol implies,
	 * then add the chord root pitch-class to each.
	 * 
	 * @param text the chord as text
	 */

	public function __construct($text) {
		$parts = $this->parseChordNameParts($text);	print "PARTS: "; print_r($parts);
		$this->text = $text;
		$this->rootPitch = $parts['rootPitch'];
		$this->bassPitch = $parts['bassPitch'];

		$chord_pitch_classes = $this->chordSymbolsMap[$parts['symbol']];

		foreach ($chord_pitch_classes as $pitch_class)
			$this->chordPitches[] = Pitch::addPitchClasses($pitch_class, $this->rootPitch);
		// error handling?
	}

	/**
	 * The constructor has already stored the chord as text.
	 */

	public function __toString() {
		return $this->text;
	}

	/**
	 * Parse a chord name into its component parts,
	 * which are a pitch name, a chord symbol, and an optional "/" followed by another pitch name.
	 *
	 * @param text the chord as text
	 */

	private function parseChordNameParts($text) {
		if (!preg_match($this->chordNameRegEx, $text, $matches))
			return false; // error handling?

		$symbol = isset($matches[2]) ? $matches[2] : 'M';		// major triad is the default
		$bassPitch = isset($matches[3]) ? new Pitch($matches[3]) : '';

		return array(
			'rootPitch' => new Pitch($matches[1]),
			'symbol' 	=> $symbol,
			'bassPitch' => $bassPitch
		);
	}

	/*
	 * try a simple algorithm:
	 * if any pitch in the transposed motif is a half-step away from a pitch in the new chord,
	 * move that pitch to the chord pitch.
	 *
	 * @param Pitch $pitch
	 */
	public function fitPitch($pitch) {
		if (is_numeric($pitch))
			$pitch = new Pitch($pitch);

		foreach ($this->chordPitches as $chord_pitch)
			if (Pitch::interval($chord_pitch, $pitch) == 1)
				return $chord_pitch;
		
		return $pitch;
	}

} 

?>