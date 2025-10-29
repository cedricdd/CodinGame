<?php

const N = [[0, -1], [1, 0], [0, 1], [-1, 0]];

function setPosition(string $symbol, int $x1, int $y1, array $leftHint, array $topHint, array $rightHint, array $bottomHint, array $board, array $actions): array {
    global $pairs;

    [$x2, $y2] = $pairs[$y1][$x1];

    //We know no magnet get there
    if($symbol == 'x') {
        $board[$y1][$x1] = $symbol;
        $board[$y2][$x2] = $symbol;

        $actions[] = "$x1 $y1 $symbol";
    } //We set a positive/negative
    else {
        //When we set a magnet we alway pass the coordinate of the '+'
        $board[$y1][$x1] = $symbol;

        if($symbol == '+') {
            $board[$y2][$x2] = '-';
            $topHint[$x1]--;
            $leftHint[$y1]--;
            $bottomHint[$x2]--;
            $rightHint[$y2]--;
        } else {
            $board[$y2][$x2] = '+';
            $topHint[$x2]--;
            $leftHint[$y2]--;
            $bottomHint[$x1]--;
            $rightHint[$y1]--;
        }

        $actions[] = "$x1 $y1 $symbol";
    }

    return [$leftHint, $topHint, $rightHint, $bottomHint, $board, $actions];
}

