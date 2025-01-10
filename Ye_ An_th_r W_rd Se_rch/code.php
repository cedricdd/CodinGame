<?php

function display(array $placements) {
    global $positions, $width, $height;

    $output = array_fill(0, $height, str_repeat(" ", $width));

    foreach($placements as $placementID => $filler) {
        foreach($positions[$placementID] as $position => $letter) {
            $output[intdiv($position, $width)][$position % $width] = $letter;
        }
    }

    echo implode(PHP_EOL, $output) . PHP_EOL;
}

function solve(array $counts, array $placements, array $used) {
    global $conflicts;

    //Work on the word with the less possible placement
    $wordID = null;
    $wordCount = PHP_INT_MAX;

    foreach($counts as $id => $count) {
        if($count < $wordCount) {
            $wordCount = $count;
            $wordID = $id;
        }
    }

    if($wordID === null) {
        error_log("we are done");
        error_log(var_export($used, 1));

        display($used);

        return;
    }

    foreach($placements[$wordID] as $placementID1 => $filler1) {
        // error_log("working on $wordID - $placementID1");

        $counts2 = $counts;
        $placements2 = $placements;

        unset($counts2[$wordID]);
        unset($placements2[$wordID]);

        foreach(($conflicts[$placementID1] ?? []) as $placementID2 => $wordID2) {
            // error_log("we can't use $placementID2 for $wordID2 anymore");

            if(isset($placements2[$wordID2][$placementID2])) {
                if($counts2[$wordID2]-- == 0) continue 2;
                
                unset($placements2[$wordID2][$placementID2]);
            }
        }

        solve($counts2, $placements2, $used + [$placementID1 => 1]);
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
$ID = 0;

foreach(explode(" ", trim(fgets(STDIN))) as $index => $word) {
    $l = strlen($word);

    //Horizontal - Right
    for($y = 0; $y < $height; ++$y) {
        for($x = 0; $x <= $width - $l; ++$x) {
            $pos = [];

            for($i = 0; $i < $l; ++$i) {
                if($grid[$y][$x + $i] != '.' && $grid[$y][$x + $i] != $word[$i]) continue 2;

                $pos[$y * $width + $x + $i] = $word[$i];
            }

            // error_log("$word can start at $x $y - horizontal");

            $placements[$index][$ID] = 1;

            foreach($pos as $i => $c) {
                $positions[$ID][$i] = $c;
                $lettersByPosition[$i][$ID] = $c;
            }

            $wordByPlacementID[$ID] = $index;

            ++$ID;
        }
    }

    //Horizontal - Left
    for($y = 0; $y < $height; ++$y) {
        for($x = $width - 1; $x >= $l - 1; --$x) {
            $pos = [];

            for($i = 0; $i < $l; ++$i) {
                if($grid[$y][$x - $i] != '.' && $grid[$y][$x - $i] != $word[$i]) continue 2;

                $pos[$y * $width + $x - $i] = $word[$i];
            }

            // error_log("$word can start at $x $y - horizontal");

            $placements[$index][$ID] = 1;

            foreach($pos as $i => $c) {
                $positions[$ID][$i] = $c;
                $lettersByPosition[$i][$ID] = $c;
            }

            $wordByPlacementID[$ID] = $index;

            ++$ID;
        }
    }

    //Vertical - Down
    for($y = 0; $y <= $height - $l; ++$y) {
        for($x = 0; $x < $width; ++$x) {
            $pos = [];

            for($i = 0; $i < $l; ++$i) {
                if($grid[$y + $i][$x] != '.' && $grid[$y + $i][$x] != $word[$i]) continue 2;

                $pos[($y + $i) * $width + $x] = $word[$i];
            }

            // error_log("$word can start at $x $y - vertical");

            $placements[$index][$ID] = 1;

            foreach($pos as $i => $c) {
                $positions[$ID][$i] = $c;
                $lettersByPosition[$i][$ID] = $c;
            }

            $wordByPlacementID[$ID] = $index;

            ++$ID;
        }
    }

    //Vertical - Up
    for($y = $height - 1; $y >= $l - 1; --$y) {
        for($x = 0; $x < $width; ++$x) {
            $pos = [];

            for($i = 0; $i < $l; ++$i) {
                if($grid[$y - $i][$x] != '.' && $grid[$y - $i][$x] != $word[$i]) continue 2;

                $pos[($y - $i) * $width + $x] = $word[$i];
            }

            // error_log("$word can start at $x $y - vertical");

            $placements[$index][$ID] = 1;

            foreach($pos as $i => $c) {
                $positions[$ID][$i] = $c;
                $lettersByPosition[$i][$ID] = $c;
            }

            $wordByPlacementID[$ID] = $index;

            ++$ID;
        }
    }
}

// error_log(var_export($placements, 1));
// error_log(var_export($positions, 1));
// error_log(var_export($lettersByPosition, 1));

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

// error_log(var_export($conflicts, 1));

solve($counts, $placements, []);

error_log(microtime(1) - $start);
