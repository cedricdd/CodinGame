<?php

[$direction, $nbr, $height, $thickness, $spacing, $additional] = explode(" ", trim(fgets(STDIN)));

$arrow = str_repeat(($direction == "right" ? ">" : "<"), $thickness);
$space = str_repeat(" ", $spacing);

for($j = 0; $j < $height; ++$j) {
    if($direction == "right") $extraSpace = (($height >> 1) - abs(($height >> 1) - $j));
    else $extraSpace = abs(($height >> 1) - $j);

    echo str_repeat(" ", $extraSpace * $additional) . implode($space, array_fill(0, $nbr, $arrow)) . PHP_EOL;
}
