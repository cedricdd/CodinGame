<?php

const PRECISION = 12;
const THRESHOLD = 10 ** -12;

/**
 * Check if two birds are going to be at a distance of $d of each others
 */
function checkBirdsColliding(array &$birds, int $id1, int $id2, float $d): ?float {
    [$x1, $y1, $vx1, $vy1] = $birds[$id1];
    [$x2, $y2, $vx2, $vy2] = $birds[$id2];

    $x = $x2 - $x1;
    $y = $y2 - $y1;
    $vx = $vx2 - $vx1;
    $vy = $vy2 - $vy1;

    $a = $vx * $vx + $vy * $vy;
    $b = 2 * ($x * $vx + $y * $vy);
    $c = $x * $x + $y * $y - $d * $d;

    if($a > 0) {
        $delta = $b * $b - 4 * $a * $c;

        if($delta > 0) {
            $t1 = (($b * -1) + sqrt($delta)) / (2 * $a);
            $t2 = (($b * -1) - sqrt($delta)) / (2 * $a);

            //Make sure float doesn't mess up a 0 value
            if($t1 > 0.0 && $t1 < THRESHOLD) $t1 = 0.0;;
            if($t2 > 0.0 && $t2 < THRESHOLD) $t2 = 0.0;;

            //If one of the value is negative the birds are not heading to each others
            if($t1 >= 0.0 && $t2 >= 0.0)  return min($t1, $t2);
        }
    } 

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

    $cross0 = $dx * ($y - $y1) - $dy * ($x - $x1);
    $crossV = $dx * $vy - $dy * $vx;

    $target = $d * $L;
    
    $time = min(($target - $cross0) / $crossV, (-$target - $cross0) / $crossV);

    //Make sure float doesn't mess up a 0 value
    if($time < THRESHOLD) $time = 0.0;;

    return $time;
}

function solve(array $birds, int $timeLeft, float $d) {
    $collisionBird = 0;
    $collisionBorder = 0;
    $history = [];
    $start = microtime(1);

    while(true) {
        $collisionTime = INF;
        $collisions = [];

        //Find how long before each birds hits a border
        foreach($birds as $id1 => [$x, $y, $vx, $vy]) {
            //Bird will hit the left wall
            if($vx < 0) {
                $t = getTimeBeforeReachingBorder($birds, $id1, 'L');

                if($t < $collisionTime) {
                    $collisionTime = $t;
                    $collisions = [[$id1, 'L']];
                } elseif($t == $collisionTime) $collisions[] = [$id1, 'L'];
            }
            //Bird will hi the right wall
            if($vx > 0) {
                $t = getTimeBeforeReachingBorder($birds, $id1, 'R');

                if($t < $collisionTime) {
                    $collisionTime = $t;
                    $collisions = [[$id1, 'R']];
                } elseif($t == $collisionTime) $collisions[] = [$id1, 'R'];
            }
            //Bird will hit the top wall
            if($vy < 0) {
                $t = getTimeBeforeReachingBorder($birds, $id1, 'T');

                if($t < $collisionTime) {
                    $collisionTime = $t;
                    $collisions = [[$id1, 'T']];
                } elseif($t == $collisionTime) $collisions[] = [$id1, 'T'];
            }
            //Bird will hit the bottom wall
            if($vy > 0) {
                $t = getTimeBeforeReachingBorder($birds, $id1, 'B');

                if($t < $collisionTime) {
                    $collisionTime = $t;
                    $collisions = [[$id1, 'B']];
                } elseif($t == $collisionTime) $collisions[] = [$id1, 'B'] ;
            }

            foreach($birds as $id2 => $filler) {
                if($id2 > $id1) {
                    $t = checkBirdsColliding($birds, $id1, $id2, $d);

                    // The birds are going to going to be too close from each others
                    if($t !== null) {
                        if($t < $collisionTime) {
                            $collisionTime = $t;
                            $collisions = [[$id1, $id2]];
                        } elseif($t == $collisionTime) $collisions[] = [$id1, $id2] ;
                    }
                }
            }
        }

        //We need to stop before the next collision
        if($collisionTime > $timeLeft) $collisionTime = $timeLeft;

        //Update the position of the birds
        if($collisionTime > 0.0) {
            foreach($birds as $id => [$x, $y, $vx, $vy]) {
                $birds[$id][0] += $vx * $collisionTime;
                $birds[$id][1] += $vy * $collisionTime;
            }

            $timeLeft -= $collisionTime;
        }

        //We reached the moment of the shot
        if($timeLeft == 0.0) {
            error_log("We are over - Border Collision: $collisionBorder - Birds Collision: $collisionBird - In " . (microtime(1) - $start));
            foreach($birds as $id => [$x, $y]) echo $id . " [" . round($x, 0, PHP_ROUND_HALF_DOWN) . "," . round($y, 0, PHP_ROUND_HALF_DOWN) . "]" . PHP_EOL;
            exit();
        }

        $hashInfo = [];

        foreach($collisions as [$id1, $id2]) {
            //Collision with border
            if(!is_numeric($id2)) {
                switch($id2) {
                    case 'T':
                    case 'B': $birds[$id1][3] *= -1; break;
                    case 'L':
                    case 'R': $birds[$id1][2] *= -1; break;
                }

                ++$collisionBorder;
            } //Collision with two birds
            else {
                //The reflection is done with the line passing by the current position of the two birds
                $line = [$birds[$id2][0] - $birds[$id1][0], $birds[$id2][1] - $birds[$id1][1]];
                $len = sqrt($line[0] * $line[0] + $line[1] * $line[1]);
                $line = [$line[0] / $len, $line[1] / $len];

                //Update the speed of the first bird
                $dotProduct = $birds[$id1][2] * $line[0] + $birds[$id1][3] * $line[1];

                $birds[$id1][2] -= 2 * $dotProduct * $line[0];
                $birds[$id1][3] -= 2 * $dotProduct * $line[1];

                //Update the speed of the second bird
                $dotProduct = $birds[$id2][2] * $line[0] + $birds[$id2][3] * $line[1];

                $birds[$id2][2] -= 2 * $dotProduct * $line[0];
                $birds[$id2][3] -= 2 * $dotProduct * $line[1];

                ++$collisionBird;
            }

            if($id1 > $id2) [$id1, $id2] = [$id2, $id1];

            $hashInfo[$id1 . "-" . $id2] = [$birds[$id1][0] ?? $id1, $birds[$id1][1] ?? $id1, $birds[$id2][0] ?? $id2, $birds[$id2][1] ?? $id2];
            
        }

        //Generate hash to detect infinite loop
        ksort($hashInfo);

        $hash = hash('sha256', json_encode($hashInfo));

        if(isset($history[$timeLeft][$hash])) exit("No movement possible!"); // We are in a loop, we can't reach the moment of the shot
        else $history[$timeLeft][$hash] = 1;
    }
}

fscanf(STDIN, "%d %d", $h, $w);
fscanf(STDIN, "%f", $t);
fscanf(STDIN, "%f", $d);
fscanf(STDIN, "%d", $n);

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

solve($birds, $t, $d);
