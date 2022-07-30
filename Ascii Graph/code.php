<?php

fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $x[], $y[]);
    $points[$x[$i] . "-" . $y[$i]] = 1;
}

if($N != 0) {
    $minX = min(0, min($x)) - 1;
    $maxX = max(0, max($x)) + 1;
    $minY = min(0, min($y)) - 1;
    $maxY = max(0, max($y)) + 1;
} else {
    $minX = $minY = -1;
    $maxX = $maxY = 1;
}

//In this case y is decreasing when going down the axis not increasing
for($y = $maxY; $y >= $minY; --$y) {

    $line = "";

    //Set the character for this posisition
    for($x = $minX; $x <= $maxX ; ++$x) {
        if(isset($points[$x . "-" . $y])) $c = "*";
        elseif($x == 0 && $y == 0) $c = "+";
        elseif($y == 0) $c = "-";
        elseif($x == 0) $c = "|";
        else $c = ".";

        $line .= $c;
    }

    $map[] = $line;
}

echo implode("\n", $map);
?>
