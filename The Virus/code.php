<?php

const MOVES = ['L' => -1, 'R' => 1, 'U' => -9, 'D' => 9];

function checkMoves(string $board, array $molecules, int $ID, string $d, array $skip = [], bool $debug = false): array {
    $IDs = [$ID => 1];

    foreach($molecules[$ID] as $position) {
        $c = $board[$position + MOVES[$d]];

        if($c == '#') return [];

        //We need to push another molecule
        if($c != '.' && $c != $ID) {
            if(isset($skip[$c])) $IDs += [$c => 1];
            else {
                $partial = checkMoves($board, $molecules, $c, $d, $skip + [$ID => 1], $debug);

                if(!$partial) return [];

                $IDs += $partial;
            }
        }
    }

    return $IDs;
}

function getPossibleMoves(string $board, array $molecules, bool $debug = false): array {
    $moves = [];

    foreach($molecules as $ID => $filler) {
        foreach(['L', 'R', 'U', 'D'] as $d) {
            $moves[$ID][$d] = checkMoves($board, $molecules, $ID, $d, [], $debug);
        }
    }

    return $moves;
}

function solve(string $board, array $molecules, array $instructions = [], int $turn = 0) {
    global $maxTurns, $listInstructions, $listCount;
    static $history = [];

    if($listCount <= $turn) return;

    if($turn > $maxTurns) return;

    if($board[36] === '1') {
        $listInstructions = [];
        $listCount = 0;//$turn;
        
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

        return;
    }

    if(isset($history[$board]) && $history[$board] <= $turn) return;
    else $history[$board] = $turn;

    $moves = getPossibleMoves($board, $molecules, $turn == 1);

    foreach($moves as $ID => $list) {
        foreach($list as $d => $IDs) {
            if($IDs) {
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

                solve($board2, $molecules2, $instructions + [$turn => [$ID - 1, $d]], $turn + 1);
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
$listCount = INF;
$turn = 0;

while (TRUE) {
    // $cellCount: number of cells currently occupied by molecules
    fscanf(STDIN, "%d", $cellCount);

    $start = microtime(1);

    for ($i = 0; $i < $cellCount; $i++) {
        fscanf(STDIN, "%d %d %d", $moleculeId, $x, $y);

        $moleculeId++; //We don't want to handle '0 as string

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
