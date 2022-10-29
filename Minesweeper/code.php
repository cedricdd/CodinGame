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
    $guess = "";
    $guessChance = 1.0;
    $loop = 0;

    do {
        $grid = $turnGrid;
        $neighbors = [];
        $safeCells = [];
        $restartLoop = false;

        //Set all the bombs we already know
        foreach($bombs as $y => $line) {
            foreach($line as $x => $fille) {
                $grid[$y][$x] = "B";
            }
        }

        for($y = 0; $y < 16; ++$y) {
            for($x = 0; $x < 30; ++$x) {
                if(!ctype_digit($grid[$y][$x])) continue;
    
                $bombsToFind = $grid[$y][$x];
                $neighbors[$x . " " . $y] = [];

                for($y2 = max(0, $y - 1); $y2 < min(16, $y + 2); ++$y2) {
                    for($x2 = max(0, $x -1); $x2 < min(30, $x + 2); ++$x2) {
                        if($grid[$y2][$x2] === "B") --$bombsToFind;
                        elseif($grid[$y2][$x2] === "?") $neighbors[$x . " " . $y][] = [$x2, $y2];
                    }
                }

                if($bombsToFind == 0) {
                    if(count($neighbors[$x . " " . $y]) > 0) {
                        foreach($neighbors[$x . " " . $y] as [$xs, $ys]) {
                            $safeCells["$xs $ys"] = 1;
                        }
                    }
                }
                else {
                    if($bombsToFind == count($neighbors[$x . " " . $y])) {
                        foreach($neighbors[$x . " " . $y] as [$x2, $y2]) {
                            $bombs[$y2][$x2] = 1;
                            $toFlag["$x2 $y2"] = 1;
                            $restartLoop = false;
                        }
        
                        $bombsToFind = 0;
                    } elseif(($bombsToFind / count($neighbors[$x . " " . $y])) < $guessChance) {
                        //error_log("using $x $y as guess");
                        $guessChance = $bombsToFind / count($neighbors[$x . " " . $y]);
                        [$x2, $y2] = reset($neighbors[$x . " " . $y]);
                        $guess = "$x2 $y2";
                    }
                }
                
                $grid[$y][$x] = $bombsToFind;
            }
        }

        for($y = 0; $y < 16; ++$y) {
            //1-2-1 pattern in horizontal
            if(preg_match("/121/", implode("", $grid[$y]), $match, PREG_OFFSET_CAPTURE)) {
                error_log("$y -- 1-2-1");
                error_log(var_export($match, true));
    
                $x = $match[0][1];
                $top1 = ($y > 0 && $grid[$y - 1][$x] === "?");
                $top2 = ($y > 0 && $grid[$y - 1][$x + 2] === "?");
                $bottom1 = ($y < 15 && $grid[$y + 1][$x] === "?");
                $bottom2 = ($y < 15 && $grid[$y + 1][$x + 2] === "?");
    
                //We know where the bombs are
                if($top1 + $top2 + $bottom1 + $bottom2 == 2) {
                    error_log("bombs found at $top1 $top2 $bottom1 $bottom2");

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

            //1-2-2-1 pattern in horizontal
            if(preg_match("/1221/", implode("", $grid[$y]), $match, PREG_OFFSET_CAPTURE)) {
                error_log("$y -- 1-2-2-1 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
                error_log(var_export($match, true));
    
                $x = $match[0][1];
                $top1 = ($y > 0 && $grid[$y - 1][$x + 1] === "?");
                $top2 = ($y > 0 && $grid[$y - 1][$x + 2] === "?");
                $bottom1 = ($y < 15 && $grid[$y + 1][$x + 1] === "?");
                $bottom2 = ($y < 15 && $grid[$y + 1][$x + 2] === "?");
    
                //We know where the bombs are
                if($top1 + $top2 + $bottom1 + $bottom2 == 2) {
                    error_log("bombs found at $top1 $top2 $bottom1 $bottom2");

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
            //1-2-1 pattern in vertical
            if(preg_match("/121/", implode("", array_column($grid, $x)), $match, PREG_OFFSET_CAPTURE)) {
                error_log("$x -- 1-2-1");
                error_log(var_export($match, true));
    
                $y = $match[0][1];
                $left1 = ($x > 0 && $grid[$y][$x - 1] === "?");
                $left2 = ($x > 0 && $grid[$y + 2][$x - 1] === "?");
                $right1 = ($x < 30 && $grid[$y][$x + 1] === "?");
                $right2 = ($x < 30 && $grid[$y + 2][$x + 1] === "?");
    
                //We know where the bombs are
                if($left1 + $left2 + $right1 + $right2 == 2) {
                    error_log("bombs found at $left1 $left2 $right1 $right2");

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

            //1-2-1 pattern in vertical
            if(preg_match("/1221/", implode("", array_column($grid, $x)), $match, PREG_OFFSET_CAPTURE)) {
                error_log("$x -- 1-2-2-1 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
                error_log(var_export($match, true));
    
                $y = $match[0][1];
                $left1 = ($x > 0 && $grid[$y + 1][$x - 1] === "?");
                $left2 = ($x > 0 && $grid[$y + 2][$x - 1] === "?");
                $right1 = ($x < 30 && $grid[$y + 1][$x + 1] === "?");
                $right2 = ($x < 30 && $grid[$y + 2][$x + 1] === "?");
    
                //We know where the bombs are
                if($left1 + $left2 + $right1 + $right2 == 2) {
                    error_log("bombs found at $left1 $left2 $right1 $right2");

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
                //error_log("we need to check $x $y!!!!!!!!!!!!");
            }
        }
    } while($restartLoop);

    error_log(var_export(implode("\n", array_map(function($line) {
        return implode("", $line);
    }, $grid)), true)); 

    if(count($safeCells) > 0) {
        error_log("we have " . count($safeCells) . " safe cells");
        //error_log(var_export($safeCells, true));

        echo array_key_first($safeCells) . " " . implode(" ", array_keys($toFlag)) . PHP_EOL;
    } elseif(!empty($guess)) {
        error_log("guess is $guess $guessChance");

        echo $guess . " " . implode(" ", array_keys($toFlag)) . PHP_EOL;
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
