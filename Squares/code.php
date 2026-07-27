<?php

function getUpperBound(array $arr, int $x): int {
    $left = 0;
    $right = count($arr) - 1;
    $index = null;

    while ($left <= $right) {
        $i = ($left + $right) >> 1;

        if ($arr[$i] <= $x) {
            $left = $i + 1;
            $index = $i;
        }
        else $right = $i - 1;
    }

    return $index;
};

//Get the area of the region
function getCount(int $x, int $y): int {
    global $counts, $sizes, $xMarks, $yMarks, $bordersL, $bordersU, $maxX, $maxY, $diffX, $diffY, $cx, $cy;
    static $counts = [];

    $i = $y * $cx + $x;
    if(isset($counts[$i])) return $counts[$i]; //We already know the count

    $count = 0;
    $boxes = [];
    $index = 0;
    $queue = [$x, $y];

    while(isset($queue[$index])) {
        $x = $queue[$index++];
        $y = $queue[$index++];
        $i = $y * $cx + $x;

        if(isset($boxes[$i])) continue;
        else $boxes[$i] = true;

        $count += $diffX[$x] * $diffY[$y]; //Add the size of the current box

        //Can we go left
        if($x > 0) {
            $blocked = false;

            //Check if any borders is blocking us
            foreach(($bordersL[$xMarks[$x]] ?? []) as $info) 
                if($yMarks[$y] >= $info[0] && $yMarks[$y] <= $info[1]) {
                    $blocked = true;
                    break;
                }
            
            if(!$blocked) {
                $queue[] = $x - 1;
                $queue[] = $y;
            }
        }
        //Can we go right
        if($x < $maxX) {
            $blocked = false;

            //Check if any borders is blocking us
            foreach(($bordersL[$xMarks[$x + 1]] ?? []) as $info) 
                if($yMarks[$y] >= $info[0] && $yMarks[$y] <= $info[1]) {
                    $blocked = true;
                    break;
                }
            
            if(!$blocked) {
                $queue[] = $x + 1;
                $queue[] = $y;
            }
        }
        //Can we go up
        if($y > 0) {
            $blocked = false;

            //Check if any borders is blocking us
            foreach(($bordersU[$yMarks[$y]] ?? []) as $info) 
                if($xMarks[$x] >= $info[0] && $xMarks[$x] <= $info[1]) {
                    $blocked = true;
                    break;
                }
            
            if(!$blocked) {
                $queue[] = $x; 
                $queue[] = $y - 1;
            }
        }
        //Can we go down
        if($y < $maxY) {
            $blocked = false;

            //Check if any borders is blocking us
            foreach(($bordersU[$yMarks[$y + 1]] ?? []) as $info) 
                if($xMarks[$x] >= $info[0] && $xMarks[$x] <= $info[1]) {
                    $blocked = true;
                    break;
                }
            
            if(!$blocked) {
                $queue[] = $x;
                $queue[] = $y + 1;
            }
        }

    }

    foreach($boxes as $i => $_) $counts[$i] = $count; //Cache the results

    return $count;
}

fscanf(STDIN, "%d %d %d", $side, $M, $N);
$start = microtime(1);

$counts = [];
$sizes = [];

$xMarks = [0 => true, $side => true];
$yMarks = [0 => true, $side => true];

for ($i = 0; $i < $M; ++$i) {
    fscanf(STDIN, "%d %d %d", $x, $y, $s);

    $squares[] = [$x, $y, $s];

    //Border Up
    $bordersU[$y - 1][] = [$x - 1, $x - 2 + $s];
    $bordersU[$y - 1 + $s][] = [$x - 1, $x - 2 + $s];

    //Border Left
    $bordersL[$x - 1][] = [$y - 1, $y - 2 + $s];
    $bordersL[$x - 1 + $s][] = [$y - 1, $y - 2 + $s];

    $xMarks[$x - 1] = true;
    $xMarks[$x - 1 + $s] = true;
    $yMarks[$y - 1] = true;
    $yMarks[$y - 1 + $s] = true;
}

ksort($xMarks);
ksort($yMarks);

$xMarks = array_keys($xMarks);
$yMarks = array_keys($yMarks);

$cx = count($xMarks);
$cy = count($yMarks);

$maxX = $cx - 2;
$maxY = $cy - 2;

$diffX = array_fill(0, $cx, 0);
$diffY = array_fill(0, $cy, 0);

for($i = 0; $i < $cx - 1; ++$i) $diffX[$i] = $xMarks[$i + 1] - $xMarks[$i];
for($i = 0; $i < $cy - 1; ++$i) $diffY[$i] = $yMarks[$i + 1] - $yMarks[$i];

$results = [];

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    $xBox = getUpperBound($xMarks, $x - 1);
    $yBox = getUpperBound($yMarks, $y - 1);

    $results[] = getCount($xBox, $yBox);
}

echo implode(PHP_EOL, $results), PHP_EOL;
error_log(microtime(1) - $start);
