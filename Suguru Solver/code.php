<?php

function setDigits(array &$result, array &$cells, array $zones): bool {

    do {
        $digitFound = false;

        foreach($cells as $index => [&$digits, $zoneID]) {
            if(count($digits) == 0) return false;
            elseif(count($digits) == 1) {
                $digit = array_key_first($digits);
                unset($cells[$index]);
                [$xp, $yp] = explode(" ", $index);
                $result[$yp][$xp] = $digit;
                $digitFound = true;

                for($y = $yp - 1; $y < $yp + 2; ++$y) {
                    for($x = $xp - 1; $x < $xp + 2; ++$x) {
                        unset($cells[$x . " " . $y][0][$digit]);
                    }
                }

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

while(true) {

    while(true) {
        $valid = setDigits($result, $cells, $zones);

        if($valid == true) {
            if(count($cells) == 0) break 2;
            else break;
        } else [$result, $cells] = array_pop($backup);
    }

    while(true) {
        $index = array_key_first($cells);
        $digits = $cells[$index][0];
    
        if(count($digits) == 0) [$result, $cells] = array_pop($backup);
        else {
            $guess = array_key_first($digits);

            unset($cells[$index][0][$guess]);

            $backup[] = [$result, $cells];

            $cells[$index][0] = [$guess => 1];

            break;
        }
    }

}

echo implode("\n", $result) . PHP_EOL;

error_log(var_export(microtime(1) - $start, true));
