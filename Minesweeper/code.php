<?php

$bombs = [];

// game loop
while (TRUE) {
    $turnGrid = [];

    for ($i = 0; $i < 16; $i++) {
        $turnGrid[] = explode(" ", trim(fgets(STDIN)));
    }

    //First turn, we select the middle of the grid
    if($turnGrid[8][15] === "?") {
        echo "15 8" . PHP_EOL;
        continue;
    }

    $toFlag = [];
    $guesses = [];
    $loop = 0;

    do {
        $grid = $turnGrid;
        $neighbors = [];
        $safePositions = [];
        $restartLoop = false;

        //Set all the bombs we already know
        foreach($bombs as $y => $line) {
            foreach($line as $x => $fille) {
                $grid[$y][$x] = "B";
            }
        }

        //Foreach position with a digit we get the number of neighbors that are "?" and the number of bombs that are still unknown
        for($y = 0; $y < 16; ++$y) {
            for($x = 0; $x < 30; ++$x) {
                if(!is_numeric($grid[$y][$x])) continue;
    
                $bombsToFind = $grid[$y][$x];
                $neighbors[$x . " " . $y] = [];

                for($y2 = max(0, $y - 1); $y2 < min(16, $y + 2); ++$y2) {
                    for($x2 = max(0, $x -1); $x2 < min(30, $x + 2); ++$x2) {
                        if($grid[$y2][$x2] === "B") --$bombsToFind;
                        elseif($grid[$y2][$x2] === "?") $neighbors[$x . " " . $y][$x2 . " " . $y2] = [$x2, $y2];
                    }
                }

                //We know where all the bombs are
                if($bombsToFind == 0) {
                    //If there are some other neighbors we are sure there's no bomb there
                    if(count($neighbors[$x . " " . $y]) > 0) {
                        foreach($neighbors[$x . " " . $y] as [$safeX, $safeY]) {
                            $safePositions["$safeX $safeY"] = 1;
                            $grid[$safeY][$safeX] = ".";
                        }
                    }
                }
                //We don't already know where all the bombs are located
                else {
                    //The # of "?" in neighbors is the same as the # of bombs still to find, it's all bombs 
                    if($bombsToFind == count($neighbors[$x . " " . $y])) {
                        foreach($neighbors[$x . " " . $y] as [$bombX, $bombY]) {
                            $bombs[$bombY][$bombX] = 1;
                            $toFlag["$bombX $bombY"] = 1;
                            $grid[$bombY][$bombX] = "B";
                            $restartLoop = true;
                        }
        
                        $bombsToFind = 0;
                    } //We don't know where the bombs are
                    else {
                        $chance = $bombsToFind / count($neighbors[$x . " " . $y]);

                        foreach($neighbors[$x . " " . $y] as [$x2, $y2]) {
                            $guesses["$x2 $y2"] = min(($guesses["$x2 $y2"] ?? 1), $chance);
                        }
                    }
                }
                
                $grid[$y][$x] = $bombsToFind;
                if($bombsToFind == 0) unset($neighbors[$x . " " . $y]);
            }
        }
    
        foreach($neighbors as $position => $list) {
            [$x, $y] = explode(" ", $position);

            if($tx == $x && $ty == $y) $debug = 1;
            else $debug = 0;

            //We check the neighbors of the current position
            for($y2 = max(0, $y - 2); $y2 < min(16, $y + 3); ++$y2) {
                for($x2 = max(0, $x - 2); $x2 < min(30, $x + 3); ++$x2) {
                    if($x2 == $x && $y2 == $y) continue;
                    
                    if(is_numeric($grid[$y2][$x2]) && $grid[$y2][$x2] >= $grid[$y][$x]) {
                        $perfectMatch = true;
                        $matches = 0;
                        $neighborsDifference = $neighbors[$x2 . " " . $y2];

                        //Check if they have common neighbors
                        foreach($list as [$nx, $ny]) {
                            if(isset($neighborsDifference[$nx . " " . $ny])) {
                                unset($neighborsDifference[$nx . " " . $ny]);
                                ++$matches;
                            }
                            else $perfectMatch = false;
                        }

                        $updatedCount = $grid[$y2][$x2] - $grid[$y][$x];

                        //The neighbors that are left are all safe positions
                        if($updatedCount == 0 && $perfectMatch && count($neighborsDifference)) {
                            foreach($neighborsDifference as [$safeX, $safeY]) {
                                $safePositions["$safeX $safeY"] = 1;
                            }

                        } //The neighbors that are left are all bombs
                        elseif($matches > 1 && $updatedCount > 0 && $updatedCount == count($neighborsDifference)) {
                            foreach($neighborsDifference as [$bombX, $bombY]) {
                                $bombs[$bombY][$bombX] = 1;
                                $toFlag["$bombX $bombY"] = 1;
                            }

                            $restartLoop = true;
                        }
                    }
                }
            }
        }
    } while($restartLoop);

    /*
    error_log(var_export(implode("\n", array_map(function($line) {
        return implode("", $line);
    }, $grid)), true)); 
    */

    error_log("We have found " . array_sum(array_map("count", $bombs)) . " bombs.");

    //We have some safe positions
    if(count($safePositions) > 0) {
        error_log("We have " . count($safePositions) . " safe positions.");

        echo array_key_first($safePositions) . " " . implode(" ", array_keys($toFlag)) . PHP_EOL;
    }
    //We use the safest guess 
    elseif(!empty($guesses)) {
        asort($guesses);

        error_log("Chance of guess is " . number_format(((1 - reset($guesses)) * 100), 1) . "%");

        echo array_key_first($guesses) . " " . implode(" ", array_keys($toFlag)) . PHP_EOL;
    } //We just select the first "?" 
    else {
        for($y = 0; $y < 16; ++$y) {
            for($x = 0; $x < 30; ++$x) {
                if($grid[$y][$x] === "?") {
                    echo "$x $y" . PHP_EOL;
                    continue;
                }
            }
        }
    }
}
