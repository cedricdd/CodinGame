<?php

function getDecimalDegrees(string $coord): float {
    [$degrees, $minutes, $seconds , ] = preg_split("/[\'\"\°]/", $coord, -1, PREG_SPLIT_NO_EMPTY);

    return $degrees + ($minutes / 60) + ($seconds / 3600);
}

const MISSILE_MAX_ALT = 160;
const MISSILE_ELEVATION = 0.046;
const MISSILE_SPEED = 6;

$missile_latitude = getDecimalDegrees("34°45'21.8\"N");
$missile_longitude = getDecimalDegrees("120°37'34.8\"W");

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $upcomingMission = trim(fgets(STDIN));

    $solution = [0, ""];
    $pos = strpos($upcomingMission, ")");
    $name = substr($upcomingMission, 0, $pos + 1);

    [$latitude, $longitude, $elevation] = explode(" ", substr($upcomingMission, $pos + 2));

    //Convert to Decimal Degrees
    $latitude = getDecimalDegrees($latitude);
    $longitude = getDecimalDegrees($longitude);

    //Get the distances between the missile center and 160Km above the target 
    $latDistance = ($missile_latitude - $latitude) * 111.11;
    $longDistance = ($missile_longitude - $longitude) * 111.11 * cos(($missile_latitude + $latitude) / 2);
    $elevDistance = MISSILE_MAX_ALT - MISSILE_ELEVATION;

    $distance = sqrt($latDistance * $latDistance + $longDistance * $longDistance + $elevDistance * $elevDistance);

    //The time it takes the missile to be above the collector
    $time = $distance / MISSILE_SPEED;

    foreach([["VaCoWM Cleaner", 44.7, 0.85, 3, 1], ["L4nd MoWer", 22.38, 1.2, 10, 6], ["Cow Harvester", 11.19, 1.5, 20, 14]] as [$type, $speed, $efficiency, $maxCows, $minCows]) {
        //Time to collect a cow
        $timePerCow = 500 / (9.81 * $efficiency);

        //Time to escape (ie move up above missile max alt)
        $timeToEscape = (MISSILE_MAX_ALT - ((500 + $elevation) / 1000)) / $speed;

        $timeLeft = $time - $timeToEscape;
        $cows = 0;

        while($timeLeft - $timePerCow > 0) {
            if(++$cows == $maxCows) break;;
            $timeLeft -= $timePerCow;
        }

        //If we can collect enough cows to be profitable & can collect more than current best
        if($cows >= $minCows && $cows > $solution[0]) {
            $solution = [$cows, $type];
        }
    }

    if($solution[0] == 0) echo $name . ": impossible." . PHP_EOL;
    else echo $name . ": possible. Send a " . $solution[1] . " to bring back " . $solution[0] . ($solution[0] > 1 ? " cows." : " cow.") . PHP_EOL;
}
