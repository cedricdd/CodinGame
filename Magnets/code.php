<?php

const N = [[0, -1], [1, 0], [0, 1], [-1, 0]];

function solve(array $leftHint, array $topHint, array $rightHint, array $bottomHint, array $board, array $actions): ?array {
    global $width, $height;

    if(array_sum($leftHint) + array_sum($topHint) + array_sum($rightHint) + array_sum($bottomHint) == 0) return $actions;

    $i = count($actions);

    error_log(var_export($board, 1));
    error_log(var_export($actions, 1));

    for($y = 0; $y < $height; ++$y) {
        if($leftHint[$y] == 0 || $rightHint[$y] == 0) {
            for($x = 0; $x < $width - 1; ++$x) {
                if($board[$y][$x] != 'x' && $board[$y][$x] != '-' && $board[$y][$x] != '+' && $board[$y][$x] == $board[$y][$x + 1]) {
                    $board[$y][$x] = $board[$y][$x + 1] = 'x';
                }
            }
        }
    }

    for($x = 0; $x < $width; ++$x) {
        if($topHint[$x] == 0 || $bottomHint[$x] == 0) {
            for($y = 0; $y < $height - 1; ++$y) {
                if($board[$y][$x] != 'x' && $board[$y][$x] != '-' && $board[$y][$x] != '+' && $board[$y][$x] == $board[$y + 1][$x]) {
                    $board[$y][$x] = $board[$y + 1][$x] = 'x';
                }
            }
        }
    }

    for($y = 0; $y < $height; ++$y) {
        for($x = 0; $x < $width; ++$x) {
            if($board[$y][$x] == 'x' || $board[$y][$x] == '-' || $board[$y][$x] == '+') continue;
            $c = $board[$y][$x];

            if($x < $width - 1 && $board[$y][$x] == $board[$y][$x + 1]) {
                //Try +-
                if($topHint[$x] && $leftHint[$y] && $bottomHint[$x + 1] && $rightHint[$y]) {
                    $goodNeighbors = true;

                    foreach(N as [$xm, $ym]) {
                        $xu = $x + $xm;
                        $yu = $y + $ym;

                        if($xu >= 0 && $xu < $width && $yu >= 0 && $yu < $height && $board[$yu][$xu] == '+') {
                            $goodNeighbors = false;
                            break;
                        }
                        if($xu + 1 >= 0 && $xu + 1 < $width && $yu >= 0 && $yu < $height && $board[$yu][$xu + 1] == '-') {
                            $goodNeighbors = false;
                            break;
                        }
                    }

                    if($goodNeighbors) {
                        $topHint[$x]--;
                        $leftHint[$y]--;
                        $bottomHint[$x + 1]--;
                        $rightHint[$y]--;
                        $board[$y][$x] = '+';
                        $board[$y][$x + 1] = '-';

                        if($result = solve($leftHint, $topHint, $rightHint, $bottomHint, $board, $actions + [$i => "$x $y +"])) return $return;

                        $board[$y][$x] = $c;
                        $board[$y][$x + 1] = $c;
                        $topHint[$x]++;
                        $leftHint[$y]++;
                        $bottomHint[$x + 1]++;
                        $rightHint[$y]++;
                    }
                }
                //Try -+
                if($topHint[$x + 1] && $leftHint[$y] && $bottomHint[$x] && $rightHint[$y]) {
                    $goodNeighbors = true;

                    foreach(N as [$xm, $ym]) {
                        $xu = $x + $xm;
                        $yu = $y + $ym;

                        if($xu >= 0 && $xu < $width && $yu >= 0 && $yu < $height && $board[$yu][$xu] == '-') {
                            $goodNeighbors = false;
                            break;
                        }
                        if($xu + 1 >= 0 && $xu + 1 < $width && $yu >= 0 && $yu < $height && $board[$yu][$xu + 1] == '+') {
                            $goodNeighbors = false;
                            break;
                        }
                    }

                    if($goodNeighbors) {
                        $topHint[$x + 1]--;
                        $leftHint[$y]--;
                        $bottomHint[$x]--;
                        $rightHint[$y]--;
                        $board[$y][$x] = '-';
                        $board[$y][$x + 1] = '+';

                        if($result = solve($leftHint, $topHint, $rightHint, $bottomHint, $board, $actions + [$i => "$x $y -"])) return $return;

                        $board[$y][$x] = $c;
                        $board[$y][$x + 1] = $c;
                        $topHint[$x + 1]++;
                        $leftHint[$y]++;
                        $bottomHint[$x]++;
                        $rightHint[$y]++;
                    }
                }

                //We don't put anything here
                $board[$y][$x] = 'x';
                $board[$y][$x + 1] = 'x';

                return solve($leftHint, $topHint, $rightHint, $bottomHint, $board, $actions);
            }

            if($y < $heigth - 1 && $board[$y][$x] == $board[$y + 1][$x]) {
                /**
                 * Try
                 * +
                 * -
                 */
                if($topHint[$x] && $leftHint[$y] && $bottomHint[$x] && $rightHint[$y + 1]) {
                    $goodNeighbors = true;

                    foreach(N as [$xm, $ym]) {
                        $xu = $x + $xm;
                        $yu = $y + $ym;

                        if($xu >= 0 && $xu < $width && $yu >= 0 && $yu < $height && $board[$yu][$xu] == '+') {
                            $goodNeighbors = false;
                            break;
                        }
                        if($xu >= 0 && $xu < $width && $yu + 1 >= 0 && $yu + 1 < $height && $board[$yu + 1][$xu] == '-') {
                            $goodNeighbors = false;
                            break;
                        }
                    }

                    if($goodNeighbors) {
                        $topHint[$x]--;
                        $leftHint[$y]--;
                        $bottomHint[$x]--;
                        $rightHint[$y + 1]--;
                        $board[$y][$x] = '+';
                        $board[$y + 1][$x] = '-';

                        if($result = solve($leftHint, $topHint, $rightHint, $bottomHint, $board, $actions + [$i => "$x $y +"])) return $return;

                        $board[$y][$x] = $c;
                        $board[$y + 1][$x] = $c;
                        $topHint[$x]++;
                        $leftHint[$y]++;
                        $bottomHint[$x]++;
                        $rightHint[$y + 1]++;
                    }
                }

                /**
                 * Try
                 * -
                 * +
                 */
                if($topHint[$x] && $leftHint[$y + 1] && $bottomHint[$x] && $rightHint[$y]) {
                    $goodNeighbors = true;

                    foreach(N as [$xm, $ym]) {
                        $xu = $x + $xm;
                        $yu = $y + $ym;

                        if($xu >= 0 && $xu < $width && $yu >= 0 && $yu < $height && $board[$yu][$xu] == '-') {
                            $goodNeighbors = false;
                            break;
                        }
                        if($xu >= 0 && $xu < $width && $yu + 1 >= 0 && $yu + 1 < $height && $board[$yu + 1][$xu] == '+') {
                            $goodNeighbors = false;
                            break;
                        }
                    }

                    if($goodNeighbors) {
                        $topHint[$x]--;
                        $leftHint[$y + 1]--;
                        $bottomHint[$x]--;
                        $rightHint[$y]--;
                        $board[$y][$x] = '-';
                        $board[$y + 1][$x] = '+';

                        if($result = solve($leftHint, $topHint, $rightHint, $bottomHint, $board, $actions + [$i => "$x $y -"])) return $return;

                        $board[$y][$x] = $c;
                        $board[$y + 1][$x] = $c;
                        $topHint[$x]++;
                        $leftHint[$y + 1]++;
                        $bottomHint[$x]++;
                        $rightHint[$y]++;
                    }
                }

                //We don't put anything here
                $board[$y][$x] = 'x';
                $board[$y + 1][$x] = 'x';

                return solve($leftHint, $topHint, $rightHint, $bottomHint, $board, $actions);
            }

            return null;
        }
    }
}

fscanf(STDIN, "%d", $width);
fscanf(STDIN, "%d", $height);

$leftHint = explode(" ", trim(fgets(STDIN)));
$topHint = explode(" ", trim(fgets(STDIN)));
$rightHint = explode(" ", trim(fgets(STDIN)));
$bottomHint = explode(" ", trim(fgets(STDIN)));

// game loop
while (TRUE) {
    $board = [];

    for ($i = 0; $i < $height; $i++) {
        fscanf(STDIN, "%s", $board[]);
    }

    error_log(var_export($board, true));

    echo implode(PHP_EOL, solve($leftHint, $topHint, $rightHint, $bottomHint, $board, []));
}
