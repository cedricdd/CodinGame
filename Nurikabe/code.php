<?php

$start = microtime(1);

fscanf(STDIN, "%d", $N);

$grid = str_repeat("#", $N + 2);
$positionByClue = [];
$water = $N * $N;

for($y = 0; $y < $N; ++$y) {
    $line = trim(fgets(STDIN));

    foreach(str_split($line) as $x => $c) {
        $index = ($y + 1) * ($N + 2) + $x + 1;

        if($x > 0) $neighbors[$index][] = $index - 1;
        if($x < $N - 1) $neighbors[$index][] = $index + 1;
        if($y > 0) $neighbors[$index][] = $index - ($N + 2);
        if($y < $N - 1) $neighbors[$index][] = $index + $N + 2;

        $neighborsV[$index] = [$index - ($N + 3), $index - ($N + 1), $index + $N + 1, $index + $N + 3];

        if($c != ".") {
            $positionByClue[$index] = $index;

            $clues[$index] = ["count" => $c, "positions" => [$index => 1]];
            $water -= $c;

            if($c == 6) error_log($index);
        }
    }

    $grid .= "#" . $line . "#";
}

$grid .= str_repeat("#", $N + 2);

$regexes = [
    //X.X
    ["/[1-9](?=\.[1-9])/", 1],
    //X
    //.
    //X
    ["/[1-9](?=.{" . ($N + 1) . "}\..{" . ($N + 1) . "}[1-9])/", $N + 2],
    //*X
    //X.
    ["/[1-9](?=.{" . $N . "}[1-9]\.)/", $N + 2],
    //.X
    //X*
    ["/\.[1-9](?=.{" . $N . "}[1-9])/", 0],
    //X.
    //*X
    ["/[1-9](?=\..{" . ($N + 1) . "}[1-9])/", 1],
    //X*
    //.X
    ["/[1-9](?=.{" . ($N + 1) . "}\.[1-9])/", $N + 2],
];

foreach($regexes as [$regex, $shift]) {
    //error_log(var_export($gridRegex, true));
    preg_match_all($regex, $grid, $matches, PREG_OFFSET_CAPTURE);

    //error_log(var_export($matches, true));

    foreach($matches[0] as [, $position]) {
        $grid[$position + $shift] = "~";
    }
}

function canReachBorder(string $grid, int $start): bool {
    global $neighbors, $neighborsV;
    static $history;

    $toCheck = [$start];
    $visited = [];

    while(count($toCheck)) {
        $newCheck = [];

        //error_log(var_export($toCheck, true));

        foreach($toCheck as $position) {
            
            if(isset($history[$position]) || $grid[$position] == "#") {
                foreach($visited as $position => $filler) {
                    $history[$position] = 1;
                }

                return true;
            }
            elseif(isset($visited[$position]) || !ctype_digit($grid[$position])) continue;
            else $visited[$position] = 1;

            foreach(array_merge($neighbors[$position], $neighborsV[$position]) as $neighbor) {
                $newCheck[] = $neighbor;
            }
        }

        $toCheck = $newCheck;
    }

    return false;
}

