<?php

fscanf(STDIN, "%d", $n);

for ($y = 0; $y < $n; ++$y) {
    $grid[] = explode(" ", trim(fgets(STDIN)));
}

//Get the interval between the values of cols x - 1 & x
for($x = 1; $x < $n; ++$x) {
    $interval = $grid[0][$x] - $grid[0][$x - 1];

    //The interval needs to be the same for each rows otherwise there's no solution
    for($y = 1; $y < $n; ++$y) {
        if($grid[$y][$x] - $grid[$y][$x - 1] != $interval) die("-1");
    }
}

//Get the interval between the values of rows y - 1 & y
for($y = 1; $y < $n; ++$y) {
    $interval = $grid[$y][0] - $grid[$y - 1][0];

    //The interval needs to be the same for each cols otherwise there's no solution
    for($x = 1; $x < $n; ++$x) {
        if($grid[$y][$x] - $grid[$y - 1][$x] != $interval) die("-1");
    }
}

$result = 0;

//We just sum how much we need to add to each cols & rows for them to all reach the max value
foreach([$grid[0], array_column($grid, 0)] as $array) {
    $max = max($array);
    
    foreach($array as $value) $result += $max - $value;
}


echo $result . PHP_EOL;