function solve(array $leftHint, array $topHint, array $rightHint, array $bottomHint, array $board, array $actions): ?array {
    global $width, $height, $pairs;

    // error_log(var_export(array_map('implode', $board), 1));
    // error_log(var_export($actions, 1));
    // error_log(implode("-", $leftHint));
    // error_log(implode("-", $topHint));
    // error_log(implode("-", $rightHint));
    // error_log(implode("-", $bottomHint));

    do {
        $positionSet = false;
        $guess = [0, '', []];

        for($y = 0; $y < $height; ++$y) {
            if($leftHint[$y] == 0 || $rightHint[$y] == 0) {
                for($x = 0; $x < $width - 1; ++$x) {
                    if($board[$y][$x] != 'x' && $board[$y][$x] != '-' && $board[$y][$x] != '+' && $board[$y][$x] == $board[$y][$x + 1]) {
                        [$leftHint, $topHint, $rightHint, $bottomHint, $board, $actions] = setPosition('x', $x, $y, $leftHint, $topHint, $rightHint, $bottomHint, $board, $actions);

                        $positionSet = true;
                    }
                }
            }
        }
        for($x = 0; $x < $width; ++$x) {
            if($topHint[$x] == 0 || $bottomHint[$x] == 0) {
                for($y = 0; $y < $height - 1; ++$y) {
                    if($board[$y][$x] != 'x' && $board[$y][$x] != '-' && $board[$y][$x] != '+' && $board[$y][$x] == $board[$y + 1][$x]) {
                        [$leftHint, $topHint, $rightHint, $bottomHint, $board, $actions] = setPosition('x', $x, $y, $leftHint, $topHint, $rightHint, $bottomHint, $board, $actions);

                        $positionSet = true;
                    }
                }
            }
        }

        //Check for forced placement of '+'
        for($y = 0; $y < $height; ++$y) {
            if($leftHint[$y] <= 0) continue;

            $list = [];
            $count = 0;

            for($x = 0; $x < $width; ++$x) {
                if($board[$y][$x] != 'x' && $board[$y][$x] != '-' && $board[$y][$x] != '+') {
                    if($topHint[$x]) {
                        foreach(N as [$xm, $ym]) {
                            if(($board[$y + $ym][$x + $xm] ?? '#') == '+') continue 2;
                        }

                        $list[$board[$y][$x]][] = [$x, $y];
                        ++$count;
                    }
                }
            }

            if($count < $leftHint[$y]) {
                // error_log("we don't have enough left for row $y & + ($count < $leftHint[$y])");
                return null; //We made an invalid guess
            }

            if(count($list) == $leftHint[$y]) {
                foreach($list as $positions) {
                    if(count($positions) == 1) {
                        [$xp, $yp] = array_pop($positions);
                        [$leftHint, $topHint, $rightHint, $bottomHint, $board, $actions] = setPosition('+', $xp, $yp, $leftHint, $topHint, $rightHint, $bottomHint, $board, $actions);

                        $positionSet = true;
                    }
                }
            }

            if($guess[0] < ($v = $leftHint[$y] / $count)) {
                $guess = [$v, '+', $list];
            }
        }

        for($x = 0;  $x < $width; ++$x) {
            if($topHint[$x] <= 0) continue;

            $list = [];
            $count = 0;

            for($y = 0; $y < $height; ++$y) {
                if($board[$y][$x] != 'x' && $board[$y][$x] != '-' && $board[$y][$x] != '+') {
                    if($leftHint[$y]) {
                        foreach(N as [$xm, $ym]) {
                            if(($board[$y + $ym][$x + $xm] ?? '#') == '+') continue 2;
                        }

                        $list[$board[$y][$x]][] = [$x, $y];
                        ++$count;
                    }
                }
            }

            if($count < $topHint[$x]) {
                // error_log("we don't have enough left for col $x & + ($count < $topHint[$x])");
                return null; //We made an invalid guess
            }
            
            if(count($list) == $topHint[$x]) {
                foreach($list as $positions) {
                    if(count($positions) == 1) {
                        [$xp, $yp] = array_pop($positions);
                        [$leftHint, $topHint, $rightHint, $bottomHint, $board, $actions] = setPosition('+', $xp, $yp, $leftHint, $topHint, $rightHint, $bottomHint, $board, $actions);

                        $positionSet = true;
                    }
                }
            } 
            
            if($guess[0] < ($v = $topHint[$x] / $count)) {
                $guess = [$v, '+', $list];
            }
        }

        //Check for forced placement of '-'
        for($y = 0; $y < $height; ++$y) {
            if($rightHint[$y] <= 0) continue;

            $list = [];
            $count = 0;

            for($x = 0; $x < $width; ++$x) {
                if($board[$y][$x] != 'x' && $board[$y][$x] != '-' && $board[$y][$x] != '+') {
                    if($bottomHint[$x]) {
                        foreach(N as [$xm, $ym]) {
                            if(($board[$y + $ym][$x + $xm] ?? '#') == '-') continue 2;
                        }

                        $list[$board[$y][$x]][] = [$x, $y];
                        ++$count;
                    }
                }
            }

            if($count < $rightHint[$y]) {
                // error_log("we don't have enough left for row $y & - ($count < $rightHint[$y])");
                return null; //We made an invalid guess
            }

            if(count($list) == $rightHint[$y]) {
                foreach($list as $positions) {
                    if(count($positions) == 1) {
                        [$xp, $yp] = array_pop($positions);
                        [$leftHint, $topHint, $rightHint, $bottomHint, $board, $actions] = setPosition('-', $xp, $yp, $leftHint, $topHint, $rightHint, $bottomHint, $board, $actions);

                        $positionSet = true;
                    }
                }
            }

            if($guess[0] < ($v = $rightHint[$y] / $count)) {
                $guess = [$v, '-', $list];
            }
        }

        for($x = 0;  $x < $width; ++$x) {
            if($bottomHint[$x] <= 0) continue;

            $list = [];
            $count = 0;

            for($y = 0; $y < $height; ++$y) {
                if($board[$y][$x] != 'x' && $board[$y][$x] != '-' && $board[$y][$x] != '+') {
                    if($rightHint[$y]) {
                        foreach(N as [$xm, $ym]) {
                            if(($board[$y + $ym][$x + $xm] ?? '#') == '-') continue 2;
                        }

                        $list[$board[$y][$x]][] = [$x, $y];
                        ++$count;
                    }
                }
            }

            if($count < $bottomHint[$x]) {
                // error_log("we don't have enough left for col $x & - ($count < $bottomHint[$x])");
                return null; //We made an invalid guess
            }

            if(count($list) == $bottomHint[$x]) {
                foreach($list as $positions) {
                    if(count($positions) == 1) {
                        [$xp, $yp] = array_pop($positions);
                        [$leftHint, $topHint, $rightHint, $bottomHint, $board, $actions] = setPosition('-', $xp, $yp, $leftHint, $topHint, $rightHint, $bottomHint, $board, $actions);

                        $positionSet = true;
                    }
                }
            }

            if($guess[0] < ($v = $bottomHint[$x] / $count)) {
                $guess = [$v, '-', $list];
            }
        }
    } while($positionSet);

    $left = array_sum($leftHint) + array_sum($topHint) + array_sum($rightHint) + array_sum($bottomHint);

    // error_log("We have $left left to found");
    // error_log(var_export(array_map('implode', $board), 1));

    if($left == 0) {
        // error_log("FOUND");
        // error_log(var_export($actions, 1));
        return $actions;
    }

    // error_log(var_export($guess, 1));

    foreach($guess[2] as $letter => $positions) {
        foreach($positions as [$x, $y]) {
            // error_log("guessing " . $guess[1] . " at $x $y");

            $result = solve(...setPosition($guess[1], $x, $y, $leftHint, $topHint, $rightHint, $bottomHint, $board, $actions));

            if($result !== null) return $result;
        }
    }

    return null;
}

fscanf(STDIN, "%d", $width);
fscanf(STDIN, "%d", $height);

$leftHint = explode(" ", trim(fgets(STDIN)));
$topHint = explode(" ", trim(fgets(STDIN)));
$rightHint = explode(" ", trim(fgets(STDIN)));
$bottomHint = explode(" ", trim(fgets(STDIN)));

$board = [];
$start = microtime(1);

for ($i = 0; $i < $height; $i++) {
    $board[] = str_split(trim(fgets(STDIN)));
}

for($y = 0; $y < $height; ++$y) {
    for($x = 0; $x < $width; ++$x) {
        if($board[$y][$x] != 'x') {
            if(($board[$y + 1][$x] ?? 'x') == $board[$y][$x]) {
                $pairs[$y][$x] = [$x, $y + 1];
                $pairs[$y + 1][$x] = [$x, $y];
            }
            if(($board[$y][$x + 1] ?? 'x') == $board[$y][$x]) {
                $pairs[$y][$x] = [$x + 1, $y];
                $pairs[$y][$x + 1] = [$x, $y];
            }
        }
    }
}

echo implode(PHP_EOL, solve($leftHint, $topHint, $rightHint, $bottomHint, $board, [])) . PHP_EOL;
error_log(microtime(1) - $start);
