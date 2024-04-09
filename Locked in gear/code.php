<?php

$start = microtime(1);

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d %d", $x, $y, $r);

    $gears[] = [$x, $y, $r];

    //Find all the gears this gear is connected too
    foreach($gears as $j => [$gx, $gy, $gr]) {
        $distance = sqrt(pow($x - $gx, 2) + pow($y - $gy, 2));

        if($r + $gr == $distance) {
            $affected[$i][] = $j;
            $affected[$j][] = $i;
        }
    }
}

$gears[0][3] = "CW";
$toCheck = [0];
$history = [];

while($toCheck) {
    $newCheck = [];

    foreach($toCheck as $gearID) {
        if(isset($history[$gearID])) continue; //We already checked this gear
        else $history[$gearID] = 1;

        $direction = $gears[$gearID][3] == "CW" ? "CCW" : "CW";

        foreach(($affected[$gearID] ?? []) as $gearID2) {
            //If we have already a direction for this gear and it's not the same, everything is blocked
            if(isset($gears[$gearID2][3]) && $gears[$gearID2][3] != $direction) exit("NOT MOVING");

            $gears[$gearID2][3] = $direction;

            $newCheck[] = $gearID2;
        }
    }

    $toCheck = $newCheck;
}

echo ($gears[$N - 1][3] ?? "NOT MOVING") . PHP_EOL;

error_log(microtime(1) - $start);
