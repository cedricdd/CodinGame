<?php

function display(array $placements) {
    global $positions, $width, $height, $start;

    $output = array_fill(0, $height, str_repeat(" ", $width));

    //Place all the words
    foreach($placements as $placementID => $filler) {
        foreach($positions[$placementID] as $position => $letter) {
            $output[intdiv($position, $width)][$position % $width] = $letter;
        }
    }

    echo implode(PHP_EOL, $output) . PHP_EOL;

    error_log(microtime(1) - $start);

    exit();
}

function solve(array $counts, array $placementsPossible, array $placementsUsed) {
    global $conflicts;

    if(!$counts) {
        display($placementsUsed);

        return;
    }

    //Work on the word with the less possible placement
    $wordID = null;
    $wordCount = PHP_INT_MAX;

    foreach($counts as $id => $count) {
        if($count < $wordCount) {
            $wordCount = $count;
            $wordID = $id;
        }
    }

    foreach($placementsPossible[$wordID] as $placementID1 => $filler1) {
        $counts2 = $counts;
        $placementsPossible2 = $placementsPossible;

        unset($counts2[$wordID]);
        unset($placementsPossible2[$wordID]);

        //Remove all the placements that are no longer possible
        foreach(($conflicts[$placementID1] ?? []) as $placementID2 => $wordID2) {
            if(isset($placementsPossible2[$wordID2][$placementID2])) {
                if($counts2[$wordID2]-- == 0) continue 2;
                
                unset($placementsPossible2[$wordID2][$placementID2]);
            }
        }

        solve($counts2, $placementsPossible2, $placementsUsed + [$placementID1 => 1]);
    }
}

$start = microtime(1);

fscanf(STDIN, "%d %d", $height, $width);

for ($i = 0; $i < $height; $i++) {
    $grid[] = trim(fgets(STDIN));
}

$lettersByPosition = [];
$wordByPlacementID = [];
$placements = [];
$positions = [];
$conflicts = [];
$counts = [];
$placementID = 0;

foreach(explode(" ", trim(fgets(STDIN))) as $index => $word) {
    $l = strlen($word);

    $directions = [
        [0, $height, 0, $width - $l + 1, 0, 1], //Horizontal, left to right
        [0, $height, $l - 1, $width, 0, -1], //Horizontal, right to left
        [0, $height - $l + 1, 0, $width, 1, 0], //Vertical, top to bottom
        [$l - 1, $height, 0, $width, -1, 0], //Vertical, bottom to top
        [0, $height - $l + 1, 0, $width - $l + 1, 1, 1], //Diagonal, to bottom-right
        [0, $height - $l + 1, $l - 1, $width, 1, -1], //Diagonal, to bottom-left
        [$l - 1, $height, 0, $width - $l + 1, -1, 1], //Diagonal, to top-right
        [$l - 1, $height, $l - 1, $width, -1, -1], //Diagonal, to top-left
    ];

    foreach($directions as $test => [$minY, $maxY, $minX, $maxX, $cy, $cx]) {
        //Check all the starting positions for that direction
        for($y = $minY; $y < $maxY; ++$y) {
            for($x = $minX; $x < $maxX; ++$x) {
                $pos = [];
    
                //Check if the word can be written here
                for($i = 0; $i < $l; ++$i) {

                    //There's a letter that doesn't match
                    if($grid[$y + ($cy * $i)][$x + ($cx * $i)] != '.' && $grid[$y + ($cy * $i)][$x + ($cx * $i)] != $word[$i]) continue 2;
    
                    $pos[($y + ($cy * $i)) * $width + $x + ($cx * $i)] = $word[$i];
                }
    
                //We have found a place to add this word
                $placements[$index][$placementID] = 1;
    
                foreach($pos as $i => $c) {
                    $positions[$placementID][$i] = $c;
                    $lettersByPosition[$i][$placementID] = $c;
                }
    
                $wordByPlacementID[$placementID] = $index;
    
                ++$placementID;
            }
        }
    }
}

//Find all the placements that become impossible once you place a given word
foreach($placements as $wordID => $list) {
    foreach($list as $placementID1 => $filler) {
        foreach($positions[$placementID1] as $positionIndex => $letter1) {
            foreach($lettersByPosition[$positionIndex] as $placementID2 => $letter2) {
                if($letter1 != $letter2) $conflicts[$placementID1][$placementID2] = $wordByPlacementID[$placementID2];
            }
        }
    }

    $counts[$wordID] = count($list);
}

solve($counts, $placements, []);
