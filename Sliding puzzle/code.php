<?php

fscanf(STDIN, "%d %d", $H, $W);
for ($y = 0; $y < $H; ++$y) {
    foreach(explode(" ", trim(fgets(STDIN))) as $x => $input) {
        if($input == ".") $dotPosition = $y * $W + $x;

        $puzzle[] = $input;
    }
}

//The state when all the pieces are in their final positions
$winningState = implode("-", range(1, $H * $W - 1)) . "-.";

//Get all the neighbors of each positions
$neighbors = [];

for($y = 0; $y < $H; ++$y) {
    for($x = 0; $x < $W; ++$x) {
        $index = $y * $W + $x;

        if($x > 0) $neighbors[$index][] = $index - 1;
        if($x < $W - 1) $neighbors[$index][] = $index + 1;
        if($y > 0) $neighbors[$index][] = $index - $W;
        if($y < $H - 1) $neighbors[$index][] = $index + $W;
    }
}

$history = [];

$queue = new SplPriorityQueue();
$queue->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
$queue->insert([$dotPosition, $puzzle], 0);

while($queue->count()) {

    //All the test are super small, we can just check the next node with the less turn
    ["data" => [$dotPosition, $puzzle], "priority" => $turn] = $queue->extract();

    $state = implode("-", $puzzle);

    if($state == $winningState) break; //All the pieces are in the right position

    $history[$state] = 1;

    foreach($neighbors[$dotPosition] as $newDotPosition) {
        
        $updatedPuzzle = $puzzle;
        //Switch the 2 pieces
        $updatedPuzzle[$dotPosition] = $puzzle[$newDotPosition];
        $updatedPuzzle[$newDotPosition] = $puzzle[$dotPosition];

        //We don't want to check the same state several times
        if(!isset($history[implode("-", $updatedPuzzle)])) {
            $queue->insert([$newDotPosition, $updatedPuzzle], $turn - 1);
        }
    }
}

echo -$turn . PHP_EOL;
