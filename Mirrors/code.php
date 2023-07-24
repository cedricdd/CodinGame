<?php

const THRESHOLD_LIGHT = 10 ** -10;

fscanf(STDIN, "%d", $n);
$r = array_map('floatval', explode(" ", trim(fgets(STDIN))));

$emptyArray = array_fill(0, $n + 1, 0.0);
$mirrorsL = $emptyArray;
$mirrorsR = $emptyArray;
$mirrorsL[0] = 1.0;

$answer = 0.0;
$turns = 0;

do {
    $loopMirrorsL = $emptyArray;
    $loopMirrorsR = $emptyArray;

    $notEnoughLight = true;

    for($i = 0; $i < $n; ++$i) {
        //We consider the light doesn't exist anymore if it's below the threshold
        if($mirrorsL[$i] > THRESHOLD_LIGHT) {
            $reflected = $mirrorsL[$i] * $r[$i];

            if($i == 0) $answer += $reflected; //This light is reflected to the source
            else $loopMirrorsR[$i - 1] += $reflected;
    
            $loopMirrorsL[$i + 1] += $mirrorsL[$i] - $reflected; //Light is coming from the left

            $notEnoughLight = false;
        }
        //We consider the light doesn't exist anymore if it's below the threshold
        if($mirrorsR[$i] > THRESHOLD_LIGHT) {
            $reflected = $mirrorsR[$i] * $r[$i];

            if($i == 0) $answer += $mirrorsR[$i] - $reflected; //This light is reflected to the source
            else $loopMirrorsR[$i - 1] += $mirrorsR[$i] - $reflected;
    
            $loopMirrorsL[$i + 1] += $reflected; //Light is coming from the right

            $notEnoughLight = false;
        }
    }

    $mirrorsL = $loopMirrorsL;
    $mirrorsR = $loopMirrorsR;

    ++$turns;
} while($notEnoughLight == false);

error_log("Simulation run for: $turns");

echo number_format($answer, 4) . PHP_EOL;
