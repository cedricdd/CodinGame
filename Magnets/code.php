<?php

const N = [[0, -1], [1, 0], [0, 1], [-1, 0]];

function setPosition(string $symbol, int $x1, int $y1, array $leftHint, array $topHint, array $rightHint, array $bottomHint, int $toFind, array $board, array $actions): array {
    global $pairs;

    [$x2, $y2] = $pairs[$y1 . ';' . $x1];

    $board[$y1][$x1] = $symbol;

    //We know no magnet get there
    if($symbol == 'x') {
        $board[$y2][$x2] = $symbol;
    } //We set a positive/negative
    else {
        if($symbol == '+') {
            $board[$y2][$x2] = '-';
            isset($topHint[$x1]) && $topHint[$x1]-- && $toFind--;
            isset($leftHint[$y1]) && $leftHint[$y1]-- && $toFind--;
            isset($bottomHint[$x2]) && $bottomHint[$x2]-- && $toFind--;
            isset($rightHint[$y2]) && $rightHint[$y2]-- && $toFind--;
        } else {
            $board[$y2][$x2] = '+';
            isset($topHint[$x2]) && $topHint[$x2]-- && $toFind--;
            isset($leftHint[$y2]) && $leftHint[$y2]-- && $toFind--;
            isset($bottomHint[$x1]) && $bottomHint[$x1]-- && $toFind--;
            isset($rightHint[$y1]) && $rightHint[$y1]-- && $toFind--;
        }
    }

    $actions[] = "$x1 $y1 $symbol";

    return [$leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions];
}

