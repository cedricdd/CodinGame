<?php

const TETRASTICKS = [
    'F' => [
        "0-0" => [[1, 0], [0, 1], [0, 2], [0, 3], [1, 2]],
        "0-1" => [[1, 0], [2, 0], [3, 0], [2, 1], [4, 1]],
        "0-2" => [[1, 2], [1, 4], [2, 1], [2, 2], [2, 3]],
        "0-3" => [[0, 1], [2, 1], [1, 2], [2, 2], [3, 2]],
        "1-0" => [[1, 0], [1, 2], [2, 1], [2, 2], [2, 3]],
        "1-1" => [[1, 2], [2, 1], [2, 2], [3, 2], [4, 1]],
        "1-2" => [[0, 1], [0, 2], [0, 3], [1, 2], [1, 4]],
        "1-3" => [[0, 1], [1, 0], [2, 0], [3, 0], [2, 1]],
    ],
    'I' => [
        "0-0" => [[0, 1], [0, 2], [0, 3], [0, 4], [0, 5], [0, 6], [0, 7]],
        "0-1" => [[1, 0], [2, 0], [3, 0], [4, 0], [5, 0], [6, 0], [7, 0]],
    ],
    'J' => [
        "0-0" => [[0, 3], [1, 4], [2, 3], [2, 2], [2, 1]],
        "0-1" => [[1, 0], [0, 1], [1, 2], [2, 2], [3, 2]],
        "0-2" => [[1, 0], [2, 1], [0, 1], [0, 2], [0, 3]],
        "0-3" => [[1, 0], [2, 0], [3, 0], [4, 1], [3, 2]],
        "1-0" => [[0, 1], [0, 2], [0, 3], [1, 4], [2, 3]],
        "1-1" => [[1, 0], [2, 0], [3, 0], [0, 1], [1, 2]],
        "1-2" => [[0, 1], [1, 0], [2, 1], [2, 2], [2, 3]],
        "1-3" => [[1, 2], [2, 2], [3, 2], [4, 1], [3, 0]],
    ],
    'L' => [
        "0-0" => [[0, 1], [0, 2], [0, 3], [0, 4], [0, 5], [1, 6]],
        "0-1" => [[0, 1], [1, 0], [2, 0], [3, 0], [4, 0], [5, 0]],
        "0-2" => [[1, 0], [2, 1], [2, 2], [2, 3], [2, 4], [2, 5]],
        "0-3" => [[1, 2], [2, 2], [3, 2], [4, 2], [5, 2], [6, 1]],
        "1-0" => [[2, 1], [2, 2], [2, 3], [2, 4], [2, 5], [1, 6]],
        "1-1" => [[0, 1], [1, 2], [2, 2], [3, 2], [4, 2], [5, 2]],
        "1-2" => [[1, 0], [0, 1], [0, 2], [0, 3], [0, 4], [0, 5]],
        "1-3" => [[1, 0], [2, 0], [3, 0], [4, 0], [5, 0], [6, 1]],
    ],
    'N' => [
        "0-0" => [[0, 1], [1, 2], [2, 3], [2, 4], [2, 5]],
        "0-1" => [[1, 2], [2, 2], [3, 2], [4, 1], [5, 0]],
        "0-2" => [[0, 1], [0, 2], [0, 3], [1, 4], [2, 5]],
        "0-3" => [[1, 2], [2, 1], [3, 0], [4, 0], [5, 0]],
        "1-0" => [[2, 1], [1, 2], [0, 3], [0, 4], [0, 5]],
        "1-1" => [[1, 0], [2, 0], [3, 0], [4, 1], [5, 2]],
        "1-2" => [[0, 5], [1, 4], [2, 3], [2, 2], [2, 1]],
        "1-3" => [[1, 0], [2, 1], [3, 2], [4, 2], [5, 2]],
    ],
    'P' => [
        "0-0" => [[1, 0], [2, 1], [1, 2], [0, 3]],
        "0-1" => [[1, 0], [2, 1], [3, 2], [4, 1]],
        "0-2" => [[2, 1], [1, 2], [0, 3], [1, 4]],
        "0-3" => [[0, 1], [1, 0], [2, 1], [3, 2]],
        "1-0" => [[1, 0], [0, 1], [1, 2], [2, 3]],
        "1-1" => [[1, 2], [2, 1], [3, 0], [4, 1]],
        "1-2" => [[0, 1], [1, 2], [2, 3], [1, 4]],
        "1-3" => [[0, 1], [1, 2], [2, 1], [3, 0]],
    ],
    'R' => [
        "0-0" => [[1, 0], [2, 1], [2, 2], [2, 3], [3, 3]],
        "0-1" => [[1, 2], [2, 2], [3, 2], [2, 3], [4, 1]],
        "0-2" => [[1, 2], [2, 1], [2, 2], [2, 3], [3, 4]],
        "0-3" => [[0, 3], [1, 2], [2, 2], [3, 2], [2, 1]],
        "1-0" => [[1, 2], [2, 3], [2, 2], [2, 1], [3, 0]],
        "1-1" => [[1, 2], [2, 2], [3, 2], [2, 1], [4, 3]],
        "1-2" => [[1, 4], [2, 1], [2, 2], [2, 3], [3, 2]],
        "1-3" => [[0, 1], [1, 2], [2, 2], [3, 2], [2, 3]],
    ],
    'T' => [
        "0-0" => [[1, 0], [2, 0], [3, 0], [2, 1], [2, 2], [2, 3]],
        "0-1" => [[1, 2], [2, 2], [3, 2], [4, 1], [4, 2], [4, 3]],
        "0-2" => [[1, 4], [2, 4], [3, 4], [2, 1], [2, 2], [2, 3]],
        "0-3" => [[0, 1], [0, 2], [0, 3], [1, 2], [2, 2], [3, 2]],
    ],
    'X' => [
        "0-0" => [[1, 2], [2, 2], [3, 2], [2, 1], [2, 3]],
    ],
    'Z' => [
        "0-0" => [[1, 0], [2, 1], [2, 2], [2, 3], [3, 4]],
        "0-1" => [[0, 3], [1, 2], [2, 2], [3, 2], [4, 1]],
        "1-0" => [[3, 0], [2, 1], [2, 2], [2, 3], [1, 4]],
        "1-1" => [[0, 1], [1, 2], [2, 2], [3, 2], [4, 3]],
    ],
];

