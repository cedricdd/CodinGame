<?php

//Check if we can reach the border of the grid from a starting position (cardinal + diagonal moves)
function canReachBorder(string $grid, int $start, array &$isLinkedToBorder): bool {
    global $neighborsV;

    $toCheck = [$start];
    $visited = [];

    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as $position) {
            
            //We can reach the border
            if(isset($isLinkedToBorder[$position]) || $grid[$position] == "#") {
                $isLinkedToBorder += $visited; //Everything we have visited is linked to a border, save for later use

                return true;
            }
            //We can't move here, only digits that are un-visited
            elseif(isset($visited[$position]) || !ctype_digit($grid[$position])) continue;
            else $visited[$position] = 1;

            //We can potentially move to the 8 adjacents positions
            foreach($neighborsV[$position] as $neighbor) {
                $newCheck[] = $neighbor;
            }
        }

        $toCheck = $newCheck;
    }

    return false;
}

//Check if all the water is forming a continuous shape
function checkContinuousWater(string $grid): bool {
    global $totalWater, $neighborsC;

    $startPosition = strpos($grid, "~");
    $toCheck = [$startPosition];
    $count = 0;
    $list = [];

    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as $position) {
            if(isset($list[$position])) continue;
            else $list[$position] = 1;

            if(++$count >= $totalWater) return true; //We count all the "." or "~" we can reach

            foreach($neighborsC[$position] as $neighbor) {
                if(!ctype_digit($grid[$neighbor])) $newCheck[] = $neighbor;
            }
        }

        $toCheck = $newCheck;
    }

    return false;
}

//There are no water areas of 2x2 so we need a part of an island in at least one of the 4 positions
function checkSquareWater(string &$grid, array &$positions, array &$possibleIslands, int $size) {

    do {

        $possibilitesReduced = false;

        preg_match_all("/[~\.](?=[~\.].{" . $size . "}[~\.][~\.])/", $grid, $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as [, $position]) {
            //if($debug) error_log("working on position: $position");

            $candidatesIslands = [];

            foreach([0, 1, $size + 2, $size + 3] as $shift) {
                if(!isset($positions[$position + $shift])) continue;

                $candidatesIslands += $positions[$position + $shift];
            }

            //First we need to check if only islands from the same clue can reach all the positions
            if(count(array_unique($candidatesIslands)) == 1) {

                $clueIndex = reset($candidatesIslands);

                //Every possible islands that's not in the candidate list can be elimnated
                foreach(array_diff_key($possibleIslands[$clueIndex], $candidatesIslands) as $islandIndex => $filler) {
                    //if($debug) error_log(var_export("need to remove $islandIndex", true));
                    removedPossibleIsland($possibleIslands, $positions, $clueIndex, $islandIndex);

                    $possibilitesReduced = true;
                }
            }
        }

    } while($possibilitesReduced);
}

//Generate all the possible island based on the clue
function generateIslands(int $startPosition, int $count, string $grid): array {

    global $neighborsC, $W;

    $islandIndex = str_repeat("0", ($W + 2) * ($W + 2));
    $islandIndex[$startPosition] = 1;

    $islands = [$islandIndex => [$startPosition => 1]];
    $forbidden = [];
    $allowed = [];

    for($i = 1; $i < $count; ++$i) {
        $updatedIslands = [];

        foreach($islands as $islandIndex => $islandPositions) {
            foreach($islandPositions as $position => $filler) {
                foreach($neighborsC[$position] as $neighbor) {
                    //We can't expand the island on this position
                    if(isset($forbidden[$neighbor]) || isset($islandPositions[$neighbor])) continue; 

                    //This position is water of another clue
                    if($grid[$neighbor] != ".") {
                        $forbidden[$neighbor] = 1;
                        continue; 
                    }

                    if(!isset($allowed[$neighbor])) {
                        //Make sure this position is not horizontally and vertically adjacent to another clue 
                        foreach($neighborsC[$neighbor] as $neighbor2) {
                            if(ctype_digit($grid[$neighbor2]) && !isset($islandPositions[$neighbor2])) {
                                $forbidden[$neighbor] = 1;
                                continue 2;
                            }
                        }

                        $allowed[$neighbor] = 1;
                    }

                    $updatedIndex = $islandIndex;
                    $updatedIndex[$neighbor] = 1;

                    $updatedIslands[$updatedIndex] = $islandPositions + [$neighbor => 1];
                }
            }
        }

        $islands = $updatedIslands;
    }

    return $islands;
}

