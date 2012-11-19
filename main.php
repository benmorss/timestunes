<?php

/* Main algorithm */

require("../config/config.php");

$model = new Model();

$article_info = new ArticleInfo();
$choices = new Choices($model, $article_info);
$style = new Style($model, $article_info, $SECTIONS_LIST);

$factory = new Factory($model, $article_info);

$chord_progression = $factory->chooseChordProgression();
$main_motif = $factory->chooseMainMotif();
$bass_motif = $factory->chooseBassMotif();
$accompaniment_pattern = $factory->chooseAccompanimentPattern();

/*
$chord_progression = new ChordProgression($model, $article_info, $MEASURES_COUNT);
$main_motif = new MainMotif($model, $article_info);
$bass_motif = new BassMotif($model, $article_info);
$accompaniment_pattern = new AccompanimentPattern($model, $article_info);
*/

$score = new Score($MEASURES_COUNT, $BEATSPERMEASURE, $SUBBEATSPERBEAT);

$chord_progression->fillIntoScore($score);
$bass_motif->fillIntoScore($score);
$accompaniment_pattern->fillIntoScore($score);
$main_motif->fillIntoScore($score);

/*
Retrieve section info and terms.
Pick a main motif accordingly.
(Choose a form - not for this version)
Choose a rhythmic style.
Choose an arrangement palette.
Choose a bass motif.
Choose or generate a chord progression.
Place the accompaniment in the score.
Create a tune by developing the motif into the score.
*/

