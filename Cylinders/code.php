<?php

function calculateWidth(array $radii): float {
    global $distances;

    $radii[] = 0; //Add the end of the box
    $centers = [[0, 0.0]];

    foreach($radii as $radius) {
        $maxCenter = 0;

        //Find the center of the cylinders, check against cylinders already placed to find the farthest position
        foreach($centers as [$center, $leftRadius]) {
            $newCenter = $center + $distances[$leftRadius][$radius];

            if($newCenter > $maxCenter) $maxCenter = $newCenter;
        }

        $centers[] = [$maxCenter, $radius];
    }

    return $maxCenter + $radius;
}

function generatePermutations(array $radii, int $left, array $solution) {
    global $minWidth;

    if($left == 0) {
        //Reverse solution will create the same width so we can ignore them, skip if first element is bigger than last
        if(reset($solution) <= end($solution)) {

            $width = calculateWidth($solution);

            if($width < $minWidth) $minWidth = $width;
        }

        return;
    }

    --$left;

    foreach($radii as $value => &$occurences) {
        if($occurences > 0) {
            --$occurences;

            $updatedSolution = $solution;
            $updatedSolution[] = $value;

            generatePermutations($radii, $left, $updatedSolution);

            ++$occurences;
        }
    }
}

$start = microtime(1);

$numberCount = 0;

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $inputs = explode(" ", trim(fgets(STDIN)));
    $radii = [];
    $distances[0][0] = 0;
    $numberCount = array_shift($inputs);

    //Only one cylinder in the box
    if($numberCount == 1) {
        echo number_format(array_pop($inputs) * 2, 3, ".", "") . PHP_EOL;
        continue;
    }
    
    for($j = 0; $j < $numberCount; ++$j) {
        $radius = array_pop($inputs);

        //Pre-compute the horizontal distances between cylinders
        foreach($radii as $r => $filler) {
            if(!isset($distances[$r][$radius])) {
                $distances[$r][$radius] = $distances[$radius][$r] = 2.0 * sqrt($radius * $r);
            }
        }

        $distances[$radius][0] = $distances[0][$radius] = $radius; //Distance between center and the box, just the radius

        $radii[$radius] = ($radii[$radius] ?? 0) + 1;
    }

    $minWidth = INF;

    generatePermutations($radii, $numberCount, []);

    echo number_format($minWidth, 3, ".", "") . PHP_EOL;
}

error_log(microtime(1) - $start);
