<?php

fscanf(STDIN, "%s %d %d %d %d", $name0, $hp0, $blows0, $toHit0, $damage0);
fscanf(STDIN, "%s %d %d %d %d", $name1, $hp1, $blows1, $toHit1, $damage1);

$toHit0 /= 100;
$toHit1 /= 100;

$toCheck = [[1.0, $hp0, $blows0, $hp1, $blows1]];

$turn = 1;
$death0 = 0.0;
$death1 = 0.0;

while($toCheck) {
    $newCheck = [];

    foreach($toCheck as [$percentage, $hp0, $blows0, $hp1, $blows1]) {
        //Attacker turn
        if(($turn & 1 || !$blows1) && $blows0) {
            //Attack works & defender dies
            if($damage0 >= $hp1) $death1 += $percentage * $toHit0;
            //Attack works & defender is still alive
            else $newCheck[] = [$percentage * $toHit0, $hp0, $blows0 - 1, $hp1 - $damage0, $blows1];

            //Attack fails
            $newCheck[] = [$percentage * (1 - $toHit0), $hp0, $blows0 - 1, $hp1, $blows1];
        } //Defender turn
        elseif($blows1) {
            //Attack works & attacker dies
            if($damage1 >= $hp0) $death0 += $percentage * $toHit1;
            //Attack works & attacker is still alive
            else $newCheck[] = [$percentage * $toHit1, $hp0 - $damage1, $blows0, $hp1, $blows1 - 1];

            //Attack fails
            $newCheck[] = [$percentage * (1 - $toHit1), $hp0, $blows0, $hp1, $blows1 - 1];
        }
    }

    ++$turn;
    $toCheck = $newCheck;
}

echo round($death0 * 100, 0) . " " . round($death1 * 100, 0) . PHP_EOL;
