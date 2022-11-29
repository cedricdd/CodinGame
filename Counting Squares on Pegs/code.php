<?php

$start = microtime(1);

$positions = [];
$squares = 0;

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $x1, $y1);

    //Check with all the previous points
    foreach($positions as [$x2, $y2]) {
        //We assume AB with A ($x1;$y1) & B ($x2;$y2) is a side of the square

       //The vector AB
        $vX = $x1 - $x2;
        $vY = $y1 - $y2;

        //Rotate vector AB by 90°
        [$vX, $vY] = [-$vY, $vX];

        //If the points created by adding the rotated vector to A & B exist we have found a square
        if(isset($checks[$y1 + $vY][$x1 + $vX]) && isset($checks[$y2 + $vY][$x2 + $vX])) ++$squares;
    }

    $positions[] = [$x1, $y1];
    $checks[$y1][$x1] = 1;
}

echo $squares . PHP_EOL;

error_log(microtime(1) - $start);
