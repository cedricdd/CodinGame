<?php

function getUnvisited(int $x, int $y, array $visited): array {
    global $n;

    $positions = [];

    foreach(MOVES as [$xm, $ym]) {
        $xu = $x + $xm;

        if($xu < 0 || $xu >= $n) continue;

        $yu = $y + $ym;

        if($yu < 0 || $yu >= $n) continue;

        if(!isset($visited[$yu][$xu])) $positions[] = [$xu, $yu];
    }

    return $positions;
}

const MOVES = [[1, -2], [-1, -2], [2, 1], [2, -1], [1, 2], [-1, 2], [-2, 1], [-2, -1]];

fscanf(STDIN, "%d", $n);

for ($j = 0; $j < $n; ++$j) {
    fscanf(STDIN, "%s", $row);

    foreach(str_split($row) as $i => $c) {
        if($c == 'K') {
            $x = $i;
            $y = $j;
        }
    }
}

$visited = [];
$turn = 0;
$output = array_fill(0, $n, array_fill(0, $n, '*'));

while(true) {
    $output[$y][$x] = $turn++;
    $visited[$y][$x] = true;
    $unvisited = getUnvisited($x, $y, $visited);

    if(count($unvisited) == 0) break; //All squares have been visited or no legal move remains.

    $next = [];

    foreach($unvisited as [$x2, $y2]) {
        $unvisitedNext = getUnvisited($x2, $y2, $visited);

        $next[] = [$x2, $y2, count($unvisitedNext)];
    }

    usort($next, function($a, $b) {
        [$xa, $ya, $ca] = $a;
        [$xb, $yb, $cb] = $b;

        if($ca != $cb) return $ca <=> $cb; //Choose the candidate with the smallest count.
        elseif($ya != $yb) return $ya <=> $yb; //Choose the one with the smallest row index
        else return $xa <=> $xb; //Choose the one with the smallest column index
    });

    [$x, $y, $_] = $next[0];
}

echo implode(PHP_EOL, array_map(function($line) {
    return implode(" ", $line);
}, $output));
