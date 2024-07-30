<?php

const MOVES = ['N' => [0, -1], 'S' => [0, 1], 'E' => [1, 0], 'W' => [-1, 0]];

class MinPriorityQueue extends SplPriorityQueue {

    public function compare($a, $b) {
       return $b <=> $a;
    }
}

function solve(array $map, int $posX, int $posY, int $targetX, int $targetY): array {
    $queue = new MinPriorityQueue();
    $queue->insert([0, $posX, $posY, []], 0);

    $history = [];

    error_log("Tartet: $targetX $targetY");

    while($queue->count()) {
        [$steps, $x, $y, $moves] = $queue->extract();

        if(isset($history[$y][$x])) continue;
        else $history[$y][$x] = 1;

        // error_log("we are at $x $y - $steps - " . implode('', $moves));


        if($x == $targetX && $y == $targetY) return array_reverse($moves);

        foreach(MOVES as $d => [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;
            $moves[$steps] = $d;

            if(($map[$yu][$xu] ?? '.') != '#') {
                $queue->insert([$steps + 1, $xu, $yu, $moves], $steps + abs($xu - $targetX) + abs($yu - $targetY));
            }
        }
    }

    return [];
}

fscanf(STDIN, "%d %d %d", $visionRange, $goalX, $goalY);

error_log("$visionRange - $goalX $goalY");
$range = $visionRange >> 1;

$posX = 0;
$posY = 0;
$map = [];
$moves = [];
$unknown = [];

while (TRUE) {
    for ($y = -$range; $y <= $range; ++$y) {
        $line = trim(fgets(STDIN));
        
        foreach(str_split($line) as $x => $c) {
            $map[$posY + $y][$posX - $range + $x] = $c;
        }

        error_log($line);
    }

    $start = microtime(1);

    error_log("We are at $posX $posY");

    $moves = solve($map, $posX, $posY, $goalX, $goalY);

    $move = array_pop($moves);

    switch($move) {
        case 'N':   $posY--;  break;
        case 'S':   $posY++;  break;
        case 'W':   $posX--;  break;
        case 'E':   $posX++;  break;
    }

    echo $move . PHP_EOL;

    error_log(microtime(1) - $start);
}
