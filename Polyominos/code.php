<?php

const SHAPES = [
    'A' => [
        [[0, 0], [1, 0], [1, 1], [1, 2]],
        [[0, 0], [1, 0], [2, 0], [2, -1]],
        [[0, 0], [0, 1], [0, 2], [1, 2]],
        [[0, 0], [1, 0], [2, 0], [0, 1]],
        [[0, 0], [1, 0], [0, 1], [0, 2]],
        [[0, 0], [1, 0], [2, 0], [2, 1]],
        [[0, 0], [1, 0], [1, -1], [1, -2]],
        [[0, 0], [0, 1], [1, 1], [2, 1]],
    ],
    'C' => [
        [[0, 0], [1, 0], [1, -1], [1, 1], [2, 0]],
    ],
    'D' => [
        [[0, 0], [1, 0], [1, -1], [2, 0]],
        [[0, 0], [0, 1], [1, 1], [0, 2]],
        [[0, 0], [1, 0], [2, 0], [1, 1]],
        [[0, 0], [1, 0], [1, -1], [1, 1]],
    ],
    'E' => [
        [[0, 0], [0, 1], [1, 1], [2, 1], [0, 2]],
        [[0, 0], [1, 0], [2, 0], [1, 1], [1, 2]],
        [[0, 0], [1, 0], [2, 0], [2, -1], [2, 1]],
        [[0, 0], [1, 0], [2, 0], [1, -1], [1, -2]],
    ],
    'F' => [
        [[0, 0], [1, 0], [2, 0], [3, 0]],
        [[0, 0], [0, 1], [0, 2], [0, 3]],
    ],
    'G' => [
        [[0, 0], [0, 1], [1, 0], [1, -1], [2, -1]],
        [[0, 0], [1, 0], [1, 1], [2, 1], [2, 2]],
        [[0, 0], [1, 0], [1, -1], [2, -1], [2, -2]],
        [[0, 0], [0, 1], [1, 1], [1, 2], [2, 2]],
    ],
    'H' => [
        [[0, 0], [0, 1], [1, 1]],
        [[0, 0], [1, 0], [0, 1]],
        [[0, 0], [1, 0], [1, 1]],
        [[0, 0], [1, 0], [1, -1]],
    ],
    'J' => [
        [[0, 0], [1, 0], [2, 0], [2, 1], [2, 2]],
        [[0, 0], [1, 0], [2, 0], [2, -1], [2, -2]],
        [[0, 0], [0, 1], [0, 2], [1, 2], [2, 2]],
        [[0, 0], [1, 0], [2, 0], [0, 1], [0, 2]],
    ],
    'L' => [
        [[0, 0], [1, 0], [1, -1], [1, -2], [2, -2]], 
        [[0, 0], [0, 1], [1, 1], [2, 1], [2, 2]], 
        [[0, 0], [1, 0], [1, 1], [1, 2], [2, 2]], 
        [[0, 0], [0, -1], [1, -1], [2, -1], [2, -2]], 
    ]
];

function findPositions(string $letter, array $grid): array {
    global $w, $h;

    $placements = [];

    for($y = 0; $y < $h; ++$y) {
        for($x = 0; $x < $w; ++$x) {
            if($grid[$y][$x] == 'O') {
                foreach(SHAPES[$letter] as $list) {
                    $positions = [];

                    foreach($list as [$xm, $ym]) {
                        $xp = $x + $xm;
                        $yp = $y + $ym;

                        if(($grid[$yp][$xp] ?? '.') == '.') continue 2;

                        $positions[] = $yp * $w + $xp;
                    }

                    $placements[] = $positions;
                }
            }
        }
    }

    return $placements;
}

