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
// $deadCount: number of dead (immovable) cells
fscanf(STDIN, "%d", $deadCount);

for ($i = 0; $i < $deadCount; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    $board[$y + 1][$x + 1] = "#";
}

$listInstructions = [];

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

        $queue = [[implode("", $board), $molecules, []]];
        $history = [];
        $turn = 1;

        while($queue) {
            $newQueue = [];

            error_log("at turn $turn we have " . count($queue));
            
            foreach($queue as $i => [$board, $molecules, $instructions]) {
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

                    error_log(var_export($listInstructions, 1));

                    break 2;
                }

                $history[$board] = 1;

                $moves = getPossibleMoves($board, $molecules);

                // error_log(var_export($moves, 1));

                foreach($moves as $ID => $list) {
                    foreach($list as $d => $IDs) {
                        if($IDs !== null) {
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

                            if(!isset($history[$board2])) {
                                $newQueue[] = [$board2, $molecules2, $instructions + [$turn => [$ID, $d]]];

                                // error_log(var_export(str_split($board2, 9), 1));
                            }
                        }
                    }
                }

                // exit("!!!!!!!!!!");
            }

            $queue = $newQueue;
            ++$turn;
        }
    }

    echo array_shift($listInstructions) . PHP_EOL;

    error_log(microtime(1) - $start);
}
