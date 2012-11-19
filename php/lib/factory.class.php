<?php

class Factory {

	private $articleInfo;
	private $chordModel;
	private $motifModel;
	
	public function __construct($model, $article_info) {
		$this->articleInfo = $article_info;
		$this->chordModel = new ChordModel();
		$this->motifModel = new MotifModel();
	}

/*
 * For now, just choose these things randomly.
 */

 	public function chooseMainMotif() {
		$mm_count = $this->model->getMotifsCount(MotifModel::MAIN_MOTIF);
		$choice = rand(1, $mm_count);
		$notes = $this->model->getMotifByIndex(MotifModel::MAIN_MOTIF, $choice);
		return new MainMotif($this->model, $notes);
	}

 	public function chooseBassMotif() {
		$bm_count = $this->model->getMotifsCount(MotifModel::BASS_MOTIF);
		$choice = rand(1, $bm_count);
		$notes = $this->model->getMotifByIndex(MotifModel::BASS_MOTIF, $choice);
		return new BassMotif($this->model, $notes);
	}

	public function chooseChordProgression() {
		$cp_count = $this->model->getProgressionsCount();
		$choice = rand(1, $cp_count);
		$chords = $this->model->getProgressionByIndex($choice);
		return new ChordProgression($chords);
	}


	public function chooseTempo($style) {
		return $this->model->chooseTempo($style);
	}

	public function chooseAccompanimentPattern($style) {
		$accompaniments = $this->motifModel->getAccompanimentsForStyle($style);
		$choice = rand(0, count($patterns) - 1);
		return new AccompanimentPattern($accompaniments[$choice]);
	}

}

?>