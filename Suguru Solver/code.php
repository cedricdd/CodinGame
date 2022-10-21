<?php

function setDigits(array &$result, array &$cells, array $zones): bool {

    global $neighbors, $w, $h;

    do {
        $digitFound = false;

        foreach($cells as $index => [&$digits, $zoneID]) {
            if(count($digits) == 0) return false;
            elseif(count($digits) == 1) {
                $digit = array_key_first($digits);
                unset($cells[$index]);
                [$x, $y] = explode(" ", $index);
                $result[$y][$x] = $digit;
                $digitFound = true;

                foreach($neighbors[$index] as $indexCell) unset($cells[$indexCell][0][$digit]);

                foreach($zones[$zoneID] as $indexCell) unset($cells[$indexCell][0][$digit]);
            }
        }


    } while($digitFound);

    return true;
}

$start = microtime(1);

fscanf(STDIN, "%d %d", $w, $h);

$result = array_fill(0, $h, str_repeat("0", $w));

for ($i = 0; $i < $h; $i++) {
    $grid[] = explode(" ", trim(fgets(STDIN)));
}

$cells = [];
$zones = [];
$zoneIndex = 0;

//Find all the zones
for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {

        $index = $x . " " . $y;

        for($y2 = max(0, $y - 1); $y2 < min($h, $y + 2); ++$y2) {
            for($x2 = max(0, $x - 1); $x2 < min($w, $x + 2); ++$x2) {
                if($x == $x2 && $y == $y2) continue;
                $neighbors[$index][] = $x2 . " " . $y2;
            }
        }

        if(isset($cells[$x . " " . $y])) continue;

        $zone = [];
        $toCheck = [[$x, $y, $grid[$y][$x][0]]];

        while(count($toCheck)) {
            [$cellX, $cellY, $zoneLetter] = array_pop($toCheck);
            [$letter, $digit] = str_split($grid[$cellY][$cellX]);

            if($letter != $zoneLetter) continue;
            if(isset($cells[$cellX . " " . $cellY])) continue;
            
            $zone[] = $cellX . " " . $cellY;

            if($digit != 0) $cells[$cellX . " " . $cellY] = [[$digit => 1], $zoneIndex];
            else $cells[$cellX . " " . $cellY] = [[], $zoneIndex];

            foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
                $xu = $cellX + $xm;
                $yu = $cellY + $ym;

                if($xu >= 0 && $xu < $w && $yu >= 0 && $yu < $h) $toCheck[] = [$xu, $yu, $zoneLetter];
            }
        }

        $digits = array_flip(range(1, count($zone)));

        foreach($zone as $index) {
            if(count($cells[$index][0]) == 0) $cells[$index][0] = $digits;
        }

        $zones[$zoneIndex++] = $zone;
    }
}

error_log(var_export(microtime(1) - $start, true));

$backup = [];

function solve(array $result, array $cells, array $zones): void {

    global $zones, $start;

    //error_log(var_export(count($cells) . " left to find", true));

    $valid = setDigits($result, $cells, $zones);

    if($valid == true && count($cells) == 0) {
        echo implode("\n", $result) . PHP_EOL;
        error_log(var_export(microtime(1) - $start, true));
        exit();
    } elseif($valid == false) return;

    $index = array_key_first($cells);
    $digits = $cells[$index][0];

    foreach(array_reverse($digits, true) as $digit => $filler) {
        $cells[$index][0] = [$digit => 1];

        //error_log(var_export("guess $digit for $index", true));

        solve($result, $cells, $zones);
    }
}

solve($result, $cells, $zones);
