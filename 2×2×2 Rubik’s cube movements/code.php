<?php

$cube = [
    "##UU##",
    "##UU##",
    "LLFFRR",
    "LLFFRR",
    "##DD##",
    "##DD##",
    "##BB##",
    "##BB##",
];

const MOVES = [
    'U' => ["0;2" => "1;2", "0;3" => "0;2", "1;2" => "1;3", "1;3" => "0;3", "2;0" => "2;2", "2;1" => "2;3", "2;2" => "2;4", "2;3" => "2;5", "2;4" => "7;3", "2;5" => "7;2", "7;3" => "2;0", "7;2" => "2;1"],
    'R' => ["2;4" => "3;4", "2;5" => "2;4", "3;4" => "3;5", "3;5" => "2;5", "0;3" => "2;3", "1;3" => "3;3", "2;3" => "4;3", "3;3" => "5;3", "4;3" => "6;3", "5;3" => "7;3", "6;3" => "0;3", "7;3" => "1;3"],
    'F' => ["2;2" => "3;2", "2;3" => "2;2", "3;2" => "3;3", "3;3" => "2;3", "1;2" => "3;1", "1;3" => "2;1", "2;4" => "1;2", "3;4" => "1;3", "4;3" => "2;4", "4;2" => "3;4", "3;1" => "4;3", "2;1" => "4;2"],
    'L' => ["2;0" => "3;0", "2;1" => "2;0", "3;0" => "3;1", "3;1" => "2;1", "0;2" => "6;2", "1;2" => "7;2", "2;2" => "0;2", "3;2" => "1;2", "4;2" => "2;2", "5;2" => "3;2", "6;2" => "4;2", "7;2" => "5;2"],
    'D' => ["4;2" => "5;2", "4;3" => "4;2", "5;2" => "5;3", "5;3" => "4;3", "3;0" => "6;3", "3;1" => "6;2", "3;2" => "3;0", "3;3" => "3;1", "3;4" => "3;2", "3;5" => "3;3", "6;3" => "3;4", "6;2" => "3;5"],
    'B' => ["6;2" => "7;2", "6;3" => "6;2", "7;2" => "7;3", "7;3" => "6;3", "5;2" => "2;0", "5;3" => "3;0", "3;5" => "5;2", "2;5" => "5;3", "0;3" => "3;5", "0;2" => "2;5", "2;0" => "0;3", "3;0" => "0;2"],
];

function rotate(array $cube, array $moves): array {
    $rotated = $cube;

    foreach($moves as $a => $b) {
        [$y1, $x1] = explode(";", $a);
        [$y2, $x2] = explode(";", $b);

        $rotated[$y1][$x1] = $cube[$y2][$x2];
    }

    return $rotated;
}

fscanf(STDIN, "%s", $moves);

error_log($moves);

preg_match_all("/([FRBLUD](?:\')?)([0-9]*)/", $moves, $matches);

foreach($matches[1] as $i => $direction) {
    $count = intval($matches[2][$i]) ?: 1;

    for($i = 0; $i < $count; ++$i) {
        switch($direction) {
            case "F": $cube = rotate($cube, MOVES['F']); break;
            case "F'": $cube = rotate($cube, array_flip(MOVES['F'])); break;
            case "L": $cube = rotate($cube, MOVES['L']); break;
            case "L'": $cube = rotate($cube, array_flip(MOVES['L'])); break;
            case "R": $cube = rotate($cube, MOVES['R']); break;
            case "R'": $cube = rotate($cube, array_flip(MOVES['R'])); break;
            case "U": $cube = rotate($cube, MOVES['U']); break;
            case "U'": $cube = rotate($cube, array_flip(MOVES['U'])); break;
            case "D": $cube = rotate($cube, MOVES['D']); break;
            case "D'": $cube = rotate($cube, array_flip(MOVES['D'])); break;
            case "B": $cube = rotate($cube, MOVES['B']); break;
            case "B'": $cube = rotate($cube, array_flip(MOVES['B'])); break;
            default: exit("Unknown Move");
        }
    }
}

foreach($cube as $line) error_log($line);

echo $cube[2][2] . $cube[2][3] . PHP_EOL;
echo $cube[3][2] . $cube[3][3] . PHP_EOL;
