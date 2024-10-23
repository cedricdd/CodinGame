<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $inputs[] = array_map("intval", explode(" ", fgets(STDIN)));
}

$x = $y = $N >> 1;

$history = [];
$toCheck = [[$x, $y]];

while($toCheck) {
    [$x, $y] = array_pop($toCheck);

    if(isset($history[$y][$x])) continue;
    else $history[$y][$x] = 1;

    if($x == 0 || $x == $N - 1 || $y == 0 || $y == $N - 1) exit("yes");

    foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
        $xu = $x + $xm;
        $yu = $y + $ym;

        if(abs($inputs[$y][$x] - $inputs[$yu][$xu]) <= 1) $toCheck[] = [$xu, $yu];
    }
}

echo "no" . PHP_EOL;
