<?php

fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $K);

for ($y = 0; $y < $h; $y++) {
    $line = trim(fgets(STDIN));

    if(($x = strpos($line, 'S')) !== false) [$xs, $ys] = [$x, $y];

    $maze[] = $line;
}

error_log(var_export($maze, true));
error_log("$xs $ys");

for($i = 0; $i < $w; ++$i) {
    $mazes[] = $maze;
    $mazeHash[] = implode("", $maze);

    for($j = 0; $j < $h; ++$j) {
        if($j & 1) $maze[$j] = $maze[$j][-1] . substr($maze[$j], 0, -1);
        else $maze[$j] = substr($maze[$j], 1) . $maze[$j][0];
    }
}

error_log(var_export($mazes, true));

$turn = 0;
$mazeIndex = 0;
$toCheck = [[$xs, $ys]];
$history = [];

while(true) {
    $newCheck = [];

    error_log("checking $turn -- " . count($toCheck));

    foreach($toCheck as [$x, $y]) {
        error_log("at $x $y");

        $hash = $mazeHash[$mazeIndex];
        $hash[$y * $w + $x] = 'P';

        if(isset($history[$hash])) {
            error_log("skipping $hash");
            continue;
        } else $history[$hash] = 1;

        foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            if($xu < 0 || $xu >= $w || $yu < 0 || $yu >= $h || $mazes[$mazeIndex][$yu][$xu] == '#') continue; 

            if($mazes[$mazeIndex][$yu][$xu] == 'E') break 3;
            
            $newCheck[$yu * $w + $xu] = [$xu, $yu];
        }
    }

    if(count($newCheck) == 0) exit("IMPOSSIBLE");

    if(++$turn % $K == 0) {
        ++$mazeIndex;

        foreach($newCheck as [&$x, $y]) {
            if($y & 1) $x = ($x - 1 + $w) % $w;
            else $x = ($x + 1) % $w;
        }
    }

    $toCheck = $newCheck;
}

echo $turn . PHP_EOL;
