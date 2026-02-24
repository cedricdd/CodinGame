<?php

fscanf(STDIN, "%f %f %f", $v0, $theta, $d);

$r = ($v0 * $v0 * sin(deg2rad($theta * 2))) / 9.80665;

if(abs($r - $d) <= 0.5) echo "HIT" . PHP_EOL;
else echo "MISS " . round($r - $d, 2) . PHP_EOL;
