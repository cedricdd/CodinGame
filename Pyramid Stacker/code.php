<?php
fscanf(STDIN, "%d %d", $n, $h);
fscanf(STDIN, "%s", $cubes);

$output = [];
$index = 0;

for($i = $h; $i > 0; --$i) {

    $layerCubes = $i * $i;

    for($y = 0; $y < $layerCubes; ++$y) {
        if(!($c = $cubes[$index++] ?? null)) break 2;

        $output[$i][$h - ($y % $i)] = $c;
    }
}

for($i = 1; $i <= $h; ++$i) {
    if(!isset($output[$i])) echo PHP_EOL;
    else echo str_repeat(" ", $h - $i) . implode(" ", $output[$i]) . PHP_EOL;
}
