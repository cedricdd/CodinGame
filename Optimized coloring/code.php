<?php

function solve(int $count, array $colors, int $vertices, bool $test = false): int {
    global $adjacent;
    static $history = [];

    $hash = serialize($colors);

    if(isset($history[$hash])) {
        // error_log("using history");
        return $history[$hash];
    }

    // error_log($hash);

    if($vertices == $count) return max($colors);

    $min = INF;

    for($i = 0; $i < $count; ++$i) {
        if($colors[$i] != 0) continue;

        //Working on vertex $i
        $possibleColors = array_fill(1, $count + 1, 1);

        foreach(($adjacent[$i] ?? []) as $neighbor => $filler) {
            unset($possibleColors[$colors[$neighbor]]);
        }

        $color = array_key_first($possibleColors);

        // if($test) error_log("using $color for $i");

        $colors[$i] = $color;

        $test2 = solve($count, $colors, $vertices + 1);

        // if($test) error_log($test2);

        $min = min($min, $test2);

        if($min == 2) break;

        $colors[$i] = 0;
    }

    return $history[$hash] = $min;
}

$start = microtime(1);

fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $h);
for ($i = 0; $i < $h; $i++){
    $line = trim(fgets(STDIN));

    error_log($line);

    $sheet[] = str_split($line);
}

$zoneIndex = 0;

//Assign a zone ID to each blank space
for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        if($sheet[$y][$x] != ' ' || isset($zone[$y][$x])) continue;

        $toCheck = [[$x, $y]];

        while($toCheck) {
            [$x2, $y2] = array_pop($toCheck);

            if(isset($zone[$y2][$x2])) continue;

            $zone[$y2][$x2] = $zoneIndex;

            foreach([[1, 0], [-1, 0], [0, 1], [0, -1]] as [$xm, $ym]) {
                $x3 = $x2 + $xm;
                $y3 = $y2 + $ym;

                if(($sheet[$y3][$x3] ?? '*') == ' ') $toCheck[] = [$x3, $y3];
            }
        }

        ++$zoneIndex;
    }
}

$nbrColors = 1;
$adjacent = [];

//For each characters that can be a seperator between zones, check how many zones we have.
for($y = 1; $y < $h - 1; ++$y) {
    for($x = 1; $x < $w - 1; ++$x) {
        if($sheet[$y][$x] != ' ') {
            if($x > 1 && $x < $w - 2) {
                if($sheet[$y][$x - 1] == ' ' && $sheet[$y][$x + 1] == ' ') {
                    $z1 = $zone[$y][$x - 1];
                    $z2 = $zone[$y][$x + 1];

                    if($z1 != $z2) {
                        $adjacent[$z1][$z2] = 1;
                        $adjacent[$z2][$z1] = 1;
                    }
                }
            }
            if($y > 1 && $y < $h - 1) {
                if($sheet[$y - 1][$x] == ' ' && $sheet[$y + 1][$x] == ' ') {
                    $z1 = $zone[$y - 1][$x];
                    $z2 = $zone[$y + 1][$x];

                    if($z1 != $z2) {
                        $adjacent[$z1][$z2] = 1;
                        $adjacent[$z2][$z1] = 1;
                    }
                }  
            }
        }
    }
}

// error_log(var_export($adjacent[49], 1));

if($zoneIndex == 0) echo "1" . PHP_EOL;
else echo solve($zoneIndex, array_fill(0, $zoneIndex, 0), 0, 1) . PHP_EOL;

error_log(microtime(1) - $start);
