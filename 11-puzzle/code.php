<?php

const DISTANCES = [
    [0, 1, 2, 3, 1, 2, 3, 4, 2, 3, 4, 5],
    [1, 0, 1, 2, 2, 1, 2, 3, 3, 2, 3, 4],
    [2, 1, 0, 1, 3, 2, 1, 2, 4, 3, 2, 3],
    [3, 2, 1, 0, 4, 3, 2, 1, 5, 4, 3, 2],
    [1, 2, 3, 4, 0, 1, 2, 3, 1, 2, 3, 4],
    [2, 1, 2, 3, 1, 0, 1, 2, 2, 1, 2, 3],
    [3, 2, 1, 2, 2, 1, 0, 1, 3, 2, 1, 2],
    [4, 3, 2, 1, 3, 2, 1, 0, 4, 3, 2, 1],
    [2, 3, 4, 5, 1, 2, 3, 4, 0, 1, 2, 3],
    [3, 2, 3, 4, 2, 1, 2, 3, 1, 0, 1, 2],
    [4, 3, 2, 3, 3, 2, 1, 2, 2, 1, 0, 1],
    [5, 4, 3, 2, 4, 3, 2, 1, 3, 2, 1, 0],
];

const NEIGHBORS = [
    [1, 4], [0, 2, 5], [1, 3, 6], [2, 7], [0, 5, 8], [1, 4, 6, 9], [2, 5, 7, 10], [3, 6, 11], [4, 9], [5, 8, 10], [6, 9, 11], [7, 10]
];

const WINSTATE = 205163983024656; //101110101001100001110110010101000011001000010000

class CustomPriorityQueue extends SplPriorityQueue {

    //We want to prioritize the ones with the smallest value not the highest
    public function compare($a, $b) {
       return $b <=> $a;
    }
}

$state = 0;
$distance = 0;

for ($y = 0; $y < 3; ++$y) {
    foreach(explode(" ", trim(fgets(STDIN))) as $x => $input) {
        $index = $y * 4 + $x;

        //This is currently the empty position
        if($input == 0) $emptyPosition = $index;
        //We use the distance from the tiles to their final positions as sorting for the next node to check
        else $distance += DISTANCES[$input][$index] + (($index == $input) ? 0 : 1);

        //We use 4 bits for each positions
        $state |= $input << ($index * 4);
    }
}

$start = microtime(1);

$history = [];

$queue = new \CustomPriorityQueue();
$queue->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
$queue->insert([$emptyPosition, $state, [], 0], $distance);

while($queue->count()) {

    //Next node to check, the one with the smallest (distance + turns)
    ["data" => [$emptyPosition, $state, $list, $turn], "priority" => $distance] = $queue->extract();

    if($state == WINSTATE) break; //All the tiles are in the right spot

    $history[$state] = 1;

    foreach(NEIGHBORS[$emptyPosition] as $newEmptyPosition) {
        $list[$turn] = $newEmptyPosition;

        $tile = ($state >> ($newEmptyPosition * 4)) & 15;

        //Switch the empty & the tile
        $updatedState = ($state | ($tile << ($emptyPosition * 4))) & ~(15 << ($newEmptyPosition * 4));

        //We don't want to check the same state several times
        if(!isset($history[$updatedState])) {
            //The new distance is the old distance plus the change for the tile we moved plus 1 for the move we made
            $updatedDistance = $distance + (DISTANCES[$tile][$emptyPosition] - DISTANCES[$tile][$newEmptyPosition]) + 1;

            $queue->insert([$newEmptyPosition, $updatedState, $list, $turn + 1], $updatedDistance);
        }
    }
}

echo implode("\n", array_map(function ($position) {
    //ROW and the COLUMN of the tile to move
    return intdiv($position, 4) . " " . ($position % 4);
}, $list)) . PHP_EOL;

error_log(microtime(1) - $start);
