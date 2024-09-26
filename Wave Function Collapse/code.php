<?php

$characters = [];

fscanf(STDIN, "%d %d", $W1, $H1);
for ($i = 0; $i < $H1; $i++) {
    $line = trim(fgets(STDIN));

    //We save all the possible characters for the unknown positions
    if($i > 0 && $i < $H1 - 1) $characters += array_flip(str_split(substr($line, 1, -1)));

    $prototype[] = $line;
}

//Generate all the patches
for($y = 1; $y < $H1 - 1; ++$y) {
    for($x = 1; $x < $W1 - 1; ++$x) {
        $patch = $prototype[$y - 1][$x - 1] . $prototype[$y - 1][$x] . $prototype[$y - 1][$x + 1] 
            . $prototype[$y][$x - 1] . $prototype[$y][$x] . $prototype[$y][$x + 1] 
            . $prototype[$y + 1][$x - 1] . $prototype[$y + 1][$x] . $prototype[$y + 1][$x + 1];

        $patches[$patch] = $patch; //We don't need duplicate patches
    }
}

$patches = array_values($patches);
$patchesIDs = array_keys($patches);

fscanf(STDIN, "%d %d", $W2, $H2);
for ($i = 0; $i < $H2; $i++) {
    $partial [] = str_split(trim(fgets(STDIN)));
}

//Set all the possibilites for each positions
for($y = 0; $y < $H2; ++$y) {
    for($x = 0; $x < $W2; ++$x) {
        $possibilities[$y * $W2 + $x] = $partial[$y][$x] == '?' ? $characters : [$partial[$y][$x] => 1];

        //At this position we will try to constrain patches
        if($y > 0 && $y < $H2 - 1 && $x > 0 && $x < $W2 - 1) {
            $index = $y * $W2 + $x;

            $checks[$index] = [
                $patchesIDs, 
                [
                    $index - $W2 - 1, $index - $W2, $index - $W2 + 1, 
                    $index - 1, $index, $index + 1, 
                    $index + $W2 - 1, $index + $W2, $index + $W2 + 1, 
                ]
            ];
        }
    }
}

do {
    $reduced = false;

    foreach($checks as $test => [$patchesIDs, $positions]) {
        $count = count($patchesIDs);

        if($count <= 1) continue; //No need to work on this position anymore
        else {
            $updatedPossibilities = [];

            //Check all the patches that can still be placed here
            foreach($patchesIDs as $id) {
                $patch = $patches[$id];

                for($index = 0; $index < 9; ++$index) {
                    //We know the patch can't go here
                    if(!isset($possibilities[$positions[$index]][$patch[$index]])) {
                        unset($checks[$test][0][$id]); //No need to check this patch here anymore

                        $reduced = true;
                        
                        continue 2;
                    }
                }

                //This patch can go here, constrain the symbols
                for($index = 0; $index < 9; ++$index) $updatedPossibilities[$positions[$index]][$patch[$index]] = 1;
            }

            //The new constrains replace the old ones for the positions we worked on
            $possibilities = $updatedPossibilities + $possibilities;
        }
    }
} while($reduced);

ksort($possibilities); //We need to sort in proper order to display

echo implode(PHP_EOL, str_split(implode("", array_map("array_key_first", $possibilities)), $W2)) . PHP_EOL;