function solve(array $leftHint, array $topHint, array $rightHint, array $bottomHint, int  $toFind, array $board, array $actions): ?array {
    global $width, $height, $pairs;

    do {
        $positionSet = false;
        $guess = [0, '', []];

        for($y = 0; $y < $height; ++$y) {
            //If the left or right hint is 0, any pairs fully on that row that's left are x
            if(($leftHint[$y] ?? 1) == 0 || ($rightHint[$y] ?? 1) == 0) {
                for($x = 0; $x < $width - 1; ++$x) {
                    if($board[$y][$x] != 'x' && $board[$y][$x] != '-' && $board[$y][$x] != '+' && $board[$y][$x] == $board[$y][$x + 1]) {
                        [$leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions] = setPosition('x', $x, $y, $leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions);

                        $positionSet = true;
                    }
                }
            }
        }
        for($x = 0; $x < $width; ++$x) {
            //If the top or bottom hint is 0, any pairs fully on that col that's left are x
            if(($topHint[$x] ?? 1) == 0 || ($bottomHint[$x] ?? 1) == 0) {
                for($y = 0; $y < $height - 1; ++$y) {
                    if($board[$y][$x] != 'x' && $board[$y][$x] != '-' && $board[$y][$x] != '+' && $board[$y][$x] == $board[$y + 1][$x]) {
                        [$leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions] = setPosition('x', $x, $y, $leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions);

                        $positionSet = true;
                    }
                }
            }
        }

        //Check for forced placement of '+' on rows
        for($y1 = 0; $y1 < $height; ++$y1) {
            if(!isset($leftHint[$y1]) ||  $leftHint[$y1] == 0) continue;

            $list = [];
            $count = 0;

            for($x1 = 0; $x1 < $width; ++$x1) {
                if($board[$y1][$x1] != 'x' && $board[$y1][$x1] != '-' && $board[$y1][$x1] != '+') {
                    [$x2, $y2] = $pairs[$y1 . ';' . $x1];

                    if(($topHint[$x1] ?? 1) && ($leftHint[$y1] ?? 1) && ($bottomHint[$x2] ?? 1) && ($rightHint[$y2] ?? 1)) {
                        foreach(N as [$xm, $ym]) {
                            if(($board[$y1 + $ym][$x1 + $xm] ?? '#') == '+') continue 2;
                            if(($board[$y2 + $ym][$x2 + $xm] ?? '#') == '-') continue 2;
                        }

                        $list[$board[$y1][$x1]][] = [$x1, $y1];
                        ++$count;
                    }
                }
            }

            if($count < $leftHint[$y1])return null; //We made an invalid guess

            if(count($list) == $leftHint[$y1]) {
                foreach($list as $positions) {
                    if(count($positions) == 1) {
                        [$xp, $yp] = array_pop($positions);
                        [$leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions] = setPosition('+', $xp, $yp, $leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions);

                        $positionSet = true;
                    }
                }
            }

            if($guess[0] < ($v = $leftHint[$y1] / $count)) $guess = [$v, '+', $list]; //Our new best guess
        }

        //Check for forced placement of '+' on cols
        for($x1 = 0;  $x1 < $width; ++$x1) {
            if(!isset($topHint[$x1]) ||  $topHint[$x1] == 0) continue;

            $list = [];
            $count = 0;

            for($y1 = 0; $y1 < $height; ++$y1) {
                if($board[$y1][$x1] != 'x' && $board[$y1][$x1] != '-' && $board[$y1][$x1] != '+') {
                    [$x2, $y2] = $pairs[$y1 . ';' . $x1];

                    if(($topHint[$x1] ?? 1) && ($leftHint[$y1] ?? 1) && ($bottomHint[$x2] ?? 1) && ($rightHint[$y2] ?? 1)) {
                        foreach(N as [$xm, $ym]) {
                            if(($board[$y1 + $ym][$x1 + $xm] ?? '#') == '+') continue 2;
                            if(($board[$y2 + $ym][$x2 + $xm] ?? '#') == '-') continue 2;
                        }

                        $list[$board[$y1][$x1]][] = [$x1, $y1];
                        ++$count;
                    }
                }
            }

            if($count < $topHint[$x1]) return null; //We made an invalid guess
            
            if(count($list) == $topHint[$x1]) {
                foreach($list as $positions) {
                    if(count($positions) == 1) {
                        [$xp, $yp] = array_pop($positions);
                        [$leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions] = setPosition('+', $xp, $yp, $leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions);

                        $positionSet = true;
                    }
                }
            } 
            
            if($guess[0] < ($v = $topHint[$x1] / $count)) $guess = [$v, '+', $list]; //Our new best guess
        }

        //Check for forced placement of '-' on rows
        for($y1 = 0; $y1 < $height; ++$y1) {
            if(!isset($rightHint[$y1]) ||  $rightHint[$y1] == 0) continue;

            $list = [];
            $count = 0;

            for($x1 = 0; $x1 < $width; ++$x1) {
                if($board[$y1][$x1] != 'x' && $board[$y1][$x1] != '-' && $board[$y1][$x1] != '+') {
                    [$x2, $y2] = $pairs[$y1 . ';' . $x1];

                    if(($topHint[$x2] ?? 1) && ($leftHint[$y2] ?? 1) && ($bottomHint[$x1] ?? 1) && ($rightHint[$y1] ?? 1)) {
                        foreach(N as [$xm, $ym]) {
                            if(($board[$y1 + $ym][$x1 + $xm] ?? '#') == '-') continue 2;
                            if(($board[$y2 + $ym][$x2 + $xm] ?? '#') == '+') continue 2;
                        }

                        $list[$board[$y1][$x1]][] = [$x1, $y1];
                        ++$count;
                    }
                }
            }

            if($count < $rightHint[$y1]) return null; //We made an invalid guess

            if(count($list) == $rightHint[$y1]) {
                foreach($list as $positions) {
                    if(count($positions) == 1) {
                        [$xp, $yp] = array_pop($positions);
                        [$leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions] = setPosition('-', $xp, $yp, $leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions);

                        $positionSet = true;
                    }
                }
            }

            if($guess[0] < ($v = $rightHint[$y1] / $count)) $guess = [$v, '-', $list]; //Our new best guess
        }

        //Check for forced placement of '-' on cols
        for($x1 = 0;  $x1 < $width; ++$x1) {
            if(!isset($bottomHint[$x1]) ||  $bottomHint[$x1] == 0) continue;

            $list = [];
            $count = 0;

            for($y1 = 0; $y1 < $height; ++$y1) {
                if($board[$y1][$x1] != 'x' && $board[$y1][$x1] != '-' && $board[$y1][$x1] != '+') {
                    [$x2, $y2] = $pairs[$y1 . ';' . $x1];

                    if(($topHint[$x2] ?? 1) && ($leftHint[$y2] ?? 1) && ($bottomHint[$x1] ?? 1) && ($rightHint[$y1] ?? 1)) {
                        foreach(N as [$xm, $ym]) {
                            if(($board[$y1 + $ym][$x1 + $xm] ?? '#') == '-') continue 2;
                            if(($board[$y2 + $ym][$x2 + $xm] ?? '#') == '+') continue 2;
                        }

                        $list[$board[$y1][$x1]][] = [$x1, $y1];
                        ++$count;
                    }
                }
            }

            if($count < $bottomHint[$x1]) return null; //We made an invalid guess

            if(count($list) == $bottomHint[$x1]) {
                foreach($list as $positions) {
                    if(count($positions) == 1) {
                        [$xp, $yp] = array_pop($positions);
                        [$leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions] = setPosition('-', $xp, $yp, $leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions);

                        $positionSet = true;
                    }
                }
            }

            if($guess[0] < ($v = $bottomHint[$x1] / $count)) $guess = [$v, '-', $list]; //Our new best guess
        }
    } while($positionSet);

    if($toFind == 0) {
        foreach($pairs as $key => [$x, $y]) {
            if($board[$y][$x] == 'x' || $board[$y][$x] == '-' || $board[$y][$x] == '+') continue;

            [$leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions] = setPosition('x', $x, $y, $leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions);
        }

        return $actions;
    }

    foreach($guess[2] as $letter => $positions) {
        foreach($positions as [$x, $y]) {
            $result = solve(...setPosition($guess[1], $x, $y, $leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, $actions));

            if($result !== null) return $result;
        }
    }

    return null;
}

fscanf(STDIN, "%d", $width);
fscanf(STDIN, "%d", $height);

$board = [];
$toFind = 0;
$start = microtime(1);

foreach(['leftHint', 'topHint', 'rightHint', 'bottomHint'] as $name) {
    $inputs = explode(" ", trim(fgets(STDIN)));
    $$name = array_filter($inputs, function($v) {
        return $v != -1;
    });

    $toFind += array_sum($$name);
}

for ($i = 0; $i < $height; $i++) {
    $board[] = str_split(trim(fgets(STDIN)));
}

for($y = 0; $y < $height; ++$y) {
    for($x = 0; $x < $width; ++$x) {
        if($board[$y][$x] != 'x') {
            if(($board[$y + 1][$x] ?? 'x') == $board[$y][$x]) {
                $pairs[$y . ';' . $x] = [$x, $y + 1];
                $pairs[($y + 1) . ';' . $x] = [$x, $y];
            }
            if(($board[$y][$x + 1] ?? 'x') == $board[$y][$x]) {
                $pairs[$y . ';' . $x] = [$x + 1, $y];
                $pairs[$y . ';' . ($x + 1)] = [$x, $y];
            }
        }
    }
}

echo implode(PHP_EOL, solve($leftHint, $topHint, $rightHint, $bottomHint, $toFind, $board, [])) . PHP_EOL;
error_log(microtime(1) - $start);
