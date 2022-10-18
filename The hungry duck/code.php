<?php

function solve(int $x, int $y): int {

    global $W, $H, $lake, $saved;

    if($x == $W || $y == $H) return 0; //Out of the lake
    if(isset($saved[$y][$x])) return $saved[$y][$x]; //We already know the best for this position

    return $saved[$y][$x] = $lake[$y][$x] + max(solve($x + 1, $y), solve($x, $y + 1)); //We can move only right or down
}

fscanf(STDIN, "%d %d", $W, $H);
for ($i = 0; $i < $H; $i++) {
    $lake[] = array_map("intval", explode(" ", trim(fgets(STDIN))));
}

$saved = [];
echo solve(0, 0) . PHP_EOL;