function preventIsolatedWater(string &$grid, array $positionByClue, int $size): bool {

    $positionFound = false;

    $regexes = [
        //*.X
        //X~*
        ["/\.(?=[0-9].{" . ($size - 1) . "}[0-9])/", [1, $size + 1]],
        //*~X
        //X.*
        ["/(?<=[0-9].{" . ($size - 1) . "}[0-9])\./", [-1, -($size + 1)]],
        //X.*
        //*~X
        ["/(?<=[0-9])\.(?=.{" . ($size + 2) . "}[0-9])/", [-1, $size + 3]],
        //X~*
        //*.X
        ["/(?<=[0-9].{" . ($size + 2) . "})\.(?=[0-9])/", [1, -($size + 3)]],
        //X*
        //.~
        //*X
        ["/(?<=[0-9].{" . ($size + 1) . "})\.(?=.{" . ($size + 2) . "}[0-9])/", [-($size + 2), $size + 3]],
        //X*
        //~.
        //*X
        ["/(?<=[0-9].{" . ($size + 2) . "})\.(?=.{" . ($size + 1) . "}[0-9])/", [-($size + 3), $size + 2]],
        //*X
        //.~
        //X*
        ["/(?<=[0-9].{" . $size . "})\.(?=.{" . ($size + 1) . "}[0-9])/", [-($size + 1), $size + 2]],
        //*X
        //~.
        //X*
        ["/(?<=[0-9].{" . ($size + 1) . "})\.(?=.{" . $size . "}[0-9])/", [-($size + 2), $size + 1]],
        //X**
        //*.*
        //**X
        ["/(?<=[0-9].{" . ($size + 2) . "})\.(?=.{" . ($size + 2) . "}[0-9])/", [-($size + 3), $size + 3]],
        //**X
        //*.*
        //X**
        ["/(?<=[0-9].{" . $size . "})\.(?=.{" . $size . "}[0-9])/", [-($size + 1), $size + 1]],
    ];

    foreach($regexes as [$regex, [$s1, $s2]]) {
       
        preg_match_all($regex, $grid, $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as [, $position]) {
            if($positionByClue[$position + $s1] != $positionByClue[$position + $s2]) {
                //error_log("$regex -- $position need to check " . ($position + $s1) . "(" . $positionByClue[$position + $s1] . ") & " . ($position + $s2) . "(" . $positionByClue[$position + $s2] . ")");

                //error_log(($position + $s1) . " is " . canReachBorder($grid, $position + $s1));
                //error_log(($position + $s2) . " is " . canReachBorder($grid, $position + $s2));

                if(canReachBorder($grid, $position + $s1) && canReachBorder($grid, $position + $s2)) {
                    $grid[$position] = "~";

                    $positionFound = true;
                }
            }
        }
    }

    $regexes = [
        //*~#
        //X.#
        //*~#
        ["/(?<=~.{" . $size . "}[0-9])\.(?=#.{" . $size . "}~#)/", -1],
    ];

    foreach($regexes as [$regex, $shift]) {
       
        preg_match_all($regex, $grid, $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as [, $position]) {

            error_log($position . " is " . canReachBorder($grid, $position + $shift));

            if(canReachBorder($grid, $position + $shift)) {
                $grid[$position] = "~";

                $positionFound = true;
            }
        }
    }

    return $positionFound;
}

function placeForcedWater(string &$grid, int $N): bool {

    //foreach(str_split($grid, $N + 2) as $line) error_log($line);
    $positionFound = false;

    $regexes = [
        //.X.
        //X~X
        //*.*
        ["/[1-9#](?=.{" . $N . "}[0-9#]~[0-9#].{" . $N . "}\.)/", ($N + 2) * 2],
        //*.*
        //X~X
        //.X.
        ["/\..{" . $N . "}[1-9#](?=~[0-9#].{" . $N . "}[0-9#])/", 0],
        //.X*
        //X~.
        //.X*
        ["/[1-9#](?=.{" . $N . "}[0-9#]~\..{" . $N . "}[0-9#])/", $N + 3],
        //*X.
        //.~X
        //*X.
        ["/[1-9#](?=.{" . $N . "}\.~[0-9#].{" . $N . "}[0-9#])/", $N + 1],
    ];

    foreach($regexes as [$regex, $shift]) {
        //error_log(var_export($gridRegex, true));
        preg_match_all($regex, $grid, $matches, PREG_OFFSET_CAPTURE);

        //error_log(var_export($matches, true));
    
        foreach($matches[0] as [, $position]) {
            $grid[$position + $shift] = "~";
            //error_log(var_export($regex, true));
            //error_log(var_export($matches[0], true));
            $positionFound = true;
        }
    }

    return $positionFound;
}

