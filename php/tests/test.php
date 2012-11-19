<?php

include ("../config/config.php");

function __autoload($class_name) {
	include "../lib/" . strtolower($class_name) . '.class.php';
}

$chord = new Chord('Bbm');
print "that chord was $chord\n";
print "its pitches are "; print_r($chord->chordPitches); print "\n\n";

/*
class MyClass {

	public $stuff;

   	public function __construct() {
       	global $MEASURES_COUNT;
       	$this->stuff = $MEASURES_COUNT;
	}

	public function __toString() {
		return (string) $this->stuff;
	}
}

$test = new MyClass();
print "Here we go: " . $test;
*/
?>