<?php

function incWeight($base, $increment, $iterations) {
	if ($base >= 100)
		return 100;

	for ($i = 0; $i < $iterations; $i++) {
		$add = (100 - $base) * ($increment / 100);
		$base += $add;  print "base = $base\n";
	}
}

print incWeight(75, 15, 10);

?>
