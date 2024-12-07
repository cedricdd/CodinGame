<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $map[] = explode(" ", trim(fgets(STDIN)));
}

if($map[0][0] == '|') $direction = "R";
elseif($map[0][0] == '-') $direction = "D";
elseif($map[0][0] == '/') $direction = "DR";

$toCheck = [[0, 0, $direction]];

while($toCheck) {
    [$x, $y, $d] = array_pop($toCheck);

    if($x >= $N || $x < 0 || $y >= $N || $y < 0) continue;

    $domino = $map[$y][$x];

    if($domino == '.') continue;
    if($domino == '|' && ($d == 'D' || $d == 'U')) continue;
    if($domino == '-' && ($d == 'L' || $d == 'R')) continue;
    if($domino == '/' && ($d == 'UR' || $d == 'DL')) continue;
    if($domino == '\\' && ($d == 'DR' || $d == 'UL')) continue;

    $map[$y][$x] = '.';

    switch($domino) {
        case '|':
            if(strpos($d, 'R') !== false) $toCheck[] = [$x + 1, $y, 'R'];
            if(strpos($d, 'L') !== false) $toCheck[] = [$x - 1, $y, 'L'];
            break;
        case '-':
            if(strpos($d, 'D') !== false) $toCheck[] = [$x, $y + 1, 'D'];
            if(strpos($d, 'U') !== false) $toCheck[] = [$x, $y - 1, 'U'];
            break;
        case '/':
            if(strpos($d, 'R') !== false || strpos($d, 'D') !== false) {
                $toCheck[] = [$x + 1, $y, 'R'];
                $toCheck[] = [$x + 1, $y + 1, 'DR'];
                $toCheck[] = [$x, $y + 1, 'D'];
            }
            if(strpos($d, 'L') !== false || strpos($d, 'U') !== false) {
                $toCheck[] = [$x - 1, $y, 'L'];
                $toCheck[] = [$x - 1, $y - 1, 'UL'];
                $toCheck[] = [$x, $y - 1, 'U'];
            }
            break;
        case '\\':
            if(strpos($d, 'R') !== false || strpos($d, 'U') !== false) {
                $toCheck[] = [$x + 1, $y, 'R'];
                $toCheck[] = [$x + 1, $y - 1, 'UR'];
                $toCheck[] = [$x, $y - 1, 'U'];
            }
            if(strpos($d, 'L') !== false || strpos($d, 'D') !== false) {
                $toCheck[] = [$x - 1, $y, 'L'];
                $toCheck[] = [$x - 1, $y + 1, 'DL'];
                $toCheck[] = [$x, $y + 1, 'D'];
            }
            break;
    }
}

$count = 0;

foreach($map as $line) {
    foreach($line as $c) {
        if($c != '.') ++$count;
    }
}

echo $count . PHP_EOL;