function removedPossibleIsland(array &$possibleIslands, array &$positions, int $clueIndex, int $islandIndex) {

    //Update all the positions this island would have occupied
    foreach($possibleIslands[$clueIndex][$islandIndex] as $position => $filler) {
        if(!isset($positions[$position])) continue;

        unset($positions[$position][$islandIndex]);
    }

    //Remove the possible island
    unset($possibleIslands[$clueIndex][$islandIndex]);
}

function setPosition(int $position, int $clueIndex, string &$grid, array &$clueByPosition, array &$positions, array &$possibleIslands, bool $dropIslands = true): bool {
    global $clues;

    if($grid[$position] != ".") return false;

    //if($debug) error_log("setting $position as " . ($clues[$clueIndex] ?? "~"));

    $grid[$position] = $clues[$clueIndex] ?? "~";

    $clueByPosition[$position] = $clueIndex; //We save what clue this position belongs to (only used if it's not water)

    //We don't want to drop the island when we are only adding partial island
    if($dropIslands) {
        //Every islands that was using this position can't be used anymore
        foreach($positions[$position] as $islandIndex => $clueIndex) {
            removedPossibleIsland($possibleIslands, $positions, $clueIndex, $islandIndex);
        }
    }

    unset($positions[$position]);

    return true;
}

