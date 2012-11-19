<?php

require_once("../config/config.php");

$model = new ChordModel();

if (!isset($argv[1]))
	usage();


switch ($argv[1]) {
	case '-erase':
		$model->deleteAll();
		break;

	case '-read':
		if (!$argv[2])
			usage();
		else
			insertNew($model, $argv[2]);
		break;

	default:
		usage();
}

exit(0);

function usage() {
	echo "Usage: chordstool.php [-erase | -read target_file]\n";
	exit(1);
}


/**
 * for each line in the file,
 * read the chords
 * and insert them as a progression into the db
 */

function insertNew($model, $filename) {
	if (!($lines = file($filename))) {
		echo "Error: $filename does not exist. So sorry!\n";
		exit(1);
	}

	foreach ($lines as $line) {
		$chords = explode(' ', $line);
		if ($chords)
			$model->insertProgression($chords);
	}
}

?>