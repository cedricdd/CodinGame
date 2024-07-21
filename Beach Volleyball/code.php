<?php

function solve(int $start, int $end): int {
    global $land, $water, $sx, $sy, $beachY, $bx, $by;

    $x = ($start + $end) >> 1;

    $t1 = sqrt(($sx - ($x - 1)) ** 2 + ($sy - $beachY) ** 2) / $land + sqrt((($x - 1) - $bx) ** 2 + ($beachY - $by) ** 2) / $water;
    $t2 = sqrt(($sx - $x) ** 2 + ($sy - $beachY) ** 2) / $land + sqrt(($x - $bx) ** 2 + ($beachY - $by) ** 2) / $water;
    $t3 = sqrt(($sx - ($x + 1)) ** 2 + ($sy - $beachY) ** 2) / $land + sqrt((($x + 1) - $bx) ** 2 + ($beachY - $by) ** 2) / $water;

    //We have tested all the possible solutions
    if($end - $start <= 2) {
        if($t1 < $t2) return $x - 1;
        elseif($t3 < $t2) return $x + 1;
        else return $x;
    }

    if($t1 >= $t2 && $t2 <= $t3) return $x; //The middle is the best solution
    elseif($t1 < $t2 && $t2 <= $t3) return solve($start, $x); //The best solution is on the lest
    else return solve($x, $end); //The best solution is on the right
}

fscanf(STDIN, "%d %d", $sx, $sy);
fscanf(STDIN, "%d", $beachY);
fscanf(STDIN, "%d %d", $bx, $by);
fscanf(STDIN, "%d", $land);
fscanf(STDIN, "%d", $water);

echo solve(min($sx, $bx), max($sx, $bx)) . PHP_EOL;
