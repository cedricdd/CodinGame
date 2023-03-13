<?php


$start = microtime(1);

fscanf(STDIN, "%d", $N);

$grid = str_repeat("#", $N + 2);
$water = $N * $N;

for($y = 0; $y < $N; ++$y) {
    $line = trim(fgets(STDIN));

    foreach(str_split($line) as $x => $c) {
        $index = ($y + 1) * ($N + 2) + $x + 1;

        if($x > 0) $neighbors[$index][] = $index - 1;
        if($x < $N - 1) $neighbors[$index][] = $index + 1;
        if($y > 0) $neighbors[$index][] = $index - ($N + 2);
        if($y < $N - 1) $neighbors[$index][] = $index + $N + 2;

        if($c != ".") {
            $clues[$index] = $c;
            $water -= $c;
        }
    }

    $grid .= "#" . $line . "#";
}

$grid .= str_repeat("#", $N + 2);

/*
foreach($clues as $position => $count) {
    if($count == 1) {
        foreach($neighbors[$position] as $neighbor) {
            $grid[$neighbor] = "~";
        }

        unset($clues[$position]);
    }
}*/

function placeForcedWater(string &$grid, int $N): bool {

    //foreach(str_split($grid, $N + 2) as $line) error_log($line);
    $positionFound = false;

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

function getIslands(int $position, int $count): array {

    global $neighbors, $grid, $N;

    $index = str_repeat("0", $N * $N);
    $index[$position] = 1;

    $islands = [$index => [$position => 1]];
    $forbidden = [$position => 1];

    for($i = 1; $i < $count; ++$i) {
        $updatedIslands = [];

        foreach($islands as $islandIndex => $islandPositions) {
            foreach($islandPositions as $position => $filler) {
                foreach($neighbors[$position] as $neighbor) {
                    if(isset($forbidden[$neighbor]) || isset($islandPositions[$neighbor])) continue; //This position can't be used for this island
                    if($grid[$neighbor] != ".") {
                        $forbidden[$neighbor] = 1;
                        continue; //A clue can't be part of the island
                    }

                    foreach($neighbors[$neighbor] as $check) {
                        if(ctype_digit($grid[$check]) && !isset($islandPositions[$check])) {
                            $forbidden[$neighbor] = 1;
                            continue 2; //This is the neighbor of another island, it needs to be water
                        }
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

            error_log(var_export($position, true));

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

                error_log(var_export("only clue $clueIndex -- $countBefore => $countAfter", true));

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

    foreach($clues as $cluePosition => $clueCount) {

        foreach(getIslands($cluePosition, $clueCount) as $islandPositions) {
            foreach($islandPositions as $position => $filler) {
                $positions[$position][$cluePosition][$indexIsland] = 1;

                /*
                foreach($neighbors[$position] as $neighbor) {
                    $islandsWithWater[$indexIsland][$neighbor] = 1;
                }*/
            }

            $possibleIslands[$cluePosition][$indexIsland++] = $islandPositions;
        }

        //$counts[$index] = $possibleIslandsCount;
    }

    checkSquareWater($grid, $possibleIslands, $N);

    foreach($possibleIslands as $clueIndex => $islands) {
        if(count($islands) == 1) {
            $positionFound = true;
            $islandPositions = array_pop($islands);
    
            foreach($islandPositions as $position => $filler) {
                unset($positions[$position]);

                $grid[$position] = $clues[$clueIndex];
    
                foreach($neighbors[$position] as $neighbor) {
                    if(!isset($islandPositions[$neighbor])) {
                        $grid[$neighbor] = "~";
                    }
                }
            }

            unset($clues[$clueIndex]);
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

    foreach(str_split($grid, $N + 2) as $line) error_log($line);

} while($positionFound && count($clues));

error_log(microtime(1) - $start);

echo implode("\n", array_map(function($line) {
    return substr($line, 1, -1);
}, array_slice(str_split($grid, $N + 2), 1, -1))) . PHP_EOL;

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

