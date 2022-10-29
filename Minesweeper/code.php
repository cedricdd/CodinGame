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
                if(!ctype_digit($grid[$y][$x])) continue;
    
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
                        foreach($neighbors[$x . " " . $y] as [$xs, $ys]) {
                            $safePositions["$xs $ys"] = 1;
                        }
                    }
                }
                //We don't already know where all the bombs are located
                else {
                    //The # of "?" in neighbors is the same as the # of bombs still to find, it's all bombs 
                    if($bombsToFind == count($neighbors[$x . " " . $y])) {
                        foreach($neighbors[$x . " " . $y] as [$x2, $y2]) {
                            $bombs[$y2][$x2] = 1;
                            $toFlag["$x2 $y2"] = 1;
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
            }
        }

        for($y = 0; $y < 16; ++$y) {
            //1-2-1 pattern in horizontal -- bombs are above or below the 1s
            if(preg_match("/121/", implode("", $grid[$y]), $match, PREG_OFFSET_CAPTURE)) {

                $x = $match[0][1];
                $top1 = ($y > 0 && $grid[$y - 1][$x] === "?");
                $top2 = ($y > 0 && $grid[$y - 1][$x + 2] === "?");
                $bottom1 = ($y < 15 && $grid[$y + 1][$x] === "?");
                $bottom2 = ($y < 15 && $grid[$y + 1][$x + 2] === "?");
    
                //We know where the bombs are
                if($top1 + $top2 + $bottom1 + $bottom2 == 2) {
                    if($top1 == true) {
                        $bombs[$y - 1][$x] = 1;
                        $toFlag[$x . " " . ($y - 1)] = 1;
                    }
                    if($top2 == true) {
                        $bombs[$y - 1][$x + 2] = 1;
                        $toFlag[($x + 2) . " " . ($y - 1)] = 1;
                    }
                    if($bottom1 == true) {
                         $bombs[$y + 1][$x] = 1;
                         $toFlag[$x . " " . ($y + 1)] = 1;
                    }
                    if($bottom2 == true) {
                         $bombs[$y + 1][$x + 2] = 1;
                         $toFlag[($x + 2) . " " . ($y + 1)] = 1;
                    }
    
                    $restartLoop = true;
                }
            }

            //1-2-2-1 pattern in horizontal -- bombs are above or below the 2s
            if(preg_match("/1221/", implode("", $grid[$y]), $match, PREG_OFFSET_CAPTURE)) {

                $x = $match[0][1];
                $top1 = ($y > 0 && $grid[$y - 1][$x + 1] === "?");
                $top2 = ($y > 0 && $grid[$y - 1][$x + 2] === "?");
                $bottom1 = ($y < 15 && $grid[$y + 1][$x + 1] === "?");
                $bottom2 = ($y < 15 && $grid[$y + 1][$x + 2] === "?");
    
                //We know where the bombs are
                if($top1 + $top2 + $bottom1 + $bottom2 == 2) {
                    if($top1 == true) {
                        $bombs[$y - 1][$x + 1] = 1;
                        $toFlag[($x + 1) . " " . ($y - 1)] = 1;
                    }
                    if($top2 == true) {
                        $bombs[$y - 1][$x + 2] = 1;
                        $toFlag[($x + 2) . " " . ($y - 1)] = 1;
                    }
                    if($bottom1 == true) {
                         $bombs[$y + 1][$x + 1] = 1;
                         $toFlag[($x + 1) . " " . ($y + 1)] = 1;
                    }
                    if($bottom2 == true) {
                         $bombs[$y + 1][$x + 2] = 1;
                         $toFlag[($x + 2) . " " . ($y + 1)] = 1;
                    }
    
                    $restartLoop = true;
                }
            }
        }

        for($x = 0; $x < 30; ++$x) {
            //1-2-1 pattern in vertical -- bombs are above or below the 1s
            if(preg_match("/121/", implode("", array_column($grid, $x)), $match, PREG_OFFSET_CAPTURE)) {

                $y = $match[0][1];
                $left1 = ($x > 0 && $grid[$y][$x - 1] === "?");
                $left2 = ($x > 0 && $grid[$y + 2][$x - 1] === "?");
                $right1 = ($x < 30 && $grid[$y][$x + 1] === "?");
                $right2 = ($x < 30 && $grid[$y + 2][$x + 1] === "?");
    
                //We know where the bombs are
                if($left1 + $left2 + $right1 + $right2 == 2) {
                    if($left1 == true) {
                        $bombs[$y][$x - 1] = 1;
                        $toFlag[($x - 1) . " " . $y] = 1;
                    }
                    if($left2 == true) {
                        $bombs[$y + 2][$x - 1] = 1;
                        $toFlag[($x - 1) . " " . ($y + 2)] = 1;
                    }
                    if($right1 == true) {
                         $bombs[$y][$x + 1] = 1;
                         $toFlag[($x + 1) . " " . $y] = 1;
                    }
                    if($right2 == true) {
                         $bombs[$y + 2][$x + 1] = 1;
                         $toFlag[($x + 1) . " " . ($y + 2)] = 1;
                    }
    
                    $restartLoop = true;
                }
            }

            //1-2-2-1 pattern in vertical -- bombs are above or below the 2s
            if(preg_match("/1221/", implode("", array_column($grid, $x)), $match, PREG_OFFSET_CAPTURE)) {
                $y = $match[0][1];
                $left1 = ($x > 0 && $grid[$y + 1][$x - 1] === "?");
                $left2 = ($x > 0 && $grid[$y + 2][$x - 1] === "?");
                $right1 = ($x < 30 && $grid[$y + 1][$x + 1] === "?");
                $right2 = ($x < 30 && $grid[$y + 2][$x + 1] === "?");
    
                //We know where the bombs are
                if($left1 + $left2 + $right1 + $right2 == 2) {
                    if($left1 == true) {
                        $bombs[$y + 1][$x - 1] = 1;
                        $toFlag[($x - 1) . " " . ($y + 1)] = 1;
                    }
                    if($left2 == true) {
                        $bombs[$y + 2][$x - 1] = 1;
                        $toFlag[($x - 1) . " " . ($y + 2)] = 1;
                    }
                    if($right1 == true) {
                         $bombs[$y + 1][$x + 1] = 1;
                         $toFlag[($x + 1) . " " . ($y + 1)] = 1;
                    }
                    if($right2 == true) {
                         $bombs[$y + 2][$x + 1] = 1;
                         $toFlag[($x + 1) . " " . ($y + 2)] = 1;
                    }
    
                    $restartLoop = true;
                }
            }
        }
    
        foreach($neighbors as $position => $list) {
            [$x, $y] = explode(" ", $position);
            if(($grid[$y][$x] == 1 && count($list) == 2) || ($grid[$y][$x] == 2 && count($list) == 3)) {

                //We check the neighbors of the current position
                for($y2 = max(0, $y - 2); $y2 < min(16, $y + 3); ++$y2) {
                    for($x2 = max(0, $x - 2); $x2 < min(30, $x + 3); ++$x2) {
                        //It needs to have at least one unfound bombs and have more neighbors unknow
                        if($grid[$y2][$x2] > 0 && count($neighbors[$x2 . " " . $y2]) > count($list)) {
                            $neighborsDifference = $neighbors[$x2 . " " . $y2];

                            //All the neighbors of the first position needs to also be neighbors of the second postion
                            foreach($list as [$nx, $ny]) {
                                if(isset($neighborsDifference[$nx . " " . $ny])) unset($neighborsDifference[$nx . " " . $ny]);
                                else continue 2;
                            }

                            $updatedCount = $grid[$y2][$x2] - $grid[$y][$x];

                            //The neighbors that are left are all safe positions
                            if($updatedCount == 0) {
                                foreach($neighborsDifference as [$xs, $ys]) {
                                    $safePositions["$xs $ys"] = 1;
                                }

                            } //The neighbors that are left are all bombs
                            elseif($updatedCount == count($neighborsDifference)) {
                                foreach($neighborsDifference as [$xs, $ys]) {
                                    $bombs[$ys][$xs] = 1;
                                    $toFlag["$xs $ys"] = 1;
                                }

                                $restartLoop = true;
                            }
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
    } //We use the safest guess 
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
