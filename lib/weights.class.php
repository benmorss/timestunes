<?php
/// deprecated!
class Weights {

	private $articleInfo;
	
	public function __construct($article_info) {
		$this->articleInfo = $article_info;
		$this->seed();
	}

	private seed() {
		srand(crc32($this->articleInfo->serialize()));
	}

}

?>