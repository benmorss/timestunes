<?php

include_once("../config/config.php");

$model = new Model();

$article_info = new ArticleInfo();
$choices = new Choices($model, $article_info);
$factory = new Factory($model, $article_info, $MEASURES_COUNT);

$chord_progression = $factory->chooseChordProgression();

?>