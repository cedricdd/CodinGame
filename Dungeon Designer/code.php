<?php

function GCD(int $a, int $b): int {
    return $b ? GCD($b, $a % $b) : $a;
}

function LCM(int $a, int $b): int {
    return $a * $b / GCD($a, $b);
}

function findPath(int $x, int $y, array $map, array $treasurePath = []) {
    global $w2, $h2;

    $toCheck = [[$x, $y, []]];
    $history = [];

    while(true) {
        $newCheck = [];

        foreach($toCheck as [$x, $y, $path]) {
            $index = $y * $w2 + $x;
            $history[$y][$x] = 1;
            $path[$index] = 1;

            if(isset($treasurePath[$index])) return $path;

            foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $w2 && $yu >= 0 && $yu < $h2 && !isset($history[$yu][$xu]) && $map[$yu][$xu] == '.') {
                    $newCheck[] = [$xu, $yu, $path];
                }
            }
        }

        if(!$newCheck) return $path;

        $toCheck = $newCheck;
    }
}


fscanf(STDIN, "%d %d", $w, $h);
fscanf(STDIN, "%d %d %d", $p, $q, $r);

$pq = $p * $q;
$lcm = LCM($p - 1, $q - 1);
$w2 = 2 * $w + 1;
$h2 = 2 * $h + 1;

for($y = 0; $y < $h2; ++$y) {
    if($y == 0 || $y == $h2 - 1) $map[] = str_repeat('#', $w2);
    elseif($y & 1) $map[] = '#' . str_repeat(".", $w2 - 2) . '#';
    else $map[] = str_repeat('#.', intdiv($w2, 2)) . '#';
}

for($y = 0; $y < $h - 1; ++$y) {
    for($x = 0; $x < $w - 1; ++$x) {
        $x2 = $x * 2 + 1;
        $y2 = $y * 2 + 1;

        $v = bcpowmod($r, bcpowmod(2, $x + $y * $w + 1, $lcm), $pq);

        if($v & 1) $map[$y2][$x2 + 1] = '#';
        else $map[$y2 + 1][$x2] = '#';
    }
}

$treasurePath = findPath(1, 0, $map);
$barrackPath = findPath($w2 - 2, $h2 - 1, $map, $treasurePath);

$indexBarrack = array_key_last($barrackPath);
$indexTreasure = array_key_last($treasurePath);

$map[intdiv($indexBarrack, $w2)][$indexBarrack % $w2] = 'X';
$map[intdiv($indexTreasure, $w2)][$indexTreasure % $w2] = 'T';
$map[0][1] = $map[$h2 - 1][$w2 - 2] = '.';

echo implode(PHP_EOL, $map);