//Place water everywhere we are sure there must be water
function placeForcedWater(string &$grid, array &$clueByPosition, array &$positions, array &$possibleIslands, array &$isLinkedToBorder): bool {

    global $W;

    //foreach(str_split($grid, $N + 2) as $line) error_log($line);
    $positionFound = false;

    //All islands are isolated from each other horizontally and vertically
    $regexes = [
        //X.X
        ["/(?<=[1-9])\.(?=[1-9])/", [-1, 1]],
        //X
        //.
        //X
        ["/(?<=[1-9].{" . ($W + 1) . "})\.(?=.{" . ($W + 1) . "}[1-9])/", [-($W + 2), $W + 2]],
        //*X
        //X.
        ["/(?<=[1-9].{" . $W . "}[1-9])\./", [-($W + 2), -1]],
        //.X
        //X*
        ["/\.(?=[1-9].{" . $W . "}[1-9])/", [1, $W + 2]],
        //X.
        //*X
        ["/(?<=[1-9])\.(?=.{" . ($W + 1) . "}[1-9])/", [-1, $W + 2]],
        //X*
        //.X
        ["/(?<=[1-9].{" . ($W + 1) . "})\.(?=[1-9])/", [-($W + 2), 1]],
    ];

    foreach($regexes as [$regex, [$s1, $s2]]) {
        preg_match_all($regex, $grid, $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as [, $position]) {

            //if($position == 10) error_log("!!!!!!!! " . ($position + $s1) . "(". $clueByPosition[$position + $s1] . ") & " .($position + $s2) . "(" . $clueByPosition[$position + $s2] . ")");

            //The numbers are not from the same island
            if($clueByPosition[$position + $s1] != $clueByPosition[$position + $s2]) {
                $positionFound -= setPosition($position, 0, $grid, $clueByPosition, $positions, $possibleIslands);
            }
        }
    }

    //Prevent isolated water when it's blocked on 3 sides
    $regexes = [
        //*X*
        //X~X
        //*.*
        "/(?<=[1-9#].{" . $W . "}[0-9#]~[0-9#].{" . $W . "})\./",
        //*.*
        //X~X
        //*X*
        "/\.(?=.{" . $W . "}[1-9#]~[0-9#].{" . $W . "}[0-9#])/",
        //*X*
        //X~.
        //*X*
        "/(?<=[1-9#].{" . $W . "}[0-9#]~)\.(?=.{" . $W . "}[0-9#])/",
        //*X*
        //.~X
        //*X*
        "/(?<=[1-9#].{" . $W . "})\.(?=~[0-9#].{" . $W . "}[0-9#])/",
    ];

    foreach($regexes as $regex) {
        preg_match_all($regex, $grid, $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as [, $position]) {
            $positionFound |= setPosition($position, 0, $grid, $clueByPosition, $positions, $possibleIslands);
        }
    }

    //Prevent islated water when we have a deadlock
    $regexes = [
        //*.X
        //X~*
        ["/\.(?=[0-9].{" . ($W - 1) . "}[0-9])/", [1, $W + 1]],
        //*~X
        //X.*
        ["/(?<=[0-9].{" . ($W - 1) . "}[0-9])\./", [-1, -($W + 1)]],
        //X.*
        //*~X
        ["/(?<=[0-9])\.(?=.{" . ($W + 2) . "}[0-9])/", [-1, $W + 3]],
        //X~*
        //*.X
        ["/(?<=[0-9].{" . ($W + 2) . "})\.(?=[0-9])/", [1, -($W + 3)]],
        //X*
        //.~
        //*X
        ["/(?<=[0-9].{" . ($W + 1) . "})\.(?=.{" . ($W + 2) . "}[0-9])/", [-($W + 2), $W + 3]],
        //X*
        //~.
        //*X
        ["/(?<=[0-9].{" . ($W + 2) . "})\.(?=.{" . ($W + 1) . "}[0-9])/", [-($W + 3), $W + 2]],
        //*X
        //.~
        //X*
        ["/(?<=[0-9].{" . $W . "})\.(?=.{" . ($W + 1) . "}[0-9])/", [-($W + 1), $W + 2]],
        //*X
        //~.
        //X*
        ["/(?<=[0-9].{" . ($W + 1) . "})\.(?=.{" . $W . "}[0-9])/", [-($W + 2), $W + 1]],
        //X**
        //*.*
        //**X
        ["/(?<=[0-9].{" . ($W + 2) . "})\.(?=.{" . ($W + 2) . "}[0-9])/", [-($W + 3), $W + 3]],
        //**X
        //*.*
        //X**
        ["/(?<=[0-9].{" . $W . "})\.(?=.{" . $W . "}[0-9])/", [-($W + 1), $W + 1]],
    ];

    foreach($regexes as [$regex, [$s1, $s2]]) {
       
        preg_match_all($regex, $grid, $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as [, $position]) {
            if($clueByPosition[$position + $s1] != $clueByPosition[$position + $s2]) {

                if(canReachBorder($grid, $position + $s1, $isLinkedToBorder) && canReachBorder($grid, $position + $s2, $isLinkedToBorder)) {
                    
                        //error_log("$regex -- $position need to check " . ($position + $s1) . "(" . $clueByPosition[$position + $s1] . ") & " . ($position + $s2) . "(" . $clueByPosition[$position + $s2] . ")");
                        //error_log(($position + $s2) . " " . canReachBorder($grid, $position + $s2));
                    


                    $positionFound |= setPosition($position, 0, $grid, $clueByPosition, $positions, $possibleIslands);
                }
            }
        }
    }

    $regexes = [
        //*~#
        //X.#
        //*~#
        ["/(?<=~.{" . $W . "}[0-9])\.(?=#.{" . $W . "}~#)/", -1],
        //*X*
        //~.~
        //###
        ["/(?<=[0-9].{" . $W . "}~)\.(?=#.{" . $W . "}#)/", -($W + 2)],
        //#~*
        //#.X
        //#~*
        ["/(?<=~.{" . $W . "}#)\.(?=[0-9].{" . $W . "}~)/", 1],
        //###
        //~.~
        //*X*
        ["/(?<=#.{" . $W . "}~)\.(?=~.{" . $W . "}[0-9])/", $W + 2],
    ];

    foreach($regexes as [$regex, $shift]) {
       
        preg_match_all($regex, $grid, $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as [, $position]) {

            error_log($position . " is " . canReachBorder($grid, $position + $shift, $isLinkedToBorder));
            //exit();

            if(canReachBorder($grid, $position + $shift, $isLinkedToBorder)) {
                $positionFound |= setPosition($position, 0, $grid, $clueByPosition, $positions, $possibleIslands);
            }
        }
    }

    return $positionFound;
}

$start = microtime(1);

fscanf(STDIN, "%d", $W);

$grid = str_repeat("#", $W + 2);
$clueByPosition = [];
$totalWater = $W * $W;
$positions = [];
$possibleIslands = [];
$indexIsland = 0;
$isLinkedToBorder = [];

for($y = 0; $y < $W; ++$y) {
    $line = trim(fgets(STDIN));

    foreach(str_split($line) as $x => $c) {
        $index = ($y + 1) * ($W + 2) + $x + 1;

        if($x > 0) $neighborsC[$index][] = $index - 1;
        if($x < $W - 1) $neighborsC[$index][] = $index + 1;
        if($y > 0) $neighborsC[$index][] = $index - ($W + 2);
        if($y < $W - 1) $neighborsC[$index][] = $index + $W + 2;

        $neighborsV[$index] = [$index - ($W + 3), $index - ($W + 2), $index - ($W + 1), $index - 1, $index + 1, $index + $W + 1, $index + $W + 2, $index + $W + 3];

        if($c != ".") {
            $clueByPosition[$index] = $index;

            $clues[$index] = $c;
            $totalWater -= $c;
        } else {
            $positions[$index] = [];
        }
    }

    $grid .= "#" . $line . "#";
}