function getIslands(array $positions, int $count): array {

    global $neighbors, $grid, $N, $positionByClue;

    $hash = str_repeat("0", ($N + 2) * ($N + 2));
    $clueIndex = array_key_first($positions);
    $hash[$clueIndex] = 1;

    $islands = [$hash => [$clueIndex => 1]];
    $forbidden = [];
    $allowed = [];

    for($i = 1; $i < $count; ++$i) {
        $updatedIslands = [];

        foreach($islands as $islandIndex => $islandPositions) {
            foreach($islandPositions as $position => $filler) {
                foreach($neighbors[$position] as $neighbor) {
                    if(isset($forbidden[$neighbor]) || isset($islandPositions[$neighbor])) continue; //This position can't be used for this island
                    if($grid[$neighbor] != "." && ($positionByClue[$neighbor] ?? 0) != $clueIndex) {
                        $forbidden[$neighbor] = 1;
                        continue; //A clue can't be part of the island
                    }

                    if(!isset($allowed[$neighbor])) {
                        foreach($neighbors[$neighbor] as $check) {
                            if(ctype_digit($grid[$check]) && $positionByClue[$check] != $clueIndex) {
                                $forbidden[$neighbor] = 1;
                                continue 2; //This is the direct neighbor of another island
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

    //error_log(var_export($islands, true));

    foreach($islands as $islandIndex => $possibleIsland) {
        if(count(array_diff_key($positions, $possibleIsland)) != 0) {
            unset($islands[$islandIndex]);
        } else {
            //error_log(var_export(array_diff_key($positions, $possibleIsland),true));
        }
    }

    return $islands;
}

function checkSquareWater(string &$grid, array &$possibleIslands, int $size) {

    //foreach(str_split($grid, $size + 2) as $line) error_log($line);

    $regexes = [
        //~~
        //~.
        ["/~~.{" . $size . "}~\./", $size + 3],
        //~~
        //.~
        ["/~~.{" . $size . "}\.~/", $size + 2],
        //.~
        //~~
        ["/\.~.{" . $size . "}~~/", 0],
        //~.
        //~~
        ["/~\..{" . $size . "}~~/", 1],
    ];

    $regexes = [
        //~.
        //..
        ["/[~\.](?=[~\.].{" . $size . "}[~\.][~\.])/", [0, 1, $size + 2, $size + 3]],
    ];


    while(true) {
        [$regex, $listShift] = current($regexes);
        $possibilitesReduced = false;

        //error_log(var_export("$regex $shift", true));
        preg_match_all($regex, $grid, $matches, PREG_OFFSET_CAPTURE);

        //error_log(var_export($matches, true));
    
        foreach($matches[0] as [, $position]) {
            $possibilites = [];

            //error_log(var_export($position, true));

            foreach($possibleIslands as $clueIndex => $islands) {
                foreach($islands as $islandIndex => $listPositions) {
                    foreach($listShift as $shift) {
                        if(isset($listPositions[$position + $shift])) {
                            $possibilites[$clueIndex][$islandIndex] = 1;
                        }
                    }
                }
            }
            
            if(count($possibilites) == 1) {
                
                $clueIndex = array_key_first($possibilites);
                $countBefore = count($possibleIslands[$clueIndex]);

                $possibleIslands[$clueIndex] = array_intersect_key($possibleIslands[$clueIndex], $possibilites[$clueIndex]);

                $countAfter = count($possibleIslands[$clueIndex]);

                //error_log(var_export("only clue $clueIndex -- $countBefore => $countAfter", true));

                $possibilitesReduced |= ($countBefore != $countAfter);
            }
        }

        if($possibilitesReduced) reset($regexes);
        elseif(next($regexes) == false) break;
    };
}

do {
    error_log(var_export("run search", true));

    //$islandsToFind = count($clues);
    $possibleIslands = [];
    $indexIsland = 0;
    $positions = array_fill(0, $N * $N, []);


    $positionFound = placeForcedWater($grid, $N);

    foreach($clues as $clueIndex => ["count" => $clueCount, "positions" => $cluePositions]) {

        foreach(getIslands($cluePositions, $clueCount) as $islandPositions) {
            foreach($islandPositions as $position => $filler) {
                $positions[$position][$clueIndex][$indexIsland] = 1;

                /*
                foreach($neighbors[$position] as $neighbor) {
                    $islandsWithWater[$indexIsland][$neighbor] = 1;
                }*/
            }

            $possibleIslands[$clueIndex][$indexIsland++] = $islandPositions;
            //if($clueIndex == 81) error_log(var_export(implode("-", array_keys($islandPositions)), true));

        }

        //$counts[$index] = $possibleIslandsCount;
    }

    checkSquareWater($grid, $possibleIslands, $N);

    /*
    error_log(var_export("after", true));
    foreach($possibleIslands[81] as $islandPositions) {
        $test = array_keys($islandPositions);
        rsort($test);
        error_log(var_export(implode("-", $test), true));
    }*/

    foreach($possibleIslands as $clueIndex => $islands) {
        if(count($islands) == 1) {
            $positionFound = true;
            $islandPositions = array_pop($islands);
    
            foreach($islandPositions as $position => $filler) {
                unset($positions[$position]);

                $grid[$position] = $clues[$clueIndex]["count"];
                $positionByClue[$position] = $clueIndex;
    
                foreach($neighbors[$position] as $neighbor) {
                    if(!isset($islandPositions[$neighbor])) {
                        $grid[$neighbor] = "~";
                    }
                }
            }

            unset($clues[$clueIndex]);
        } else {
            if($clueIndex == 81) foreach($islands as $island) error_log(var_export(implode("-", array_keys($island)), true));

            $positionsCommon = reset($islands);

            while($next = next($islands)) {
                $positionsCommon = array_intersect_key($positionsCommon, $next);
            }

            if(count($positionsCommon) > 1) {
                //error_log(var_export($clueIndex, true));
                if($clueIndex == 81) error_log(var_export($positionsCommon, true));

                foreach($positionsCommon as $position => $filler) {
                    if(!isset($clues[$clueIndex]["positions"][$position])) {
                        $clues[$clueIndex]["positions"][$position] = 1;

                        $positionByClue[$position] = $clueIndex;

                        $grid[$position] = $clues[$clueIndex]["count"];

                        $positionFound = true;
                    }
                }
            }
        }
    }

    $unknownPositions = array_filter(str_split($grid), function($position) {
        return $position == ".";
    });

    //error_log(var_export($unknownPositions, true));

    foreach($possibleIslands as $islands) {
        foreach($islands as $island) {
            foreach($island as $position => $filler) {
                unset($unknownPositions[$position]);
            }
        }
    }

    foreach($unknownPositions as $position => $filler) {
        $grid[$position] = "~";
        $positionFound = true;
    }

    $positionFound |= preventIsolatedWater($grid, $positionByClue, $N);

    foreach(str_split($grid, $N + 2) as $line) error_log($line);

} while($positionFound && count($clues));

error_log(microtime(1) - $start);

echo implode("\n", array_map(function($line) {
    return substr($line, 1, -1);
}, array_slice(str_split($grid, $N + 2), 1, -1))) . PHP_EOL;

$count = 0;

foreach($possibleIslands as $islands) $count += count($islands);

error_log("we still have $count possible islands");

exit();

//All positions with no island is a forced water
function getWaterIsland(string $grid, int $count, array $mandatoryWater): array {
    return [];
}

error_log(var_export(getWaterIsland($grid, $water, $mandatoryWater), true));

error_log(var_export(str_split($grid, $N), true));
error_log(microtime(1) - $start);
//error_log(var_export($clues, true));
error_log(var_export($test, true));
exit();

function checkWater(string $grid) {
    static $count;
    global $water, $neighbors, $N, $start;

    $grid = str_replace(".", "~", $grid);

    $formattedGrid = implode("", array_map(function($line) {
        return "#" . $line . "#";
    }, str_split($grid, $N)));

    //error_log(var_export(++$count, true));

    if(preg_match("/~~.{" . $N . "}~~/", $formattedGrid)) return;

    $startPosition = strpos($grid, "~");
    $toCheck = [$startPosition];
    $count = 0;
    $list = [];

    //error_log(var_export($grid, true));
    //error_log(var_export("starting at $startPosition", true));

    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as $position) {
            if(isset($list[$position])) continue;
            else $list[$position] = 1;

            ++$count;

            foreach($neighbors[$position] as $neighbor) {
                if(!ctype_digit($grid[$neighbor])) $newCheck[] = $neighbor;
            }
        }

        $toCheck = $newCheck;
    }

    if($count == $water) {
        //error_log(var_export(str_split($grid, $N), true));
        echo implode("\n", str_split($grid, $N)) . PHP_EOL;
        error_log(microtime(1) - $start);
        exit();
    } else {
        //error_log(var_export("water doesn't match $count != $water", true));
    }
}

function solve(array $islands, array $counts, string $grid, int $islandsToFind, bool $debug = false) {
    global $islandsWithWater, $positions, $clues, $N;

    //error_log(var_export("left $islandsToFind", true));

    if($islandsToFind == 0) {
        checkWater($grid);
        //error_log(var_export(str_split($grid, $N), true));
        //exit();
        //error_log("found one");
        return;
    }

    $min = INF;
    $clue = 0;
    foreach($counts as $index => $value) {
        if($value > 0 && $value < $min) {
            $clue = $index;
            $min = $value;

            if($value == 1) break;
        }
    }

    //error_log(var_export("working on clue $clue", true));
    //error_log(var_export($islands[$clue], true));
    
    foreach($islands[$clue] as $islandIndex => $island) {

        //if($clue == 9 && $islandIndex == 1) exit();

        $islands2 = $islands;
        $counts2 = $counts;
        $grid2 = $grid;

        unset($islands2[$clue]);
        unset($counts2[$clue]);

        //if(implode("-", array_keys($island)) == "18-23") $debug = true;

        //error_log("using island #$islandIndex " . implode("-", array_keys($island)) . " for clue #$clue");

        if($clue == 23) {
            //error_log("using island #$islandIndex " . implode("-", array_keys($island)) . " for clue #$clue");
            //error_log($counts2[15]);
            //error_log(var_export(implode("-", array_keys($islands2[15])), true));
        }

        foreach($island as $islandPosition => $filler) {
            $grid2[$islandPosition] = $clues[$clue];
        }

        //if(implode("-", array_keys($island)) == "10-11-15-16-20-21") error_log(var_export(str_split($grid2, $N), true));

        foreach($islandsWithWater[$islandIndex] as $islandPosition => $filler) {

            //error_log("$islandPosition");

            foreach($positions[$islandPosition] as $clueIndex2 => $listIslands) {
                if(!isset($counts2[$clueIndex2])) continue;

                foreach($listIslands as $indexToRemove) {
                    if(!isset($islands2[$clueIndex2][$indexToRemove])) continue;

                    //if($indexToRemove == 13) error_log("island #$indexToRemove for clue #$clueIndex2 can't be used anymore because of pos $islandPosition");

                    if(--$counts2[$clueIndex2] == 0) continue 4;

                    if($debug) {
                        //error_log($counts2[$clueIndex2]);
                    }
            

                    unset($islands2[$clueIndex2][$indexToRemove]);
                }
            }
        }

        if($debug) {
            //error_log(count($islands[15]));
        }

        if($clue == 9 && $islandIndex != 0) $debug = 0;

        solve($islands2, $counts2, $grid2, $islandsToFind - 1);

    }
}

solve($islands, $counts, $grid, $islandsToFind, 1);

