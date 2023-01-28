<?php

fscanf(STDIN, "%d", $m);
fscanf(STDIN, "%d", $n);

$bars = array_map("intval", explode(" ", trim(fgets(STDIN))));
$solution = [];
$spaceUsed = 0;

function solve(int $index, int $space, array $list): void {

    global $m, $n, $bars, $solution, $spaceUsed;

    //Do we have a solution that takes more space or the same amount but with an higher priority
    if($space > $spaceUsed || ($space == $spaceUsed && count($list) <= count($solution))) {
        $spaceUsed = $space;
        $solution = $list;
    }

    if($space == $m || $index == $n) return; //Box is full or no bars left to test

    //We don't use the bar
    solve($index + 1, $space, $list);

    //We use the bar
    if($space + $bars[$index] <= $m) {
        $list[] = $bars[$index];
        solve($index + 1, $space + $bars[$index], $list);
    }

}

solve(0, 0, []);

echo implode(" ", $solution) . PHP_EOL;
