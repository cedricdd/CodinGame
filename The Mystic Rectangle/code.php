<?php

fscanf(STDIN, "%d %d", $xa, $ya);
fscanf(STDIN, "%d %d", $xt, $yt);

//Smallest distance on x axis
$distX = min(abs($xa - $xt), abs(max($xa, $xt) - (min($xa, $xt) + 200)));
//Smallest distance on y axis
$distY = min(abs($ya - $yt), abs(max($ya, $yt) - (min($ya, $yt) + 150)));

//We move diagonally first then finish horizontally or vertically
echo number_format(min($distX, $distY) * 0.5 + (abs($distX - $distY) * (($distX > $distY) ? 0.3 : 0.4)), 1) . PHP_EOL;
?>
