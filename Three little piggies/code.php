<?php

const HOUSES = [
    0 => [
        [[0, 0], [1, 0], [0, 1]],
        [[0, 0], [-1, 0], [0, 1]],
        [[0, 0], [-1, 0], [0, -1]],
        [[0, 0], [0, -1], [1, 0]],
    ],
    1 => [
        [[0, 0], [-1, 0], [1, 0]],
        [[0, 0], [0, -1], [0, 1]],
    ],
    2 => [
        [[0, 0], [1, 0], [2, 0], [0, 1]],
        [[0, 0], [-1, 0], [0, 1], [0, 2]],
        [[0, 0], [0, -1], [-1, 0], [-2, 0]],
        [[0, 0], [1, 0], [0, -1], [0, -2]],
    ],
];

const CHARACTERS = ["Hss", "HSS", "HBBB"];

// Place the houses so that the pigs can be seen.
function solveDay(array $field, array $houses) {
    if(array_sum($houses) == 0) exit(implode(PHP_EOL, array_map("implode", $field)));

    for($y = 0; $y < 4; ++$y) {
        for($x = 0; $x < 4; ++$x) {
            if($field[$y][$x] == 'X') {
                foreach($houses as $ID => $needed) {
                    if(!$needed) continue;

                    foreach(HOUSES[$ID] as $positions) {
                        $field2 = $field;

                        foreach($positions as $i => [$xm, $ym]) {
                            if(($field[$y + $ym][$x + $xm] ?? '.') != 'X') continue 2;

                            $field2[$y + $ym][$x + $xm] = CHARACTERS[$ID][$i];
                        }

                        solveDay($field2, [$ID => 0] + $houses);
                    }
                }
            }
        }
    }
}

// Place the houses so that each pig is covered by an H.
function solveNight(array $field, array $pigs, array $houses) {
    if($pigs) {
        [$x, $y] = array_pop($pigs);
        $field[$y][$x] = 'X';

        foreach($houses as $ID => $needed) {
            if(!$needed) continue;

            foreach(HOUSES[$ID] as $positions) {
                $field2 = $field;

                foreach($positions as $i => [$xm, $ym]) {
                    if(($field[$y + $ym][$x + $xm] ?? '.') != 'X') continue 2;

                    $field2[$y + $ym][$x + $xm] = CHARACTERS[$ID][$i];
                }

                solveNight($field2, $pigs, [$ID => 0] + $houses);
            }
        }
    } else solveDay($field, $houses);
}

$pigs = [];
$wolf = false;

for ($y = 0; $y < 4; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        $field[$y][$x] = $c;

        if($c == 'W') $wolf = true;
        if($c == 'P') $pigs[] = [$x, $y];
    }
}

if(!$wolf) solveDay($field, [1, 1, 1]);
else solveNight($field, $pigs, [1, 1, 1]);
