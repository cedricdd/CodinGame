<?php

function checkBirdsCollide(array &$birds, int $id1, int $id2, float $d): ?float {
    [$x1, $y1, $vx1, $vy1] = $birds[$id1];
    [$x2, $y2, $vx2, $vy2] = $birds[$id2];

    $x = $x2 - $x1;
    $y = $y2 - $y1;
    $vx = $vx2 - $vx1;
    $vy = $vy2 - $vy1;

    // error_log("x $x - y $y - vx $vx - vy $vy");

    $a = $vx * $vx + $vy * $vy;
    $b = 2 * ($x * $vx + $y * $vy);
    $c = $x * $x + $y * $y - $d * $d;

    // error_log("$a - $b - $c");

    if($a > 0) {
        $delta = $b * $b - 4 * $a * $c;

        // error_log("delta is $delta");

        if($delta == 0) {
            $t = ($b * -1) / (2 * $a);

            // error_log("delta is 0 => $t is $t");

            if($t > 0) return $t;
        } elseif($delta > 0) {
            $t1 = (($b * -1) + sqrt($delta)) / (2 * $a);
            $t2 = (($b * -1) - sqrt($delta)) / (2 * $a);

            // error_log("T1 $t1 - T2 $t2");

            if($t1 > 0 && $t2 <= 0) return $t1;
            if($t2 > 0 && $t1 <= 0) return $t2;
            if($t1 > 0 && $t2 > 0)  return min($t1, $t2);
        }
    } else error_log("$a is 0!!");

    return null;
}

/**
 * Returns the time (> 0) when a moving point first reaches distance D from the infinite line
 * through (x1,y1)-(x2,y2), but only the solution that occurs before the point crosses the line.
 */
function getTimeBeforeReachingBorder(array &$birds, int $id, string $borderID): float {
    global $d, $borders;

    [$x1, $y1, $x2, $y2] = $borders[$borderID];
    [$x, $y, $vx, $vy] = $birds[$id];

    $dx = $x2 - $x1;
    $dy = $y2 - $y1;
    $L = sqrt($dx * $dx + $dy * $dy);

    // cross product (b-a) x (p0 - a)
    $cross0 = $dx * ($y - $y1) - $dy * ($x - $x1);
    // cross product (b-a) x v
    $crossV = $dx * $vy - $dy * $vx;

    $target = $d * $L;
    
    $t1 = ($target - $cross0) / $crossV;
    $t2 = (-$target - $cross0) / $crossV;

    // error_log("$id will be at $d from $borderID at $t1 & $t2");

    return min($t1, $t2);
}

function solve(array $birds, int $timeLeft, float $d) {
    $totalTime = 0.0;

    while(true) {
        foreach($birds as [$x, $y, $vx, $vy]) error_log("$x $y -- $vx $vy");
    
        $firstCollision = [INF];

        //Find how long before each birds hits a border
        foreach($birds as $id => [$x, $y, $vx, $vy]) {
            //Bird will hit the left wall
            if($vx < 0) {
                $t = getTimeBeforeReachingBorder($birds, $id, 'L');

                if($t < $firstCollision[0]) $firstCollision = [$t, $id, 'L'];
            }
            //Bird will hi the right wall
            if($vx > 0) {
                $t = getTimeBeforeReachingBorder($birds, $id, 'R');

                if($t < $firstCollision[0]) $firstCollision = [$t, $id, 'R'];
            }
            //Bird will hit the top wall
            if($vy < 0) {
                $t = getTimeBeforeReachingBorder($birds, $id, 'T');

                if($t < $firstCollision[0]) $firstCollision = [$t, $id, 'T'];
            }
            //Bird will hit the bottom wall
            if($vy > 0) {
                $t = getTimeBeforeReachingBorder($birds, $id, 'B');

                if($t < $firstCollision[0]) $firstCollision = [$t, $id, 'B'];
            }

            foreach($birds as $id2 => $filler) {
                if($id2 > $id) {
                    $t = checkBirdsCollide($birds, $id, $id2, $d);
                    $t = round($t, 8);

                    // error_log("Checing $id & $id2 => T is $t");

                    if($t && $t < $firstCollision[0]) $firstCollision = [$t, $id, $id2];
                }
            }
        }

        error_log(var_export($firstCollision, 1));

        [$t, $id1, $id2] = $firstCollision;

        if($t > $timeLeft) $t = $timeLeft;

        foreach($birds as $id => [$x, $y, $vx, $vy]) {
            $birds[$id][0] += $vx * $t;
            $birds[$id][1] += $vy * $t;
        }

        $timeLeft -= $t;

        if($timeLeft == 0) {
            error_log("We are over");
            foreach($birds as $id => [$x, $y]) echo $id . " [" . round($x, 0, PHP_ROUND_HALF_DOWN) . "," . round($y, 0, PHP_ROUND_HALF_DOWN) . "]" . PHP_EOL;
            exit();
        }

        //Hitting a border
        if(!is_numeric($id2)) {
            switch($id2) {
                case 'T':
                case 'B': $birds[$id1][3] *= -1; break;
                case 'L':
                case 'R': $birds[$id1][2] *= -1; break;
            }
        } else {
            //The reflection is done with the line passing by the current position of the two birds
            $line = [$birds[$id2][0] - $birds[$id1][0], $birds[$id2][1] - $birds[$id1][1]];
            $len = sqrt($line[0] * $line[0] + $line[1] * $line[1]);
            $line = [$line[0] / $len, $line[1] / $len];

            $dotProduct = $birds[$id1][2] * $line[0] + $birds[$id1][3] * $line[1];

            $birds[$id1][2] -= 2 * $dotProduct * $line[0];
            $birds[$id1][3] -= 2 * $dotProduct * $line[1];

            $dotProduct = $birds[$id2][2] * $line[0] + $birds[$id2][3] * $line[1];

            $birds[$id2][2] -= 2 * $dotProduct * $line[0];
            $birds[$id2][3] -= 2 * $dotProduct * $line[1];
        }
    }
}

fscanf(STDIN, "%d %d", $h, $w);
fscanf(STDIN, "%f", $t);
fscanf(STDIN, "%f", $d);
fscanf(STDIN, "%d", $n);

if($t != intval($t)) exit("T is not an int!");

error_log("SIZE: $w * $h - TIME: $t - DIST $d");

$birds = [];

for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %f %f %f %f", $id, $x, $y, $vx, $vy);

    $birds[$id] = [$x, $y, $vx * -1, $vy * -1];
}

$borders = [
    'T' => [0, 0, $w, 0],
    'B' => [0, $h, $w, $h],
    'L' => [0, 0, 0, $h],
    'R' => [$w, 0, $w, $h],
];

// error_log(var_export($borders, 1));

solve($birds, $t, $d);
