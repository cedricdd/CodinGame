<?php

fscanf(STDIN, "%d %d", $h, $w);

$grid = [];
$index = 0;
$neighbors = [];
$size = $h * $w;
$start = microtime(1);

for ($y = 0; $y < $h; ++$y) {
    $line = stream_get_line(STDIN, $w + 1, "\n");

    foreach(str_split($line) as $c) {
        if($c != '.' && $c != 'H' && $c != 'V' && $c != 'X' && !isset($colors[$c])) $colors[$c] = 2;
    }

    $grid[] = $line;
}

fscanf(STDIN, "%d", $k);
for ($i = 0; $i < $k; $i++) {
    fscanf(STDIN, "%d %d %s", $x, $y, $c);

    error_log("$x $y $c");

    $grid[$y][$x] = $c;
    $colors[$c]++;
}

for($index = 0, $y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x, ++$index) {
        $c = $grid[$y][$x];

        if($x > 0) {
            $left = $grid[$y][$x - 1];
            if($left != 'X' && $left != 'V' && $c != 'V' && (!isset($colors[$c]) || !isset($colors[$left]) || $c == $left)) $neighbors[$index]['L'] = $index - 1;
        }
        if($x < $w - 1) {
            $right = $grid[$y][$x + 1];
            if($right != 'X' && $right != 'V' && $c != 'V' && (!isset($colors[$c]) || !isset($colors[$right]) || $c == $right)) $neighbors[$index]['R'] = $index + 1;
        }
        if($y > 0) {
            $up = $grid[$y - 1][$x];
            if($up != 'X' && $up != 'H' && $c != 'H' && (!isset($colors[$c]) || !isset($colors[$up]) || $c == $up)) $neighbors[$index]['U'] = $index - $w;
        }
        if($y < $h - 1) {
            $down = $grid[$y + 1][$x];
            if($down != 'X' && $down != 'H' && $c != 'H' && (!isset($colors[$c]) || !isset($colors[$down]) || $c == $down)) $neighbors[$index]['D'] = $index + $w;
        }
    }
}

error_log(var_export($grid, 1));
error_log(var_export($colors, 1));
error_log(var_export($neighbors, 1));

while (TRUE) {
    echo("x1 y1 x2 y2 colour_identifier\n");
}
