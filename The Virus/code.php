<?php

const MOVES = ['L' => -1, 'R' => 1, 'U' => -8, 'D' => 8];

function checkMoves(array &$molecules, int $ID, string $d, array $skip): ?array {
    global $possibleMoves;

    [$mPosHash, $mIndex] = $molecules[$ID];

    //This molecule can't move in that direction
    if(!isset($possibleMoves[$ID][$mIndex][$d])) return null;

    [$mPosHash2, $mIndex2] = $possibleMoves[$ID][$mIndex][$d];

    //The new index & positions occupied after the move
    $movedMolecules = [$ID => [$mPosHash2, $mIndex2]];

    foreach($molecules as $moleculeID => [$posHash, $index]) {
        if(isset($skip[$moleculeID])) continue; //Don't check conflict with that molecule

        // We need to check if we can also move that molecule
        if($mPosHash2 & $posHash) {
            $partial = checkMoves($molecules, $moleculeID, $d, $skip + [$moleculeID => 1]);

            if($partial === null) return null; //The move is not possible
            else $movedMolecules += $partial;
        }
    }

    return $movedMolecules;
}

$board = [
    "####.###",
    "###...##",
    "##.....#",
    "........",
    "##.....#",
    "###...##",
    "####.###",
];

fscanf(STDIN, "%d", $maxTurns);

error_log("Max Turns: $maxTurns");

fscanf(STDIN, "%d", $deadCount);

for ($i = 0; $i < $deadCount; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    $board[$y][$x + 1] = "#";
}

$listInstructions = [];
$gameTurn = 0;
$possibleMoves = [];
$molecules = [];
$moleculePositions = [];
$types = [];
$typeID = 1;
$typeInfos = [];

while (TRUE) {
    // $cellCount: number of cells currently occupied by molecules
    fscanf(STDIN, "%d", $cellCount);

    $start = microtime(1);

    for ($i = 0; $i < $cellCount; $i++) {
        fscanf(STDIN, "%d %d %d", $moleculeId, $x, $y);

        // It's the first turn, generate the instructions
        if(!$listInstructions) {
            $index = $y * 8 + ($x + 1);
            $moleculePositions[$moleculeId][$index] = [$x, $y];

            if(!isset($molecules[$moleculeId])) $molecules[$moleculeId] = [0, ""];

            $molecules[$moleculeId][0] |= (2 ** $index);
        }
    }

    if(!$listInstructions) {
        $boardHash = implode("", $board);

        foreach($moleculePositions as $ID => $positions) {
            $startPosition = min(array_keys($positions));

            $molecules[$ID][1] = str_pad(strval($startPosition), 2, '0', STR_PAD_LEFT);

            $hash[$ID * 3] = $molecules[$ID][1][0];
            $hash[$ID * 3 + 1] = $molecules[$ID][1][1];

            [$xm, $ym] = $positions[$startPosition];

            // Get the info based off the position of the molecule, we use the first top-left position occupied by the molecule 
            array_walk($moleculePositions[$ID], function(array &$position, int $index) use ($xm, $ym, $startPosition) {
                $position[0] -= $xm;
                $position[1] -= $ym;
                $position[2] = $index - $startPosition;
            });

            // For the board hash we use the same value for 'similar' molecules as interchanging them would produce the same results
            $hashType = implode("-", array_column($moleculePositions[$ID], 2));

            if(!isset($types[$hashType])) $type = $types[$hashType] = $typeID++;
            else $type = $types[$hashType];
            
            $typeInfos[$ID] = $type;

            foreach($moleculePositions[$ID] as [, , $shift]) $boardHash[$startPosition + $shift] = $type;

            /**
             * For each positions we check if the molecule can 'start' there and check in which direction if can move while it's there.
             */
            for($index = 0, $y = 0; $y < 6; ++$y) {
                for($x = 0; $x < 8; ++$x, ++$index) {
                    if($board[$y][$x] == '.') {
                        //Can the molecule 'start' at the current position
                        foreach($moleculePositions[$ID] as [$xm, $ym]) {
                            $xu = $x + $xm;
                            $yu = $y + $ym;

                            if($xu < 0 || $xu > 7 || $yu < 0 || $yu > 6 || $board[$yu][$xu] != '.') continue 2; //There's a conflict
                        }

                        //Check the 4 directions to move the molecule
                        foreach(['L' => [-1, 0], 'R' => [1, 0], 'U' => [0, -1], 'D' => [0, 1]] as $direction => [$xm1, $ym1]) {
                            $hashMove = 0;

                            foreach($moleculePositions[$ID] as [$xm2, $ym2]) {
                                $xu = $x + $xm1 + $xm2;
                                $yu = $y + $ym1 + $ym2;

                                if($xu < 0 || $xu > 7 || $yu < 0 || $yu > 6 || $board[$yu][$xu] != '.') continue 2; //There's a conflict

                                $hashMove |= (2 ** ($yu * 8 + $xu));
                            }

                            $possibleMoves[$ID][str_pad(strval($index), 2, '0', STR_PAD_LEFT)][$direction] = [$hashMove, str_pad(strval($index + MOVES[$direction]), 2, '0', STR_PAD_LEFT)];
                        }
                    }
                }
            }
        }

        $queue = [[$molecules, $boardHash, []]];
        $turn = 0;

        while($queue) {
            $newQueue = [];

            error_log("Count Step $turn: " . count($queue));

            foreach($queue as $queueID => [$molecules, $boardHash, $instructions]) {

                //The virus was moved to the exit
                if($molecules[0][1] === "24") {
                    $listInstructions = [];

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

                    break 2;
                }

                if(isset($history[$boardHash])) continue; //We have already reached this configuration
                else $history[$boardHash] = 1;

                foreach($molecules as $ID => [, $index]) {
                    foreach(($possibleMoves[$ID][$index] ?? []) as $d => [, $indexMoved]) {
                        $movedMolecules = checkMoves($molecules, $ID, $d, [$ID => 1]);

                        //We can do that move
                        if($movedMolecules !== null) {
                            $boardHashMoved = $boardHash;

                            //Remove all the positions that were occupied by the molecules that are moving this turn
                            foreach($movedMolecules as $movedID => [, $movedIndex]) {
                                $currentIndex = $molecules[$movedID][1];

                                foreach($moleculePositions[$movedID] as [, , $shift]) $boardHashMoved[$currentIndex + $shift] = '.';
                            }

                            //Set all the position that will be occupied by the molecules after the move
                            foreach($movedMolecules as $movedID => [, $movedIndex]) {
                                foreach($moleculePositions[$movedID] as [, , $shift]) $boardHashMoved[$movedIndex + $shift] = $typeInfos[$movedID];
                            }

                            $newQueue[] = [$movedMolecules + $molecules, $boardHashMoved, $instructions + [$turn => [$ID, $d]]];
                        }
                    }
                }
            }

            $queue = $newQueue;
            ++$turn;
        }
    }

    echo $listInstructions[$gameTurn++] . PHP_EOL;

    error_log(microtime(1) - $start);
}
