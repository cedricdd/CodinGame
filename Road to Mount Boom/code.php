<?php

class MiPriorityQueue extends SplPriorityQueue {
    public function compare($a, $b) {
        return $b <=> $a;
    }
}

fscanf(STDIN, "%d %d", $h, $w);
for ($y = 0; $y < $h; $y++) {
    $line = stream_get_line(STDIN, $w + 1, "\n");

    if(($x = strpos($line, 'B')) !== false) [$xB, $yB] = [$x, $y];
    if(($x = strpos($line, 'M')) !== false) [$xM, $yM] = [$x, $y];

    $map[] = str_split($line);

    error_log(var_export($line, 1));
}

$start = microtime(1);

$history = [];

$queue = new MiPriorityQueue();
$queue->insert([$xB, $yB, 0], abs($xB - $xM) + abs($yB - $yM));

while(true) {
    [$x, $y, $distance] = $queue->extract();

    if($x == $xM && $y == $yM) {
        error_log(microtime(1) - $start);
        exit($distance . " " . ($distance > 1 ? "leagues" : "league"));
    }

    if(isset($history[$y][$x])) continue;
    else $history[$y][$x] = $distance;

    // Cardinal directions
    foreach([[1, 0], [0, 1], [-1, 0], [0, -1]] as [$xm, $ym]) {
        $xu = $x + $xm;
        $yu = $y + $ym;

        if(($map[$yu][$xu] ?? ' ') != '^') $queue->insert([$xu, $yu, $distance + 1], abs($xu - $xM) + abs($yu - $yM) + $distance);

    }

    // Ordinal directions, we can't move diagonally between two mountains
    foreach([[-1, -1, -1, 0, 0, -1], [1, -1, 0, -1, 1, 0], [-1, 1, -1, 0, 0, 1], [1, 1, 0, 1, 1, 0]] as [$xm, $ym, $x1, $y1, $x2, $y2]) {
        $xu = $x + $xm;
        $yu = $y + $ym;

        if(($map[$yu][$xu] ?? ' ') != '^' && (($map[$y + $y1][$x + $x1] ?? ' ') != ($map[$y + $y2][$x + $x2] ?? ' ') || ($map[$y + $y1][$x + $x1] ?? ' ') != '^')) 
            $queue->insert([$xu, $yu, $distance + 1], abs($xu - $xM) + abs($yu - $yM) + $distance);
    }
}
