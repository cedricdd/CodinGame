<?php

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $lines[] = trim(fgets(STDIN));
}

error_log(var_export($lines, 1));

$s = strlen($lines[0]);

//Find the width of the repetitive part of the pattern
for($i = 2; $i < $s; ++$i) {
    if($s % $i != 0) continue;

    for($y = 0; $y < $n; ++$y) {
        if(count(array_unique(str_split($lines[$y], $i))) != 1) continue 2; 
    }

    break;
}

foreach($lines as &$line) $line = substr($line, 0, $i);

error_log(var_export($lines, 1));

$left = array_map(function($line) { return substr($line, 0, floor(strlen($line) / 2)); }, $lines);
$right = array_map(function($line) { return substr($line, ceil(strlen($line) / 2)); }, $lines);

$hSymetry = array_slice($lines, 0, floor($n / 2)) === array_reverse(array_slice($lines, ceil($n / 2))); //Horizontal Symmetry
$vSymetry = $left === array_map("strrev", $right); //Vertical Symmetry
$rotation = $left === array_reverse(array_map("strrev", $right)); //Rotation
$glide = $left === array_reverse($right); //Glide Reflection

if($hSymetry && $vSymetry && $rotation) echo "pmm2" . PHP_EOL;
elseif($vSymetry && $glide) echo "pma2" . PHP_EOL;
elseif($hSymetry) echo "p1m1" . PHP_EOL;
elseif($vSymetry) echo "pm11" . PHP_EOL;
elseif($rotation) echo "p112" . PHP_EOL;
elseif($glide) echo "p1a1" . PHP_EOL;
else echo "p111" . PHP_EOL;
