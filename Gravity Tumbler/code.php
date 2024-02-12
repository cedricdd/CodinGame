<?php

fscanf(STDIN, "%d %d", $width, $height);
fscanf(STDIN, "%d", $count);

//Result are repeated, we just need to flip the array once if the number of steps is odd
$map = ($count & 1) ? array_fill(0, $width, str_repeat(".", $height)) : array_fill(0, $height, str_repeat(".", $width));

for ($i = 0; $i < $height; $i++) {
    $line = trim(fgets(STDIN));
    $occ = substr_count($line, "#");
    
    for($j = 0; $j < $occ; ++$j) {
        if($count & 1) $map[$width - $j - 1][$i] = "#"; //Add # at the the of the col
        else $map[$i][$width - $j - 1] = "#"; //Add # at the the of the line
    }
}

echo implode("\n", $map) . PHP_EOL;
