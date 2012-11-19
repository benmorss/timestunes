<?php

include_once ("../config/config.php");

class ChordModel extends Model {
	private $table = 'chord_progression';

	public function insertProgression($chords) {
		$newChordProgressionId = $this->getSingleton("SELECT max(chord_progression_id) FROM {$this->table}") + 1;
		foreach ($chords as $index => $chord) {
            $pretty_chord = trim($chord);
			$sql = "INSERT INTO {$this->table} (chord_progression_id, seq, chord) 
                    VALUES ($newChordProgressionId, $index, '$pretty_chord')";
            $this->execute($sql);
        }
	}

    public function getProgressionsCount() {
        $sql = "SELECT count(DISTINCT chord_progression_id) FROM {$this->table}";
        return $this->getSingleton($sql);
    }

    public function getProgressionByIndex($index) {
        $sql = "SELECT * FROM {$this->table} WHERE chord_progression_id = $index ORDER BY seq";
        return $this->getRow($sql);
    }

}