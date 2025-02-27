<?php

const TETRASTICKS = [
    'Z' => [
        [[0, 1], [2, 1], [2, 2], [2, 3], [3, 4]],
        [[0, 3], [1, 2], [2, 2], [3, 2], [4, 1]],
        [[3, 0], [2, 1], [2, 2], [2, 3], [1, 4]],
        [[0, 1], [1, 2], [2, 2], [3, 2], [4, 3]],
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
                foreach(TETRASTICKS[$letter] as $list) {
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


$solution = null;

while (TRUE) {
    fscanf(STDIN, "%d", $n);

    $remaining = explode(" ", trim(fgets(STDIN)));

    error_log(var_export($remaining, 1));

    fscanf(STDIN, "%d %d", $h, $w);

    error_log("$w $h");

    for ($y = 0; $y < $h; ++$y) $grid[] = trim(fgets(STDIN));

    $positionsToFill = [];
    $formattedGrid = array_fill(0, 11, str_repeat(".", 11));

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

    error_log(var_export($positionsToFill, 1));

    exit();

    if($solution === null) {
        $listShapesByLetter = [];
        $shapeIndex = 0;
        $counts = array_fill(0, $w * $h, 0);
    
        foreach($remaining as $letter) {
            //Find all the positions where we can put this type of tetrastick
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
    
        $counts = array_filter($counts); //Remove all the positions where we can't put anything
    }
}
