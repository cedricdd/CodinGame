<?php

function getDistanceBetweenCenters(int $r1, int $r2): float {
    static $history;

    if(isset($history[$r1][$r2])) return $history[$r1][$r2];
    if(isset($history[$r2][$r1])) return $history[$r2][$r1];

    if($r1 == 0) $distance = $r2;
    elseif($r2 == 0) $distance = $r1;
    else $distance = sqrt((($r1 + $r2) ** 2) - (abs($r1 - $r2) ** 2));

    return $history[$r1][$r2] = $history[$r2][$r1] = $distance;
}

function calculateWidth(array $radii) {
    global $minWidth, $spaceBelow;
    static $history;

    $count = count($radii);
    $width = 0;

    if($count == 1) $width = array_pop($radii) * 2;
    else {

        for($i = 0; $i <= $count; ++$i) {
            $width += getDistanceBetweenCenters($radii[$i] ?? 0, $radii[$i + 1] ?? 0);
        }

        /*
        $indexMax = array_search(max($radii), $radii);

        error_log("starting at $indexMax");

        //To the left
        $i = $indexMax;
        $left = $radii[$i - 1] ?? 0;
        $rightDirect = $rightRemoved = $radii[$i];
        $distanceRemoved = 0.0;

        do {
            error_log("i is $i -- left is $left -- rightDirect is $rightDirect -- rightRemoved is $rightRemoved");

            if($left != 0 && $left * 2 <= $spaceBelow[$rightDirect]) {
                $distanceRemoved += getDistanceBetweenCenters($left, $rightRemoved);
                $rightRemoved = $radii[$i - 1];
            } else {
                $distance = getDistanceBetweenCenters($left, $rightDirect);

                if($distanceRemoved != 0.0) {
                    $distanceRemoved += getDistanceBetweenCenters($left, $rightRemoved);

                    if($distanceRemoved < $distance) {
                        $width += $distance;
                        error_log("removed is lower, using direct $distance");
                    }
                    else {
                        $width += $distanceRemoved;
                        error_log("removed is bigger, using removed $distanceRemoved");
                    }

                    $distanceRemoved = 0.0;
                }
                else {
                    $width += $distance;
                    error_log("adding direct width $distance");
                }

                $rightDirect = $rightRemoved = $radii[$i];
            }

            --$i;
            $left = $radii[$i - 1] ?? 0;
        } while($i > 0);

        //To the right
        $i = $indexMax;
        $leftDirect = $leftRemoved = $radii[$i];
        $right = $radii[$i + 1] ?? 0;
        $distanceRemoved = 0.0;

        do {
            error_log("i is $i -- leftDirect is $leftDirect -- leftRemoved is $leftRemoved -- right is $right");

            if($right != 0 && $right * 2 <= $spaceBelow[$leftDirect]) {
                $distanceRemoved += getDistanceBetweenCenters($right, $leftRemoved);
                $leftRemoved = $radii[$i + 1];
            } else {
                $distance = getDistanceBetweenCenters($leftDirect, $right);

                if($distanceRemoved != 0.0) {
                    $distanceRemoved += getDistanceBetweenCenters($leftRemoved, $right);

                    if($distanceRemoved < $distance) {
                        $width += $distance;
                        error_log("removed is lower, using direct $distance");
                    }
                    else {
                        $width += $distanceRemoved;
                        error_log("removed is bigger, using removed $distanceRemoved");
                    }

                    $distanceRemoved = 0.0;
                }
                else {
                    $width += $distance;
                    error_log("adding direct width $distance");
                }

                $leftDirect = $leftRemoved = $radii[$i];
            }

            ++$i;
            $right = $radii[$i + 1] ?? 0;
        } while($i <= $count);
        */
    }

    //error_log("width is $width");

    if($width < $minWidth) $minWidth = $width;
}

function generatePermutations(array $sizes, int $index, array $radii = [], string $hash = "0", string $hashRev = "0") {
    static $history;

    if($index == 0) {
        $hash = $hash . "-0";
        $hashRev = "0-" . $hashRev;

        //error_log("solution $hash - $hashRev");

        if(isset($history[$hash]) == false && isset($history[$hashRev]) == false) {
            //error_log(var_export($radii, true));

            calculateWidth($radii);

            $history[$hash] = 1;
            $history[$hashRev] = 1;
        }

        return;
    }

    foreach($sizes as $i => $size) {
        unset($sizes[$i]);

        generatePermutations($sizes, $index - 1, $radii + [$index => $size], $hash . "-" . $size, $size . "-" . $hashRev);

        $sizes[$i] = $size;
    }
}

$start = microtime(1);

//$spaceBelow = [0 => INF];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $inputs = explode(" ", trim(fgets(STDIN)));
    $radii = [];
    $count = array_shift($inputs);
    
    for($j = 0; $j < $count; ++$j) {
        $radius = array_pop($inputs);

        /*
        if(!isset($spaceBelow[$radius])) {
            $spaceBelow[$radius] = $radius * sqrt(2) - $radius;
        }*/

        $radii[] = $radius;
    }

    $minWidth = INF;

    generatePermutations($radii, $count);

    echo number_format($minWidth, 3, ".", "") . PHP_EOL;
}

error_log(var_export($spaceBelow, true));

error_log(microtime(1) - $start);
