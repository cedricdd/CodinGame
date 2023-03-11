<?php


$start = microtime(1);

fscanf(STDIN, "%d", $N);

$grid = "";
$water = $N * $N;

for($y = 0; $y < $N; ++$y) {
    $line = trim(fgets(STDIN));

    foreach(str_split($line) as $x => $c) {
        $index = $y * $N + $x;

        if($x > 0) $neighbors[$index][] = $index - 1;
        if($x < $N - 1) $neighbors[$index][] = $index + 1;
        if($y > 0) $neighbors[$index][] = $index - $N;
        if($y < $N - 1) $neighbors[$index][] = $index + $N;

        if($c != ".") {
            $clues[$index] = $c;
            $water -= $c;
        }
    }

    $grid .= $line;
}

foreach($clues as $position => $count) {
    if($count == 1) {
        foreach($neighbors[$position] as $neighbor) {
            $grid[$neighbor] = "~";
        }

        unset($clues[$position]);
    }
}

function placeForcedWater() {
    global $grid, $N, $clues, $neighbors;

    $gridRegex = str_repeat("#", $N + 2) . implode("", array_map(function($line) {
        return "#" . $line . "#";
    }, str_split($grid, $N))) . str_repeat("#", $N + 2);

    foreach(str_split($gridRegex, $N + 2) as $line) error_log($line);

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
        ["/[1-9#](?=.{" . $N . "}[0-9#]~[0-9#])/", ($N + 2) * 2],
        //X~X
        //.X.
        ["/[1-9#](?=~[0-9#].{" . $N . "}[0-9#])/", -($N + 1)],
        //.X
        //X~
        //.X
        ["/[1-9#](?=.{" . $N . "}[0-9#]~.{" . ($N + 1) . "}[0-9#])/", $N + 3],
        //X.
        //~X
        //X.
        ["/[1-9#](?=.{" . ($N + 1) . "}~[0-9#].{" . $N . "}[0-9#])/", $N + 1],
    ];

    foreach($regexes as [$regex, $shift]) {
        //error_log(var_export($gridRegex, true));
        preg_match_all($regex, $gridRegex, $matches, PREG_OFFSET_CAPTURE);

        //error_log(var_export($matches, true));
    
        foreach($matches[0] as [, $position]) {
            $waterPosition = $position + $shift;

            $gridRegex[$waterPosition] = "~";

            [$x, $y] = [($waterPosition % ($N + 2)) - 1, intdiv($waterPosition, $N + 2) - 1];
    
            //error_log(var_export("$x $y " . ($y * $N + $x) . " -- $waterPosition", true));
    
            $grid[$y * $N + $x] = "~";
        }
    }
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

do {
    error_log(var_export("run search", true));

    $islandsToFind = count($clues);
    $counts = [];
    $islands = [];
    $indexIsland = 0;
    $positions = array_fill(0, $N * $N, []);
    $test = 0;
    $uniqueIslandFound = false;
    $noIsland = [];

    placeForcedWater($grid, $N);

    for($i = 0; $i < $N * $N; ++$i) {
        if($grid[$i] == ".") $noIsland[$i] = 1;
    }

    foreach($clues as $index => $count) {
        $possibleIslands = getIslands($index, $count);
        $possibleIslandsCount = count($possibleIslands);

        $test += $possibleIslandsCount;

        //error_log(var_export($possibleIslands, true));

        if($possibleIslandsCount == 1) {
            error_log(var_export("!!!!! $index", true));
            $uniqueIslandFound = true;
            $islandPositions = array_pop($possibleIslands);

            foreach($islandPositions as $position => $filler) {
                unset($positions[$position]);
                unset($counts[$position]);
                unset($noIsland[$position]);
                $grid[$position] = $count;

                foreach($neighbors[$position] as $neighbor) {
                    if(!isset($islandPositions[$neighbor])) {
                        $grid[$neighbor] = "~";
                    }
                }
            }

            --$islandsToFind;
        } else {
            foreach($possibleIslands as $islandPositions) {
                foreach($islandPositions as $position => $filler) {
                    $positions[$position][$index][] = $indexIsland;

                    foreach($neighbors[$position] as $neighbor) {
                        $islandsWithWater[$indexIsland][$neighbor] = 1;
                    }

                    unset($noIsland[$position]);
                }

                $islands[$index][$indexIsland++] = $islandPositions;
            }

            $counts[$index] = $possibleIslandsCount;
        }
    }

    foreach($noIsland as $position => $filler) {
        $grid[$position] = "~";
    }

} while($uniqueIslandFound);

foreach(str_split($grid, $N) as $line) error_log($line);
error_log(var_export($test, true));
error_log(microtime(1) - $start);
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

