<?php

$start = microtime(1);

/**
 * We are using an integer to represent the patch, each patchs is 9 positions so this will only work if we have at max 7 possible characters.
 * This is currently the case for all tests/validators. This is a lot faster than the generic code.
 **/

const MASK = [127, 16256, 2080768, 266338304, 34091302912, 4363686772736, 558551906910208, 71494644084506624, 9151314442816847872];

fscanf(STDIN, "%d %d", $W1, $H1);
for ($i = 0; $i < $H1; $i++) {
    $prototype[] = trim(fgets(STDIN));
}

$size = 7;
$index = 0;

//Set the value for each characters
foreach(str_split(count_chars(implode("", $prototype), 3)) as $character) {
    $values[$character] = 2 ** ($index++);
 }

 $values['?'] = (2 ** $index) - 1; //Unknown character can be any of the characters


//Generate the value of all the patches
for($y = 1; $y < $H1 - 1; ++$y) {
    for($x = 1; $x < $W1 - 1; ++$x) {
        $patch = 0;

        for($y2 = $y - 1, $i = 0; $y2 <= $y + 1; ++$y2) {
            for($x2 = $x - 1; $x2 <= $x + 1; ++$x2, ++$i) {
                $patch |= $values[$prototype[$y2][$x2]] << ($size * $i);
            }
        }

        $patches[$patch] = 1; //We don't need duplicate patches
    }
}

$patches = array_keys($patches); 
$patchesIDs = range(0, count($patches) - 1);

fscanf(STDIN, "%d %d", $W2, $H2);
for ($i = 0; $i < $H2; $i++) {
    $partial[] = trim(fgets(STDIN));
}

//Set all the possibilites for each positions
for($y = 0; $y < $H2; ++$y) {
    for($x = 0; $x < $W2; ++$x) {
        $possibilities[$y * $W2 + $x] = $values[$partial[$y][$x]] ?? 0; //Some characters in partial solution are set are not in prototype

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

    foreach($checks as $checkID => [$patchesIDs, $positions]) {
        $count = count($patchesIDs);

        if($count <= 1) continue; //No need to work on this position anymore
        else {
            $updatedPossibilities = 0;

            $constrain = 0;

            //Generate the value of constrain at this position
            foreach($positions as $i => $position) $constrain |= $possibilities[$position] << ($size * $i);

            //Check all the patches that can still be placed here
            foreach($patchesIDs as $patchID) {
                $patch = $patches[$patchID];

                //We can't use this patch here
                if(($constrain & $patch) != $patch) {
                    unset($checks[$checkID][0][$patchID]); //No need to check this patch here anymore

                    $reduced = true;
                    
                    continue;
                }

                //This patch can go here, constrain the symbols
                $updatedPossibilities |= $patch;
            }

            //If we have 0 patch that can go here we don't constrain
            if($updatedPossibilities != 0) {
                //Update all the positions with the constrained characters
                foreach($positions as $i => $position) $possibilities[$position] = ($updatedPossibilities & MASK[$i]) >> ($size * $i);
            }
        }
    }
} while($reduced);


$values = array_flip($values);

//Replace all the unkown values in partial
foreach($partial as $y => $line) {
    for($x = 0; $x < $W2; ++$x) {
        if($partial[$y][$x] == '?') $partial[$y][$x] = $values[$possibilities[$y * $W2 + $x]];
    }
}

echo implode(PHP_EOL, $partial) . PHP_EOL;

/*
//This will work no matter the number of possible characters for a position

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
    $partial[] = str_split(trim(fgets(STDIN)));
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

    foreach($checks as $checkID => [$patchesIDs, $positions]) {
        $count = count($patchesIDs);

        if($count <= 1) continue; //No need to work on this position anymore
        else {
            $updatedPossibilities = [];

            //Check all the patches that can still be placed here
            foreach($patchesIDs as $patchID) {
                $patch = $patches[$patchID];

                for($index = 0; $index < 9; ++$index) {
                    //We know the patch can't go here
                    if(!isset($possibilities[$positions[$index]][$patch[$index]])) {
                        unset($checks[$checkID][0][$patchID]); //No need to check this patch here anymore

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
*/

error_log(microtime(1) - $start);
