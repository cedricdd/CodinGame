<?php

//The possible digits based on zone's size
const DIGITS = [1 => 2, 2 => 6, 3 => 14, 4 => 30, 5 => 62, 6 => 126];

function setDigits(array &$result, array &$cells, array $zones): bool {

    global $neighbors, $w, $h;

    do {
        $digitFound = false;

        //Search for position with only one possible didit
        foreach($cells as $index => [&$digits, $zoneID]) {
            switch($digits) {
                case 2:  $digit = 1; break;
                case 4:  $digit = 2; break;
                case 8:  $digit = 3; break;
                case 16: $digit = 4; break;
                case 32: $digit = 5; break;
                case 64: $digit = 6; break;
                default: continue 2; //More than one possible digit for this position
            }

            unset($cells[$index]);
            [$x, $y] = explode(" ", $index);
            $result[$y][$x] = $digit;
            $digitFound = true;
            $mask = 1 << $digit;

            //Neighbors can't use this digit anymore
            foreach($neighbors[$index] as $indexCell) {
                if(!isset($cells[$indexCell])) continue;
                //If we are removing the last possible digit it's an invalid solution
                if(($cells[$indexCell][0] &= ~$mask) == 0) return false;
            }

            //Cells in the same zone can't use this digit anymore
            foreach($zones[$zoneID] as $indexCell) {
                if(!isset($cells[$indexCell])) continue;
                //If we are removing the last possible digit it's an invalid solution
                if(($cells[$indexCell][0] &= ~$mask) == 0) return false;
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

        //Get all the neighbors of this position
        for($y2 = max(0, $y - 1); $y2 < min($h, $y + 2); ++$y2) {
            for($x2 = max(0, $x - 1); $x2 < min($w, $x + 2); ++$x2) {
                if($x == $x2 && $y == $y2) continue;
                $neighbors[$index][] = $x2 . " " . $y2;
            }
        }

        if(isset($cells[$x . " " . $y])) continue;

        $zone = [];
        $toCheck = [[$x, $y, $grid[$y][$x][0]]];

        //Find all the cells sharing the same zone
        while(count($toCheck)) {
            [$cellX, $cellY, $zoneLetter] = array_pop($toCheck);
            [$letter, $digit] = str_split($grid[$cellY][$cellX]);

            if($letter != $zoneLetter) continue;
            if(isset($cells[$cellX . " " . $cellY])) continue;
            
            $zone[] = $cellX . " " . $cellY;
            $cells[$cellX . " " . $cellY] = [(($digit != 0) ? (1 << $digit) : 0), $zoneIndex];

            foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
                $xu = $cellX + $xm;
                $yu = $cellY + $ym;

                if($xu >= 0 && $xu < $w && $yu >= 0 && $yu < $h) $toCheck[] = [$xu, $yu, $zoneLetter];
            }
        }

        $digits = DIGITS[count($zone)];

        //If the digit is not given, set all the possible digits for each positions
        foreach($zone as $index) {
            if($cells[$index][0] == 0) $cells[$index][0] = $digits;
        }

        $zones[$zoneIndex++] = $zone;
    }
}

function solve(array $result, array $cells): void {

    global $zones, $start;

    $valid = setDigits($result, $cells, $zones);

    if($valid == false) return;
    //The grid is valid and we have a digit for each cells
    elseif(count($cells) == 0) {
        echo implode("\n", $result) . PHP_EOL;
        error_log(var_export(microtime(1) - $start, true));
        exit(); //There is only one solution
    }

    //We have to guess a digit, we use the first cell with multiple possibilities
    $index = array_key_first($cells);
    [$digits, $zoneID] = $cells[$index];

    for($i = 6; $i > 0; --$i) {
        //If this digit is possible for the cell, we try it
        if($digits & 1 << $i) {
            $cells[$index][0] = 1 << $i;

            solve($result, $cells);
        }
    }
}

solve($result, $cells);
