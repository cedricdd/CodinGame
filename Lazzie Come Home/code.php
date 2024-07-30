<?php

const MOVES = ['N' => [0, -1], 'S' => [0, 1], 'E' => [1, 0], 'W' => [-1, 0]];

class MinPriorityQueue extends SplPriorityQueue {

    public function compare($a, $b) {
       return $b <=> $a;
    }
}

//Find the path from start to target
function solve(array $map, int $posX, int $posY, int $targetX, int $targetY): string {
    $queue = new MinPriorityQueue();
    $queue->insert([0, $posX, $posY, ""], 0);

    $history = [];

    while($queue->count()) {
        [$steps, $x, $y, $moves] = $queue->extract();

        if(isset($history[$y][$x])) continue;
        else $history[$y][$x] = 1;

        if($x == $targetX && $y == $targetY) return $moves;

        foreach(MOVES as $d => [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            if(($map[$yu][$xu] ?? '.') != '#') {
                $queue->insert([$steps + 1, $xu, $yu, $moves . $d], $steps + abs($xu - $targetX) + abs($yu - $targetY));
            }
        }
    }

    return [];
}

fscanf(STDIN, "%d %d %d", $visionRange, $goalX, $goalY);

$posX = 0;
$posY = 0;
$map = [];
$moves = [];
$unknown = [];
$range = $visionRange >> 1;

while (TRUE) {
    for ($y = -$range; $y <= $range; ++$y) {
        $line = trim(fgets(STDIN));
        
        foreach(str_split($line) as $x => $c) {
            //Positions outside vision don't give any info and can be previously known positions
            if($c != '?') $map[$posY + $y][$posX - $range + $x] = $c;
        }

        error_log($line);
    }

    $start = microtime(1);

    error_log("We are at $posX $posY");
    error_log("Tartet: $targetX $targetY");

    $moves = solve($map, $posX, $posY, $goalX, $goalY);

    //Move player
    switch($moves[0]) {
        case 'N':   $posY--;  break;
        case 'S':   $posY++;  break;
        case 'W':   $posX--;  break;
        case 'E':   $posX++;  break;
    }

    echo $moves . PHP_EOL;

    error_log(microtime(1) - $start);
}
