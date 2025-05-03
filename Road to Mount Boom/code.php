<?php

fscanf(STDIN, "%d %d", $h, $w);
for ($i = 0; $i < $h; $i++) {
    $map[] = stream_get_line(STDIN, $w + 1, "\n");
}

error_log(var_export($map, 1));

$i = implode('', $map);

$pB = strpos($i, 'B');
$pM = strpos($i, 'M');

[$xB, $yB] = [$pB % $w, intdiv($pB, $w)];
[$xM, $yM] = [$pM % $w, intdiv($pM, $w)];

$toCheck = [[$xB, $yB]];
$history = [];
$distance = 0;

while($toCheck) {
    $newCheck = [];

    foreach($toCheck as [$x, $y]) {
        if($x == $xM && $y == $yM) exit($distance . " " . ($distance > 1 ? "leagues" : "league"));

        if(isset($history[$y][$x])) continue;
        else $history[$y][$x] = 1;

        foreach([[1, 0], [0, 1], [-1, 0], [0, -1]] as [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            if($map[$yu][$xu] != '^') $newCheck[] = [$xu, $yu];
        }

        foreach([[-1, -1, -1, 0, 0, -1], [1, -1, 0, -1, 1, 0], [-1, 1, -1, 0, 0, 1], [1, 1, 0, 1, 1, 0]] as [$xm, $ym, $x1, $y1, $x2, $y2]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            if($map[$yu][$xu] != '^' && ($map[$y + $y1][$x + $x1] != $map[$y + $y2][$x + $x2] || $map[$y + $y1][$x + $x1] != '^')) $newCheck[] = [$xu, $yu];
        }
    }

    ++$distance;
    $toCheck = $newCheck;
}
