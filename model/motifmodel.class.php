<?php

include_once ("../config/config.php");

class MotifModel extends Model {
    private $table = 'motif';

    const MAIN_MOTIF = 1;
    const BASS_MOTIF = 2;
    const ACCOMP_MOTIF = 3;
    const PERCUSSION_MOTIF = 4;

    public function insertMotif($notes, $type) {
        $sql = "SELECT max(motif_id) FROM {$this->table}";
        $newMotifId = $this->getSingleton($sql) + 1;
        foreach ($notes as $index => $note) {
            foreach ($note->pitches as $pitch) {
                $sql = "INSERT INTO {$this->table} (motif_id, seq, pitch, duration)
                        VALUES ($newMotifId, $index + 1, {$pitch->pitch}, {$note->duration->duration})";

                        duration->duration?  oy.
            }

        }
    }

    public function getMotifsCount($type) {
        $sql = "SELECT max(motif_id) FROM {$this->table}
                INNER JOIN motif2type ON motif_id=FK_motif_id
                WHERE type_id = $type";        
    }

}

?>