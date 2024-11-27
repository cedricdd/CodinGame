<?php

function solve(array $rectangle): int {
    if(!$rectangle) return 1;

    [$x, $y] = array_pop($rectangle);

    unset($rectangle["$x $y"]);
    $count = 0;
    
    if(isset($rectangle[$x . " " . ($y - 1)])) {
        $rectangle2 = $rectangle;
        
        unset($rectangle2[$x . " " . ($y - 1)]);

        $count += solve($rectangle2);
    }

    if(isset($rectangle[($x - 1) . " " . $y])) {
        $rectangle2 = $rectangle;
        
        unset($rectangle2[($x - 1) . " " . $y]);

        $count += solve($rectangle2);
    }

    return $count;
}

$start = microtime(1);

fscanf(STDIN, "%d", $H);
fscanf(STDIN, "%d", $W);

if($H & 1 && $W & 1) exit("0"); //If both values are odd the results will always be 0

for($y = 0; $y < $H; ++$y) {
    for($x = 0; $x < $W; ++$x) {
        $rectangle["$x $y"] = [$x, $y];
    }
}

echo solve($rectangle) . PHP_EOL;

error_log(microtime(1) - $start);