$grid .= str_repeat("#", $W + 2);

placeForcedWater($grid, $clueByPosition, $positions, $possibleIslands, $isLinkedToBorder);

foreach($clues as $clueIndex => $clueCount) {

    foreach(generateIslands($clueIndex, $clueCount, $grid) as $island) {
        foreach($island as $position => $filler) {

            //For each positions we want to know what island are using it
            $positions[$position][$indexIsland] = $clueIndex;
        }

        $possibleIslands[$clueIndex][$indexIsland++] = $island;
    }
}

function solve(string $grid, array $positions, array $possibleIslands, array $clueByPosition, array $isLinkedToBorder) {

    global $W, $clues, $neighborsC, $start;

    do {
        $positionFound = false;

        //error_log("start new round");

        checkSquareWater($grid, $positions, $possibleIslands, $W);

        foreach($possibleIslands as $clueIndex => $islands) {
            //There is only one possible island for this clue, we use it
            if(count($islands) == 0) {
                //error_log("stop because no more island for clue $clueIndex");
                return;
            }
            elseif(count($islands) == 1) {
                $islandPositions = array_pop($islands);

                //if($debug) error_log("clue $clueIndex only one island");

                foreach($islandPositions as $position => $filler) {
                    $positionFound |= setPosition($position, $clueIndex, $grid, $clueByPosition, $positions, $possibleIslands);

                    //Every direct neighbor of the island is water
                    foreach($neighborsC[$position] as $neighbor) {
                        if(!isset($islandPositions[$neighbor])) {
                            setPosition($neighbor, 0, $grid, $clueByPosition, $positions, $possibleIslands);
                        }
                    }
                }
    
                unset($possibleIslands[$clueIndex]);
            } else {
                
                $positionsCommon = reset($islands);
    
                while($next = next($islands)) {
                    $positionsCommon = array_intersect_key($positionsCommon, $next);
                }

                //error_log(var_export($clueIndex, true));
                //error_log(var_export($positionsCommon, true));
    
                if(count($positionsCommon) > 1) {
                    foreach($positionsCommon as $position => $filler) {
                        $positionFound |= setPosition($position, $clueIndex, $grid, $clueByPosition, $positions, $possibleIslands, false);
                    }
                }
            }
        }

        //Every positions that no island can reach has to be water
        foreach(array_filter($positions, function($possibilites) { return count($possibilites) == 0; }) as $position => $filler) {
            //error_log(var_export("$position is water", true));
            $positionFound |= setPosition($position, 0, $grid, $clueByPosition, $positions, $possibleIslands);
        }

        $positionFound |= placeForcedWater($grid, $clueByPosition, $positions, $possibleIslands, $isLinkedToBorder);

    } while($positionFound && count($possibleIslands));

    //foreach(str_split($grid, $W + 2) as $line) error_log(var_export($line, true));

    if(checkContinuousWater($grid) == false) {
        //error_log("not continuous water");
        return;
    }

    //We are done, we have found all the islands
    if(count($possibleIslands) == 0) {

        echo implode("\n", array_map(function($line) {
            return substr($line, 1, -1);
        }, array_slice(str_split($grid, $W + 2), 1, -1))) . PHP_EOL;

        error_log(microtime(1) - $start);
        exit();

    } else {
        uasort($possibleIslands, function($a, $b) {
            return count($a) <=> count($b);
        });

        $clueIndex = array_key_first($possibleIslands);

        foreach($possibleIslands[$clueIndex] as $islandIndex => $island) {
            //error_log("we need to test $islandIndex for $clueIndex -- " . (microtime(1) - $start));

            $possibleIslands2 = $possibleIslands;
            $positions2 = $positions;
            
            foreach($possibleIslands[$clueIndex] as $islandIndex2 => $island2) {
                if($islandIndex == $islandIndex2) continue;

                removedPossibleIsland($possibleIslands2, $positions2, $clueIndex, $islandIndex2);
            }

            solve($grid, $positions2, $possibleIslands2, $clueByPosition, $isLinkedToBorder); 
        }
    }
}

solve($grid, $positions, $possibleIslands, $clueByPosition, $isLinkedToBorder); 
