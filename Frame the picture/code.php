<?php

$frame = stream_get_line(STDIN, 10 + 1, "\n");
fscanf(STDIN, "%d %d", $h, $w);

$size = strlen($frame);
$tw = $w + ($size + 1) * 2; //Width of the art
$th = $h + ($size + 1) * 2; //Height of the art

$art = array_fill(0, $th, str_repeat(" ", $tw)); //Empty art

//Set the frame
for($i = 0; $i < $size; ++$i) {
    for($x = $i; $x < $tw - $i; ++$x) {
        $art[$i][$x] = $frame[$i];
        $art[$th - $i - 1][$x] = $frame[$i];
    }
    for($y = $i; $y < $th - $i; ++$y) {
        $art[$y][$i] = $frame[$i];
        $art[$y][$tw - $i - 1] = $frame[$i];
    }
}

//Insert the picture in the center
for ($y = 0; $y < $h; ++$y) {
    $line = stream_get_line(STDIN, 100 + 1, "\n");

    $yl = $y + $size + 1; //Row of line in the art
    $art[$yl] = substr($art[$yl], 0, $size + 1) . $line . substr($art[$yl], $size + 1 + $w);
}

echo implode("\n", $art);
?>
