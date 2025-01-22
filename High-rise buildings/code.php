<?php

//We have found a solution, check if the numbers of towers we can see are matching
function checkSolution(array $cells): bool {
    global $canSeeFromNorth, $canSeeFromSouth, $canSeeFromEast, $canSeeFromWest, $N;

    //Check North
    foreach($canSeeFromNorth as $x => $v) {
        $current = 0;
        $total = 0;

        for($y = 0; $y < $N; ++$y) {
            if($cells[$y][$x] > $current) {
                $current = $cells[$y][$x];
                ++$total;
            }
        }

        if($total != $v) return false;
    }

    //Check South
    foreach($canSeeFromSouth as $x => $v) {
        $current = 0;
        $total = 0;

        for($y = $N - 1; $y >= 0; --$y) {
            if($cells[$y][$x] > $current) {
                $current = $cells[$y][$x];
                ++$total;
            }
        }

        if($total != $v) return false;
    }

    //Check West
    foreach($canSeeFromWest as $y => $v) {
        $current = 0;
        $total = 0;

        for($x = 0; $x < $N; ++$x) {
            if($cells[$y][$x] > $current) {
                $current = $cells[$y][$x];
                ++$total;
            }
        }

        if($total != $v) return false;
    }

    //Check East
    foreach($canSeeFromEast as $y => $v) {
        $current = 0;
        $total = 0;

        for($x = $N - 1; $x >= 0; --$x) {
            if($cells[$y][$x] > $current) {
                $current = $cells[$y][$x];
                ++$total;
            }
        }

        if($total != $v) return false;
    }

    return true;
}

function solve(array $possibilities, array $counts, array $cells) {
    global $updates, $N, $start;

    //We have placed a number in each cell
    if(!$counts) {
        if(checkSolution($cells)) {
            echo implode(PHP_EOL, array_map(function($line) {
                return implode(" ", $line);
            }, $cells)) . PHP_EOL;

            error_log(microtime(1) - $start);
            exit();
        }

        return;
    }

    //Work on the position with the less possibilites
    $bestIndex = null;
    $bestCount = PHP_INT_MAX;

    foreach($counts as $index => $count) {
        if($count < $bestCount) {
            $bestCount = $count;
            $bestIndex = $index;
        }
    }

    foreach($possibilities[$bestIndex] as $value => $filler) {
        $possibilities2 = $possibilities;
        $counts2 = $counts;
        $cells2 = $cells;

        unset($possibilities2[$bestIndex]);
        unset($counts2[$bestIndex]);

        //Each row & column can only contain each number once
        foreach($updates[$bestIndex] as $updateIndex) {
            if(isset($possibilities2[$updateIndex][$value])) {
                unset($possibilities2[$updateIndex][$value]);

                if(--$counts2[$updateIndex] == 0) continue 2;
            }
        }

        $cells2[intdiv($bestIndex, $N)][$bestIndex % $N] = $value;

        // error_log("setting $value at $bestIndex");
        // error_log(var_export(implode(PHP_EOL, array_map(function($line) {
        //     return implode(" ", $line);
        // }, $cells2)), 1));

        solve($possibilities2, $counts2, $cells2);
    }
}

$start = microtime(1);

fscanf(STDIN, "%d", $N);

for($y = 0; $y < $N; ++$y) {
    for($x = 0; $x < $N; ++$x) {
        $index = $y * $N + $x;

        $possibilities[$index] = array_fill(1, $N, 1);

        //All the positions we need to update when we set the number here
        for($y2 = $y - 1; $y2 >= 0; --$y2) $updates[$index][] = $y2 * $N + $x; //To the top
        for($y2 = $y + 1; $y2 < $N; ++$y2) $updates[$index][] = $y2 * $N + $x; //To the bottom
        for($x2 = $x - 1; $x2 >= 0; --$x2) $updates[$index][] = $y * $N + $x2; //To the left
        for($x2 = $x + 1; $x2 < $N; ++$x2) $updates[$index][] = $y * $N + $x2; //To the right
    }
}

$canSeeFromNorth = explode(" ", trim(fgets(STDIN)));

//Update the possibilites based on the clues
foreach($canSeeFromNorth as $x => $value) {
    if($value == 1) {
        $possibilities[$x] = [$N => 1];
    } else {
        for($i = 0; $i < $N; ++$i) {
            if($value <= $i + 1) continue 2;
    
            for($y = 0; $y < $value - $i - 1; ++$y) {
                unset($possibilities[$y * $N + $x][$N - $i]);
            }
        }
    }
}

$canSeeFromWest = explode(" ", trim(fgets(STDIN)));

//Update the possibilites based on the clues
foreach($canSeeFromWest as $y => $value) {
    if($value == 1) {
        $possibilities[$y * $N] = [$N => 1];
    } else {
        for($i = 0; $i < $N; ++$i) {
            if($value <= $i + 1) continue 2;

            for($x = 0; $x < $value - $i - 1; ++$x) {
                unset($possibilities[$y * $N + $x][$N - $i]);
            }
        }
    }
}

$canSeeFromEast = explode(" ", trim(fgets(STDIN)));

//Update the possibilites based on the clues
foreach($canSeeFromEast as $y => $value) {
    if($value == 1) {
        $possibilities[$y * $N + $N - 1] = [$N => 1];
    } else {
        for($i = 0; $i < $N; ++$i) {
            if($value <= $i + 1) continue 2;
    
            for($x = 1; $x < $value - $i; ++$x) {
                unset($possibilities[$y * $N + ($N - $x)][$N - $i]);
            }
        }
    }
}

$canSeeFromSouth = explode(" ", trim(fgets(STDIN)));

//Update the possibilites based on the clues
foreach($canSeeFromSouth as $x => $value) {
    if($value == 1) {
        $possibilities[($N - 1) * $N + $x] = [$N => 1];
    } else {
        for($i = 0; $i < $N; ++$i) {
            if($value <= $i + 1) continue 2;
    
            for($y = 1; $y < $value - $i; ++$y) {
                unset($possibilities[($N - $y) * $N + $x][$N - $i]);
            }
        }
    }
}

for ($y = 0; $y < $N; ++$y) {
    $line = explode(" ", trim(fgets(STDIN)));

    foreach($line as $x => $value) {
        //We already know the value at this position
        if($value != 0) {
            $index = $y * $N + $x;

            unset($possibilities[$index]);

            foreach($updates[$index] as $updateIndex) {
                unset($possibilities[$updateIndex][$value]);
            }
        }
    }

    $cells[] = $line;
}

foreach($possibilities as $index => $list) $counts[$index] = count($list);

solve($possibilities, $counts, $cells);
