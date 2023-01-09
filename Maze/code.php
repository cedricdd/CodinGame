<?php

fscanf(STDIN, "%d %d", $W, $H);
fscanf(STDIN, "%d %d", $X, $Y);
for ($i = 0; $i < $H; $i++) {
    $maze[] = str_split(trim(fgets(STDIN)));
}

$exits = [];
$toCheck = [[$X, $Y]];
$visited = [];

while(count($toCheck)) {
    [$x, $y] = array_pop($toCheck);

    //Don't visit the same position multiple times
    if(isset($visited[$y][$x])) continue;
    else $visited[$y][$x] = 1;

    //We found an exist
    if($x == 0 || $x == $W - 1 || $y == 0 || $y == $H - 1) {
        $exits[] = [$x, $y];
        continue;
    }

    //Check the 4 directions
    foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
        $xu = $x + $xm;
        $yu = $y + $ym;

        if($maze[$yu][$xu] != "#") $toCheck[] = [$xu, $yu];
    }
}

//Sort exit coordiantes by X, Y
usort($exits, function($a, $b) {
    if($a[0] == $b[0]) return $a[1] <=> $b[1];
    else return $a[0] <=> $b[0];
});

echo count($exits) . PHP_EOL;
if(count($exits)) {
    echo implode("\n", array_map(function($coordonates) {
        return implode(" ", $coordonates);
    }, $exits));
}
