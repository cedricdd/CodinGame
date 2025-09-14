<?php

const MOVES = ['L' => -1, 'R' => 1, 'U' => -9, 'D' => 9];

function checkMoves(string $board, array $molecules, int $ID, string $d, array &$moves, array $skip = []): ?array {
    // error_log("checking $ID with $d");

    $IDs = [$ID => 1];

    foreach($molecules[$ID] as $position) {
        $c = $board[$position + MOVES[$d]];

        // error_log("Checking " . ($position + MOVES[$d]) . " for $position with $d");

        if($c == '#') return $moves[$ID][$d] = null;

        //We need to push another molecule
        if($c != '.' && $c != $ID && !isset($skip[$c])) {
            if(!isset($moves[$c][$d])) checkMoves($board, $molecules, $c, $d, $moves, $skip + [$ID => 1]);

            if($moves[$c][$d] === null) return $moves[$ID][$d] = null;

            $IDs += $moves[$c][$d];
        }
    }

    return $moves[$ID][$d] = $IDs;
}

function getPossibleMoves(string $board, array $molecules): array {
    $moves = [];

    foreach($molecules as $ID => $filler) {
        foreach(['L', 'R', 'U', 'D'] as $d) {
            if(!isset($moves[$ID][$d])) checkMoves($board, $molecules, $ID, $d, $moves);
        }
    }

    return $moves;
}

    // 0 => '0 LEFT',
    // 1 => '7 LEFT',
    // 2 => '7 DOWN',
    // 3 => '6 RIGHT',
    // 4 => '7 DOWN',
    // 5 => '6 RIGHT',
    // 6 => '6 RIGHT',
    // 7 => '7 UP',
    // 8 => '0 RIGHT',
    // 9 => '7 LEFT',
    // 10 => '7 LEFT',
    // 11 => '0 UP',
    // 12 => '0 UP',
    // 13 => '7 RIGHT',
    // 14 => '7 DOWN',
    // 15 => '0 LEFT',
    // 16 => '0 LEFT',
    // 17 => '0 LEFT',
    // 18 => '0 LEFT',

function solve(string $board, array $molecules, array $instructions = [], int $turn = 0) {
    global $maxTurns, $listInstructions;
    static $history = [];

    // if(count($instructions) == 2 && $instructions[0] == [0, 'L'] && $instructions[1] == [7, 'L']) exit("So far so good!");

    // $hash = implode("-", array_map(function($instruction) {
    //     return $instruction[0] . " " . $instruction[1];
    // }, $instructions));

    // if($hash == "0 L") {
    //     // error_log(var_export($history, 1));
    //     // exit();
    // }

    if($listInstructions) return;

    if($turn > $maxTurns) return;

    if($board[36] === '0') {
        // error_log(var_export($instructions, 1));
        
        foreach($instructions as [$ID, $d]) {
            switch($d) {
                case 'L': $direction = 'LEFT'; break;
                case 'R': $direction = 'RIGHT'; break;
                case 'U': $direction = 'UP'; break;
                case 'D': $direction = 'DOWN'; break;
                default: exit("Invalid Direction");
            }

            $listInstructions[] = "$ID $direction";
        }

        // error_log(var_export($listInstructions, 1));
        return;
    }

    if(isset($history[$board]) && $history[$board] <= $turn) {
        // error_log("$turn - " . $history[$board] . " - " . $board);
        return;
    }
    else $history[$board] = $turn;

    $moves = getPossibleMoves($board, $molecules);

    // $debug = false;

    // if($hash == "0 L") {
    //     // error_log(var_export($moves, 1));
    //     // exit();

    //     // $debug = true;
    // }

    // error_log(var_export($moves, 1));

    foreach($moves as $ID => $list) {
        foreach($list as $d => $IDs) {
            if($IDs !== null) {
                // if($debug) error_log("Testing $d for $ID");

                $board2 = $board;
                $molecules2 = $molecules;

                // Set all the positions that are going to move to un-occupied
                foreach($IDs as $IDtoMove => $filler) {
                    foreach($molecules[$IDtoMove] as $position) {
                        $board2[$position] = '.';
                    }
                }

                // Set all the positions that are now occupied to the proper value
                foreach($IDs as $IDtoMove => $filler) {
                    $molecules2[$IDtoMove] = [];

                    foreach($molecules[$IDtoMove] as $position) {
                        $newPosition = $position + MOVES[$d];

                        $board2[$newPosition] = $IDtoMove;

                        $molecules2[$IDtoMove][] = $newPosition;
                    }
                }

                // if($debug) error_log(var_export(str_split($board2, 9), 1));

                solve($board2, $molecules2, $instructions + [$turn => [$ID, $d]], $turn + 1);
            }
        }
    }
}

$board = [
    "#########",
    "####.####",
    "###...###",
    "##.....##",
    "........#",
    "##.....##",
    "###...###",
    "####.####",
    "#########",
];

fscanf(STDIN, "%d", $maxTurns);

error_log("Max Turns: $maxTurns");

// $deadCount: number of dead (immovable) cells
fscanf(STDIN, "%d", $deadCount);

for ($i = 0; $i < $deadCount; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    $board[$y + 1][$x + 1] = "#";
}

$listInstructions = [];
$turn = 0;

while (TRUE) {
    // $cellCount: number of cells currently occupied by molecules
    fscanf(STDIN, "%d", $cellCount);

    $start = microtime(1);

    for ($i = 0; $i < $cellCount; $i++) {
        fscanf(STDIN, "%d %d %d", $moleculeId, $x, $y);

        if(!$listInstructions) {
            $molecules[$moleculeId][] = ($y + 1) * 9 + ($x + 1);
            $board[$y + 1][$x + 1] = $moleculeId;
        }
    }

    if(!$listInstructions) {
        error_log(var_export($board, 1));
        // error_log(var_export($molecules, 1));

        solve(implode("", $board), $molecules);

        error_log(var_export($listInstructions, 1));
    }

    echo $listInstructions[$turn++] . PHP_EOL;

    error_log(microtime(1) - $start);
}
