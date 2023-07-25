<?php

const THRESHOLD = 0.00000001;

$start = microtime(1);

fscanf(STDIN, "%d", $step);
fscanf(STDIN, "%d %d", $w, $h);
for ($y = 0; $y < $h; ++$y) {
    $line = trim(fgets(STDIN));

    //Find the initial position of the ant
    if(($x = strpos($line, "A")) !== false) $ants[$y * $w + $x] = [$x, $y, 1];

    $map[] = $line;
}

$turn = 0;

while(count($ants)) {
    $answer[++$turn] = 0.0;
    $newAnts = [];

    foreach($ants as $index => [$x, $y, $percentage]) {
        $percentage /= 4;

        //Ants can move north, south, east or west
        foreach([[0, $step], [0, -$step], [$step, 0], [-$step, 0]] as [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;
            $index = $yu * $w + $xu;

            //Ants reached the food
            if($xu < 1 || $yu < 1 || $xu >= $w - 1 || $yu >= $h - 1) $answer[$turn] += $percentage;
            //We already have ants reaching this position, increase the percentage
            elseif(isset($newAnts[$index])) $newAnts[$index][2] += $percentage;
            //Some ants can reach this position on the next turn
            else $newAnts[$index] = [$xu, $yu, $percentage];
        }
    }

    //We filter out if the percentage of chance the ants moves there becomes too low
    $ants = array_filter($newAnts, function($info) {
        return $info[2] >= THRESHOLD;
    });
} 

//Calculate the average time based on the percentage to reach the food on each turn
$average = 0.0;

foreach($answer as $turn => $percentage) {
    $average += $turn * $percentage;
}

echo number_format($average, 1) . PHP_EOL;

error_log(microtime(1) - $start);
