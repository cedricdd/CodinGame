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
    'B' => [
        [[0, 0], [1, 0], [1, 1], [1, 2], [0, 2]],
        [[0, 0], [0, 1], [1, 1], [2, 1], [2, 0]],
        [[0, 0], [1, 0], [0, 1], [0, 2], [1, 2]],
        [[0, 0], [1, 0], [2, 0], [0, 1], [2, 1]],
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
    'I' => [
        [[0, 0], [1, 0], [0, 1], [0, 2], [1, 2], [1, 3]],
        [[0, 0], [1, 0], [1, -1], [2, -1], [3, -1], [3, 0]],
        [[0, 0], [0, 1], [1, 1], [1, 2], [1, 3], [0, 3]],
        [[0, 0], [0, 1], [1, 1], [2, 1], [2, 0], [3, 0]],
        [[0, 0], [1, 0], [1, 1], [1, 2], [0, 2], [0, 3]],
        [[0, 0], [1, 0], [1, 1], [2, 1], [3, 1], [3, 0]],
        [[0, 0], [1, 0], [1, -1], [0, 1], [0, 2], [1, 2]],
        [[0, 0], [0, 1], [1, 0], [2, 0], [2, 1], [3, 1]],
    ],
    'J' => [
        [[0, 0], [1, 0], [2, 0], [2, 1], [2, 2]],
        [[0, 0], [1, 0], [2, 0], [2, -1], [2, -2]],
        [[0, 0], [0, 1], [0, 2], [1, 2], [2, 2]],
        [[0, 0], [1, 0], [2, 0], [0, 1], [0, 2]],
    ],
    'K' => [
        [[0, 0], [1, 0], [0, 1], [1, 1]],
    ],
    'L' => [
        [[0, 0], [1, 0], [1, -1], [1, -2], [2, -2]], 
        [[0, 0], [0, 1], [1, 1], [2, 1], [2, 2]], 
        [[0, 0], [1, 0], [1, 1], [1, 2], [2, 2]], 
        [[0, 0], [0, -1], [1, -1], [2, -1], [2, -2]], 
    ],
    'M' => [
        [[0, 0], [1, 0], [1, 1], [2, 1]],
        [[0, 0], [1, 0], [1, -1], [0, 1]],
        [[0, 0], [1, 0], [1, -1], [2, -1]],
        [[0, 0], [0, 1], [1, 1], [1, 2]],
    ],
    'N' => [
        [[0, 0], [1, 0], [2, 0], [1, 1], [2, 1]], 
        [[0, 0], [1, 0], [1, -1], [0, 1], [1, 1]], 
        [[0, 0], [1, 0], [0, 1], [1, 1], [2, 1]], 
        [[0, 0], [1, 0], [0, 1], [1, 1], [0, 2]], 
        [[0, 0], [1, 0], [2, 0], [0, 1], [1, 1]], 
        [[0, 0], [1, 0], [0, 1], [1, 1], [1, 2]], 
        [[0, 0], [1, 0], [2, 0], [1, -1], [2, -1]], 
        [[0, 0], [0, 1], [1, 1], [0, 2], [1, 2]], 
    ],
];

//Find all the positions where we can put a shape or one of it's variant
function findPositions(string $letter, array $grid): array {
    global $w, $h;

    $placements = [];

    for($y = 0; $y < $h; ++$y) {
        for($x = 0; $x < $w; ++$x) {
            if($grid[$y][$x] == 'O') {
                //Test all the rotations/mirrors
                foreach(SHAPES[$letter] as $list) {
                    $positions = [];

                    foreach($list as [$xm, $ym]) {
                        $xp = $x + $xm;
                        $yp = $y + $ym;

                        if(($grid[$yp][$xp] ?? '.') == '.') continue 2; //Shape can't be inserted here

                        $positions[] = $yp * $w + $xp;
                    }

                    $placements[] = $positions;
                }
            }
        }
    }

    return $placements;
}

//Place all the shapes using Knuth's Algorithm X
function placeShapes(array $counts, array $shapesByPositions, array $listShapes, $solution = []) {
    global $listShapesByLetter, $listLettersByShape;

    //We have placed evertying, return the solution
    if(!$counts) return $solution;
    
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

    //We try all the shapes that can still be added at the position we have selected
    foreach($shapesByPositions[$minPosition] as $shapeID1 => $filler) {
        $counts2 = $counts;
        $listShapes2 = $listShapes;
        $shapesByPositions2 = $shapesByPositions;

        //Loop through all the position occupied by the shape we are adding
        foreach($listShapes[$shapeID1] as $index1) {
            
            if(!isset($shapesByPositions2[$index1])) continue; //This position has already been removed

            //Loop through all the shapes that could have been placed at this position
            foreach($shapesByPositions[$index1] as $shapeID2 => $filler) {

                if(!isset($listShapes2[$shapeID2])) continue; //This shape has already been removed

                foreach($listShapes[$shapeID2] as $index2) {
                    --$counts2[$index2]; 
                    unset($shapesByPositions2[$index2][$shapeID2]);
                }

                unset($listShapes2[$shapeID2]); //We are done with this shape
            }

            //We are done with this position
            unset($shapesByPositions2[$index1]);
            unset($counts2[$index1]);
        }

        //We can only use each shape type once
        $type = $listLettersByShape[$shapeID1];

        //loop through all the shapes of this type
        foreach($listShapesByLetter[$type] as $shapeID) {

            if(!isset($listShapes2[$shapeID])) continue; //We have alreade removed this shape

            //Update all the positions
            foreach($listShapes2[$shapeID] as $index) {
                if(--$counts2[$index] == 0) continue 3; //We have a position with nothing left => invalid
                unset($shapesByPositions2[$index][$shapeID]);
            }
        }

        //If using the shape gets us a solution we can stop here.
        if(($result = placeShapes($counts2, $shapesByPositions2, $listShapes2, $solution + [$shapeID1 => 1])) !== null) return $result;
    }

    return null;
}

$solution = null;

while (TRUE) {
    $letters = stream_get_line(STDIN, 15 + 1, "\n");

    fscanf(STDIN, "%d %d", $h, $w);

    error_log($letters . " - " . $w . " - " . $h);

    $start = microtime(1);

    for ($y = 0; $y < $h; ++$y) $grid[] = str_split(trim(fgets(STDIN)));

    $listLettersByShape = [];
    $listShapesByLetter = [];
    $shapeIndex = 0;
    $counts = array_fill(0, $w * $h, 0);

    foreach(str_split(strrev($letters)) as $letter) {
        //Find all the positions where we can put this type of shape
        foreach(findPositions($letter, $grid) as $positions) {
            $listShapes[$shapeIndex] = $positions;
            $count = count($positions);

            foreach($positions as $positionIndex) {
                $counts[$positionIndex]++;
                $shapesByPositions[$positionIndex][$shapeIndex] = $count;
            }

            $listShapesByLetter[$letter][] = $shapeIndex;
            $listLettersByShape[$shapeIndex] = $letter;

            ++$shapeIndex;
        }
    }
    
    $counts = array_filter($counts); //Remove all the positions where we can't put anything

    $solution = placeShapes($counts, $shapesByPositions, $listShapes);
    $output = array_fill(0, $h, str_repeat(".", $w));

    foreach($solution as $shapeID => $filler) {
        foreach($listShapes[$shapeID] as $position) $output[intdiv($position, $w)][$position % $w] = $listLettersByShape[$shapeID];
    }

    echo implode(PHP_EOL, $output) . PHP_EOL;

    error_log(microtime(1) - $start);
}
