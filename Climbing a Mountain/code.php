<?php

fscanf(STDIN, "%d %d", $w, $h);

$peak = [null, null, -1000];

for ($y = 0; $y < $h; ++$y) {
    foreach(explode(' ', trim(fgets(STDIN))) as $x => $value) {
        $grid[$y][$x] = intval($value);

        if($grid[$y][$x] > $peak[2]) $peak = [$x, $y, $grid[$y][$x]];
    }
}

fscanf(STDIN, "%d %d", $x, $y);
fscanf(STDIN, "%d", $s);

$queue = [[$x, $y]];
$visited = [];
$turn = 0;

while($queue) {
    $newQueue = [];

    foreach($queue as [$x, $y]) {
        if($peak[0] == $x && $peak[1] == $y) exit("$turn");

        if(isset($visited[$y][$x])) continue;
        else $visited[$y][$x] = true;

        foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            if($xu >= 0 && $xu < $w && $yu >= 0 && $yu < $h && $grid[$y][$x] >= $grid[$yu][$xu] - $s) $newQueue[] = [$xu, $yu];
        }
    }

    $queue = $newQueue;
    ++$turn;
}

echo "Not Possible" . PHP_EOL;
