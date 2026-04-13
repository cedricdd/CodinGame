<?php

fscanf(STDIN, "%d", $n);

for ($y = 0; $y < $n; ++$y) {
    $grid[] = explode(" ", trim(fgets(STDIN)));
}

$intervalCols = [];
$intervalRows = [];

//Get the interval between the values of cols x - 1 & x
for($x = 1; $x < $n; ++$x) {
    $intervalCols[$x] = $grid[0][$x] - $grid[0][$x - 1];

    //The interval needs to be the same for each rows otherwise there's no solution
    for($y = 1; $y < $n; ++$y) {
        if($grid[$y][$x] - $grid[$y][$x - 1] != $intervalCols[$x]) die("-1");
    }
}

//Get the interval between the values of rows y - 1 & y
for($y = 1; $y < $n; ++$y) {
    $intervalRows[$y] = $grid[$y][0] - $grid[$y - 1][0];

    //The interval needs to be the same for each cols otherwise there's no solution
    for($x = 1; $x < $n; ++$x) {
        if($grid[$y][$x] - $grid[$y - 1][$x] != $intervalRows[$y]) die("-1");
    }
}

//Sort cols interval in ascending order (push the col with the highest value at the end)
while(true) {
    foreach($intervalCols as $i => $interval) {
        if($interval < 0) {
            $interval *= -1; //We invert the cols

            if($i < $n - 1) $intervalCols[$i + 1] -= $interval; //The col after is also affected
            if($i > 1) $intervalCols[$i - 1] -= $interval; //The col before is also affected
            $intervalCols[$i] = $interval;

            continue 2;
        }
    }

    break;
}

//Sort rows interval in ascending order (push the row with the highest value at the end)
while(true) {
    foreach($intervalRows as $i => $interval) {
        if($interval < 0) {
            $interval *= -1;

            if($i < $n - 1) $intervalRows[$i + 1] -= $interval; //The row after is also affected
            if($i > 1) $intervalRows[$i - 1] -= $interval; //The row before is also affected
            $intervalRows[$i] = $interval;

            continue 2;
        }
    }

    break;
}

$result = 0;
$totalC = array_sum($intervalCols);
$totalR = array_sum($intervalRows);

//Compute how many operations are required 
for($i = 1; $i < $n; ++$i) {
    $result += $totalC;
    $totalC -= $intervalCols[$i];

    $result += $totalR;
    $totalR -= $intervalRows[$i];
}

echo $result . PHP_EOL;