function placeShapes(array $counts, array $shapesByPositions, array $listShapes, $solution = []) {
    global $listShapesByLetter, $listLettersByShape;

    if(!$counts) {
        error_log("Solution:");
        error_log(var_export($solution, 1));
        return $solution;
    }
    
    //Find the next positions to work on
    $minCount = PHP_INT_MAX;
    $minPosition = null;

    foreach($counts as $index => $count) {
        if($count < $minCount) {
            $minPosition = $index;
            $minCount = $count;

            if($count == 0) return null; //We have a position with no possible shapes
            if($count == 1) break; //Can't do any better
        }
    }

    error_log("using position $minPosition");

    foreach($shapesByPositions[$minPosition] as $shapeID1 => $filler) {
        // error_log("using shape $shapeID1 - " . $listLettersByShape[$shapeID1]);

        $counts2 = $counts;
        $listShapes2 = $listShapes;
        $shapesByPositions2 = $shapesByPositions;

        //Loop through all the position occupied by the shape we are adding
        foreach($listShapes[$shapeID1] as $index1) {
            
            if(!isset($shapesByPositions2[$index1])) continue; //This position has already been removed

            //Loop through all the shapes that could have been place at this position
            foreach($shapesByPositions[$index1] as $shapeID2 => $filler) {

                if(!isset($listShapes2[$shapeID2])) continue; //This shape has already been removed

                foreach($listShapes[$shapeID2] as $index2) {
                    --$counts2[$index2]; 
                    unset($shapesByPositions2[$index2][$shapeID2]);
                }

                unset($listShapes2[$shapeID2] );
            }

            unset($shapesByPositions2[$index1]);
            unset($counts2[$index1]);
        }

        //We can only use each shape type once
        $type = $listLettersByShape[$shapeID1];

        // error_log("Type is $type");
        // error_log(var_export($listShapesByLetter[$type], 1));

        foreach($listShapesByLetter[$type] as $shapeID) {
            if(isset($listShapes2[$shapeID])) {
                // error_log("need to remove $shapeID");
                foreach($listShapes2[$shapeID] as $index) {
                    if(--$counts2[$index] == 0) continue 2; 
                    unset($shapesByPositions2[$index][$shapeID]);
                }
            }
        }

        $result = placeShapes($counts2, $shapesByPositions2, $listShapes2, $solution + [$shapeID1 => 1]);

        if($result !== null) return $result;
    }

    return null;
}

function solve(array $letters, array $grid): array {
    global $w, $h, $listShapesByLetter, $listLettersByShape, $listShapes;

    $listLettersByShape = [];
    $listShapesByLetter = [];
    $shapeIndex = 0;
    $counts = array_fill(0, $w * $h, 0);

    foreach($letters as $letter) {
        error_log("Letter $letter");

        foreach(findPositions($letter, $grid) as $positions) {
            $listShapes[$shapeIndex] = $positions;

            foreach($positions as $positionIndex) {
                $counts[$positionIndex]++;
                $shapesByPositions[$positionIndex][$shapeIndex] = 1;
            }

            $listShapesByLetter[$letter][] = $shapeIndex;
            $listLettersByShape[$shapeIndex] = $letter;

            ++$shapeIndex;
        }
    }

    $counts = array_filter($counts);

    // error_log(var_export($shapesByPositions, 1));

    return placeShapes($counts, $shapesByPositions, $listShapes);
}

$solution = null;

while (TRUE) {
    $remaining = stream_get_line(STDIN, 15 + 1, "\n");// IDs of remaining tiles
    $current = stream_get_line(STDIN, 1 + 1, "\n");// ID of current tile to place on board

    $start = microtime(1);

    error_log($remaining . " " . $current);

    fscanf(STDIN, "%d %d", $h, $w);

    for ($y = 0; $y < $h; ++$y) {
        $grid[] = str_split(trim(fgets(STDIN)));
    }

    if($solution === null) {
        foreach(solve(str_split($remaining), $grid) as $shapeID => $filler) {
            $solution[$listLettersByShape[$shapeID]] = $shapeID;
        }

        error_log(var_export($solution, 1));
    }

    error_log("adding $current - " . $solution[$current]);
    error_log(var_export($listShapes[$solution[$current]], 1));

    $positions = [];

    foreach($listShapes[$solution[$current]] as $position) $positions[] = "(" . intdiv($position, $w) . "," . ($position % $w) . ")";

    echo implode(" ", $positions) . PHP_EOL;

    error_log(microtime(1) - $start);
}
