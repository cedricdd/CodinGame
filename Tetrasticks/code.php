<?php

const TETRASTICKS = [
    'F' => [".F.", "F..", "FF.", "F..", "..."],
    'H' => ["...", "H..", "HH.", "H.H", "..."],
    'I' => [".", "I", "I", "I", "I", "I", "I", "I", "."],
    'J' => ["...", "..J", "..J", "J.J", ".J."],
    'L' => ["...", "L..", "L..", "L..", "L..", "L..", ".L."],
    'N' => ["...", "N..", ".N.", "..N", "..N", "..N", "..."],
    'O' => [".O.", "O.O", ".O."],
    'P' => [".P.", "..P", ".P.", "P..", "..."],
    'R' => [".R...", "..R..", "..RR.", "..R..", "....."],
    'T' => [".TTT.", "..T..", "..T..", "..T..", "....."],
    'U' => [".....", "U...U", ".UUU."],
    'V' => [".....", "....V", "....V", "....V", ".VVV."],
    'W' => ["...W.", "..W..", ".W...", "W....", "....."],
    'X' => [".....", "..X..", ".XXX.", "..X..", "....."],
    'Y' => ["...", "Y..", "YY.", "Y..", "Y..", "Y..", "..."],
    'Z' => [".Z...", "..Z..", "..Z..", "..Z..", "...Z."],
];

//Rotate an array 90° clockwise
function rotate90(array $input): array {
    $h = count($input);
    $w = strlen($input[0]);
    $rotated = array_fill(0, $w, "");

   for($x = 0; $x < $w; ++$x) {
        for($y = $h - 1; $y >= 0; --$y) {
            $rotated[$x] .= $input[$y][$x];
        }
   } 

   return $rotated;
}

//Generate all the tetraskitcks (rotation & mirror)
function generateTetrasticks(): array {
    $tetrasticks = [];

    foreach(TETRASTICKS as $letter => $shape) {
        $hashes = [];

        for($flip = 0; $flip <= 1; $flip++) {
            for($rotation = 0; $rotation < 4; ++$rotation) {
                $hash = implode("-", $shape);

                //Not every rotation/mirror is unique
                if(!isset($hashes[$hash])) {
                    foreach($shape as $y => $line) {
                        foreach(str_split($line) as $x => $c) {
                            if($c != '.') $tetrasticks[$letter][$flip . "-" . $rotation][] = [$x, $y];
                        }
                    }
                }

                $hashes[$hash] = 1;
    
                $shape = rotate90($shape);
            }

            $shape = array_map("strrev", $shape); //Flip the shape
        }
    }

    return $tetrasticks;
}

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

            if($minPosition == 1) break; //Can't do any better
        }
    }

    //We try all the shapes that can still be added at the position we have selected
    foreach($shapesByPositions[$minPosition] as $shapeID1 => $filler) {
        $counts2 = $counts;
        $listShapes2 = $listShapes;
        $shapesByPositions2 = $shapesByPositions;
        $positionsToFill2 = array_diff_key($positionsToFill, $listShapes[$shapeID1]);

        //Loop through all the position occupied by the shape we are adding
        foreach($listShapes[$shapeID1] as $index1 => $filler) {

            if(!isset($shapesByPositions2[$index1])) continue; //This position has already been removed

            //Loop through all the shapes that could have been placed at this position
            foreach($shapesByPositions[$index1] as $shapeID2 => $filler) {

                if(!isset($listShapes2[$shapeID2])) continue; //This shape has already been removed

                foreach($listShapes[$shapeID2] as $index2 => $filler) {
                    if(--$counts2[$index2] == 0 && isset($positionsToFill2[$index2])) continue 4; //We have a position with nothing left => invalid
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

        //Loop through all the shapes of this type
        foreach($listShapesByLetter[$type] as $shapeID) {

            if(!isset($listShapes2[$shapeID])) continue; //We have alreade removed this shape

            //Update all the positions
            foreach($listShapes2[$shapeID] as $index => $filler) {
                if(--$counts2[$index] == 0 && isset($positionsToFill2[$index])) continue 3; //We have a position with nothing left => invalid
                unset($shapesByPositions2[$index][$shapeID]);
            }
        }

        //If using the shape gets us a solution we can stop here.
        if(($result = placeShapes($counts2, $shapesByPositions2, $positionsToFill2, $listShapes2, $solution + [$shapeID1 => 1])) !== null) return $result;
    }

    return null;
}

$solution = null;

$tetrasticks = generateTetrasticks();

while (TRUE) {
    fscanf(STDIN, "%d", $n);

    $start = microtime(1);

    $remaining = explode(" ", trim(fgets(STDIN)));

    fscanf(STDIN, "%d", $n);

    $grid = array_fill(0, 11, str_repeat(".", 11));

    for ($i = 0; $i < $n; ++$i) {
        [$letter, $flip, $rotation, $y, $x] = explode(" ", trim(fgets(STDIN)));

        if(!isset($tetrasticks[$letter][$flip . "-" . $rotation])) exit("Undifined Tetrastick!");
        else {
            foreach($tetrasticks[$letter][$flip . "-" . $rotation] as [$xm, $ym]) $grid[($y * 2) + $ym][($x * 2) + $xm] = $letter;
        }
    }

    /**
     * Because of how we represent the grid we don't need to fill all the positions.
     * Some are for corners and don't need to be filled.
     * On odds rows, 1/2 positions are not used for anything.
     */
    $positionsToFill = []; 

    for($y = 0; $y < 11; ++$y) {
        for($x = ($y & 1 ? 0: 1); $x < 11; $x += 2) {
            if($grid[$y][$x] == '.') $positionsToFill[$y * 11 + $x] = 1;
        }
    }

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
                    foreach($tetrasticks[$letter] as $index => $tetrastick) {
                        [$flip, $rotation] = explode("-", $index);
                        $positions = [];
        
                        foreach($tetrastick as [$xm, $ym]) {
                            $xp = $x + $xm;
                            $yp = $y + $ym;
        
                            if(($grid[$yp][$xp] ?? '#') != '.') continue 2; //Shape can't be inserted here
        
                            $positions[$yp * 11 + $xp] = 1;
                        }
        
                        $listShapes[$shapeIndex] = $positions;
                        $count = count($positions);
                
                        foreach($positions as $positionIndex => $filler) {
                            $counts[$positionIndex]++;
                            $shapesByPositions[$positionIndex][$shapeIndex] = $count;
                        }
            
                        $listShapesByLetter[$letter][] = $shapeIndex;
                        $listLettersByShape[$shapeIndex] = $letter;

                        $shapesInfo[$shapeIndex] = [$letter, $flip, $rotation, $y >> 1, $x >> 1];
            
                        ++$shapeIndex;
                    }
                }
            }
        }
        
        //For each positions we sort the possible shapes by number of positions they occupy, from most to least
        array_walk($shapesByPositions, 'arsort');

        $counts = array_filter($counts); //Remove all the positions where we can't put anything

        $solution = placeShapes($counts, $shapesByPositions, $positionsToFill, $listShapes);
    }

    echo implode(" ", $shapesInfo[array_key_last($solution)]) . PHP_EOL;

    array_pop($solution);

    error_log(microtime(1) - $start);
}