//Place all the shapes using Knuth's Algorithm X
function placeShapes(array $counts, array $shapesByPositions, array $positionsToFill, array $listShapes, $solution = []) {
    global $listShapesByLetter, $listLettersByShape;

    //We have placed evertying, return the solution
    if(!$positionsToFill) return $solution;
    
    //Find the next positions to work on
    $minCount = PHP_INT_MAX;
    $minPosition = null;

    foreach($positionsToFill as $index => $filler) {
        if($counts[$index] < $minCount) {
            $minPosition = $index;
            $minCount = $counts[$index];

            if($minPosition == 0) return null; //We have a position with no possible shapes
            if($minPosition == 1) break; //Can't do any better
        }
    }

    //We try all the shapes that can still be added at the position we have selected
    foreach($shapesByPositions[$minPosition] as $shapeID1 => $filler) {
        $counts2 = $counts;
        $listShapes2 = $listShapes;
        $positionsToFill2 = $positionsToFill;
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
            unset($positionsToFill2[$index1]);
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
        if(($result = placeShapes($counts2, $shapesByPositions2, $positionsToFill2, $listShapes2, $solution + [$shapeID1 => 1])) !== null) return $result;
    }

    return null;
}

$solution = null;

while (TRUE) {
    fscanf(STDIN, "%d", $n);

    $remaining = explode(" ", trim(fgets(STDIN)));

    error_log(var_export($remaining, 1));

    fscanf(STDIN, "%d", $n);

    $grid = array_fill(0, 11, str_repeat(".", 11));

    for ($i = 0; $i < $n; ++$i) {
        [$letter, $flip, $rotation, $y, $x] = explode(" ", trim(fgets(STDIN)));

        error_log("$letter $flip $rotation $y $x");

        if(!isset(TETRASTICKS[$letter][$flip . "-" . $rotation])) exit("Undifined Tetrastick!");
        else {
            foreach(TETRASTICKS[$letter][$flip . "-" . $rotation] as [$xm, $ym]) $grid[($y * 2) + $ym][($x * 2) + $xm] = $letter;

            error_log(var_export($grid, 1));
        }
    }

    error_log(var_export($grid, 1));

    exit();

    /**
     * Because of how we represent the grid we don't need to fill all the positions.
     * Some are for corners and don't need to be filled.
     * On odds rows, 1/2 positions are not used for anything.
     */
    $positionsToFill = []; 

    for($y1 = 0, $y2 = 0; $y1 < $h; $y1 += 3, $y2 += 2) {
        for($x1 = 0, $x2 = 0; $x1 < $w; $x1 += 3, $x2 += 2) {
            //Rows
            if($grid[$y1 + 1][$x1] == $grid[$y1 + 1][$x1 + 2] && $grid[$y1 + 1][$x1] != '.') $formattedGrid[$y2][$x2] = $grid[$y1 + 1][$x1];
            
            if($grid[$y1 + 1][$x1 + 2] != '.') $formattedGrid[$y2][$x2 + 1] = $grid[$y1 + 1][$x1 + 2];
            elseif($x1 != 15) $positionsToFill[$y2 * 11 + $x2 + 1] = 1;

            //Cols
            if($grid[$y1][$x1 + 1] == $grid[$y1 + 2][$x1 + 1] && $grid[$y1][$x1 + 1] != '.') $formattedGrid[$y2][$x2] = $grid[$y1][$x1 + 1];

            if($grid[$y1 + 2][$x1 + 1] != '.') $formattedGrid[$y2 + 1][$x2] = $grid[$y1 + 2][$x1 + 1];    
            elseif($y1 != 15) $positionsToFill[($y2 + 1) * 11 + $x2] = 1;
        }
    }

    foreach($formattedGrid as $line) error_log(var_export($line, 1));

    // error_log(var_export($positionsToFill, 1));

    if($solution === null) {
        $shapeIndex = 0;
        $shapesInfo = [];
        $listShapesByLetter = [];
        $counts = array_fill(0, 11 * 11, 0);
    
        foreach($remaining as $letter) {
            //Find all the positions where we can put this type of tetrastick
            for($y = 0; $y < 11; $y += 2) {
                for($x = 0; $x < 11; $x += 2) {
                    //Test all the rotations/mirrors
                    foreach(TETRASTICKS[$letter] as [$flip, $rotation, $tetrastick]) {
                        $positions = [];
        
                        foreach($tetrastick as [$xm, $ym]) {
                            $xp = $x + $xm;
                            $yp = $y + $ym;
        
                            if(($formattedGrid[$yp][$xp] ?? '#') != '.') {
                                continue 2; //Shape can't be inserted here
                            }
        
                            $positions[] = $yp * 11 + $xp;
                        }
        
                        $listShapes[$shapeIndex] = $positions;
                
                        foreach($positions as $positionIndex) {
                            $counts[$positionIndex]++;
                            $shapesByPositions[$positionIndex][$shapeIndex] = 1;
                        }
            
                        $listShapesByLetter[$letter][] = $shapeIndex;
                        $listLettersByShape[$shapeIndex] = $letter;

                        $shapesInfo[$shapeIndex] = [$letter, $flip, $rotation, $y >> 1, $x >> 1];
            
                        ++$shapeIndex;
                    }
                }
            }
        }
    
        $counts = array_filter($counts); //Remove all the positions where we can't put anything

        // error_log(var_export($counts, 1));
        // error_log(var_export($listShapes, 1));
        // error_log(var_export($shapesByPositions, 1));

        $solution = placeShapes($counts, $shapesByPositions, $positionsToFill, $listShapes);

        error_log(var_export($solution, 1));
    }

    echo implode(" ", $shapesInfo[array_key_last($solution)]) . PHP_EOL;

    array_pop($solution);
}
