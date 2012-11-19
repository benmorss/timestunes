<?php

/* A class to grab and package up information about the current article. */

class ArticleInfo {

	public $section;

	public $terms;

	public $termsSerialized;

	public function __construct() {
		$this->section = $_GET['section'];
		$this->termsSerialized = $_GET['terms'];
		$this->terms = is_array($_GET['terms']) ? $_GET['terms'] : implode(',', $_GET['terms']);
	}

	public function serialize() {
		return "$section $termsSerialized";
	}
}

?>