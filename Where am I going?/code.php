<?php

const INV = ['U' => 'D', 'D' => 'U', 'L' => 'R', 'R' => 'L'];
const TURN = [
    'R' => ['U' => 'L', 'D' => 'R'], 
    'L' => ['U' => 'R', 'D' => 'L'],
    'U' => ['L' => 'L', 'R' => 'R'],
    'D' => ['L' => 'R', 'R' => 'L'],
];

fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $w);
for ($i = 0; $i < $h; $i++) {
    $map[] = trim(fgets(STDIN));
}

$direction = "R";
$x = 0;
$y = 0;
$count = 0;
$list = "";

while(true) {
    ++$count;

    foreach(['D' => [0, 1], 'U' => [0, -1], 'R' => [1, 0], 'L' => [-1, 0]] as $newDirection => [$xm, $ym]) {
        if($newDirection == INV[$direction]) continue;

        $xu = $x + $xm;
        $yu = $y + $ym;

        if($xu < 0 || $xu >= $w || $yu < 0 || $yu >= $h) continue; //Out of the map

        //We have found the next position
        if(!isset($visited[$yu][$xu]) && $map[$yu][$xu] == '#') {
            //We are turning
            if($newDirection != $direction) {
                $list .= $count . TURN[$direction][$newDirection];
                $count = 0;
            }

            $direction = $newDirection;
            $x = $xu;
            $y = $yu;

            continue 2;
        }
    }

    break;
}

echo $list . $count . PHP_EOL;
