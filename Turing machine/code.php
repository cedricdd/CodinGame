<?php

const DIRECTION = ["L" => -1, "R" => 1];

fscanf(STDIN, "%d %d %d", $S, $size, $position);

$tape = array_fill(0, $size, 0);
$state = trim(fgets(STDIN));

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $input = trim(fgets(STDIN));

    preg_match("/(\w+)\:(.*)/", $input, $matches);

    $actions[$matches[1]] = array_map(function ($action) {
       return explode(" ", $action); 
    }, explode(";", $matches[2]));
}

$actionsExcecuted = 0;

while(true) {
    ++$actionsExcecuted;

    [$symbol , $move, $next] = $actions[$state][$tape[$position]];

    $tape[$position] = $symbol;
    $position += DIRECTION[$move];

    //We reached the HALT action or went out of bounts
    if($next == "HALT" || $position < 0 ||$position >= $size) break;
    else $state = $next;
}

echo $actionsExcecuted . PHP_EOL . $position . PHP_EOL . implode("", $tape) . PHP_EOL;
?>
