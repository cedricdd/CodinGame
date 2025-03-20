<?php

function getMinMax(array $moves): array {
    $x = 0;
    $y = 0;
    $xMin = 0;
    $xMax = 0;
    $yMin = 0;
    $yMax = 0;

    foreach($moves as [$direction, $step]) {

        switch($direction) {
            case '>':   $x += $step;    break;
            case '<':   $x -= $step;    break;
            case 'v':   $y += $step;    break;
            case '^':   $y -= $step;    break;
        }

        if($x > $xMax) $xMax = $x;
        if($x < $xMin) $xMin = $x;
        if($y > $yMax) $yMax = $y;
        if($y < $yMin) $yMin = $y;
    }

    return [$xMin, $xMax, $yMin, $yMax,];
}

function solve(int &$surface, array $moves, int $level = 1): void {
    $x = 0;
    $y = 0;
    $open = false;
    $movesInside = [];
    [$xMin, $xMax, $yMin, $yMax] = getMinMax($moves);
    $count = (abs($xMax - $xMin) + 1) * (abs($yMax - $yMin) + 1);

    error_log("$xMin $xMax - $yMin $yMax - $count");

    foreach($moves as [$direction, $step]) {
        switch($direction) {
            case '>':   $x += $step;    break;
            case '<':   $x -= $step;    break;
            case 'v':   $y += $step;    break;
            case '^':   $y -= $step;    break;
        }

        $mainBorder = ($x == $xMin || $x == $xMax || $y == $yMin || $y == $yMax);
    
        if(!$open && !$mainBorder) {
            $movesInside[] = [$direction, $step];
            $open = true;
        } elseif($open) {
            $movesInside[] = [$direction, $step];

            if($mainBorder) {
                $open = false;

                solve($surface, $movesInside, $level + 1);

                error_log(var_export($movesInside, 1));

                $movesInside = [];

                // if($level == 1) ++$surface;

                error_log("surface $surface");
                if($level == 1)exit();
            }
        } elseif($level != 1) {
            // error_log("adding $step for border");
            // $surface += $step; //Border is always part of the shape
        }
    }

    $temp = $count * ($level & 1 ? 1 : -1);

    error_log("done with " . $temp);

    $surface += $temp;
}

fscanf(STDIN, "%d", $n);

for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s %d", $direction, $step);

    $moves[] = [$direction, $step];
}

$surface = 0;
solve($surface, $moves);

echo $surface . PHP_EOL;
