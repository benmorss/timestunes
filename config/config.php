<?php

function __autoload($class_name) {
	$class_name = strtolower($class_name);
	$dir = strpos($class_name, 'model') === false ? 'lib' : 'model';
	// print "including ../$dir/$class_name.class.php\n";
	require_once("../$dir/$class_name.class.php");
}

/* Database config */
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_DATABASE = 'timestunes';

/* Other config */

// Number of measures in the score
$MEASURES_COUNT = 16;

// Number of beats in a measure
$BEATSPERMEASURE = 4;

// Number of subdivisions in a beat
$SUBBEATSPERBEAT = 4;

// A list of all sections on the site
$SECTIONS_LIST = array(	///TODO: Check these!!!
	'world',
	'us',
	'business',
	'technology',
	'science',
	'health',
	'sports',
	'opinion',
	'arts',
	'theater',
	'movies',
	'style',
	'travel',
	'jobs',
	'real estate',
	'autos'
	);


?>