<?php

require("config/config.php");

/* Script to convert MIDI to a motif */

$midi = new MidiSequence(file_get_contents($_GET['midifile']));
$motif = new Motif($midi);

/* Placing a motif into the score. 
   For now, let's do the really basic thing -- 
   if a note is dissonant, move it up or down until it's consonant.
   We will already have determined how many measures each motif instance should span.
 */
   ///TODO: deal with $beat
for ($measure = 1; $measure += $motif->measuresSpanned; $measure <= $score->length) {
	$score->setCurrentMeasure($measure);

	foreach ($motif->notes as $index => $note) {
		$chord = $score->getChordForMeasure($measure);

		if (dissonance::isDissonant($note, $chord)) {
			$previous_pitch = $score->getPreviousNote($measure, $beat);
			$next_note = $motif->notes[$index + 1];

			if (!dissonance::dissonanceTreated($score->getPreviousNote(), $note, $next_note, $chord)) {
				// here's where we either move the note up/down or add a new note on the end to treat dissonance.
			}
		}

		$score->setNextNote($note, Score::MELODY_TRACK)
	}
}

// dissonanceTreated() - know you may get null values for any note


/* Choosing a style using weights
   $style will contain a constant like STYLE::ROCK or STYLE::FUNK
 */

$style = choose($article_info, 'style');

function choose($article_info, $choice) {
	
}




?>
