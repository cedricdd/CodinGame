<?php

$start = microtime(1);

$x = 0;
$y = 0;
$links = [];

foreach(str_split(trim(fgets(STDIN))) as $D) {
    //Save all the links we used while traveling
    switch($D) {
        case 'N': 
            $links[$x . '|' . $y][$x . '|' . ($y - 1)] = 'V';
            $y -= 1;
            break;
        case 'E':
            $links[$x . '|' . $y][($x - 1) . '|' . $y] = 'H';
            $x -= 1;
            break;
        case 'W':
            $links[$x . '|' . $y][($x + 1) . '|' . $y] = 'H';
            $x += 1;
            break;
    }
}

class MiPriorityQueue extends SplPriorityQueue {
    public function compare($a, $b) {
        return $b <=> $a;
    }
}

$solutionDistance = INF;
$dist = abs($x) + abs($y);

$queue = new MiPriorityQueue();
$queue->insert([$x, $y, $links, "", 0], $dist);

while(!$queue->isEmpty()) {
    [$x, $y, $links, $moves, $count] = $queue->extract();

    //We reached the starting position
    if($x == 0 && $y == 0) {
        $solutions[] = $moves;
        $solutionDistance = $count;
    }

    //Try South
    if((abs($x) + abs($y + 1) + $count) < $solutionDistance && !isset($links[$x . '|' . ($y + 1)][$x . '|' . $y])) {
        $queue->insert([$x, $y + 1, $links, $moves . 'S', $count + 1], $count + abs($x) + abs($y + 1));
    }
    //Try East
    if((abs($x - 1) + abs($y) + $count) < $solutionDistance && !isset($links[$x . '|' . $y][($x - 1) . '|' . $y]) && !isset($links[($x - 1) . '|' . $y][$x . '|' . $y])) {
        $queue->insert([$x - 1, $y, $links + [$x . '|' . $y => [($x - 1) . '|' . $y => 'H']], $moves . 'E', $count + 1], $count + abs($x - 1) + abs($y));
    }
    //Try West
    if((abs($x + 1) + abs($y) + $count) < $solutionDistance && !isset($links[$x . '|' . $y][($x + 1) . '|' . $y]) && !isset($links[($x + 1) . '|' . $y][$x . '|' . $y])) {
        $queue->insert([$x + 1, $y, $links + [$x . '|' . $y => [($x + 1) . '|' . $y => 'H']], $moves . 'W', $count + 1], $count + abs($x + 1) + abs($y));
    }
}

sort($solutions);

echo implode(PHP_EOL, $solutions) . PHP_EOL;
