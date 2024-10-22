<?php

$start = microtime(1);

$unbalanced = stream_get_line(STDIN, 1024 + 1, "\n");

error_log("$unbalanced");

[$leftEquation, $rightEquation] = explode(" -> ", $unbalanced);

//Get all the molecules on the left part of the equation
foreach(explode(" + ", $leftEquation) as $leftMolecule) {
    preg_match_all("/[A-Z][a-z]*[0-9]*/", $leftMolecule, $molecule);

    foreach($molecule[0] as $info) {
        preg_match("/([a-zA-Z]+)([0-9]*)/", $info, $match);

        $element = $match[1];
        $count = $match[2] ?: 1;

        $elementsLeft[$element] = ($elementsLeft[$element] ?? 0) + $count;
        $left[$leftMolecule][$element] = ($left[$leftMolecule][$element] ?? 0) + $count;
    }
}

//Get all the molecules on the right part of the equation
foreach(explode(" + ", $rightEquation) as $rightMolecule) {
    preg_match_all("/[A-Z][a-z]*[0-9]*/", $rightMolecule, $molecule);

    foreach($molecule[0] as $info) {
        preg_match("/([a-zA-Z]+)([0-9]*)/", $info, $match);

        $element = $match[1];
        $count = $match[2] ?: 1;

        $elementsRight[$element] = ($elementsRight[$element] ?? 0) + $count;
        $right[$rightMolecule][$element] = ($right[$rightMolecule][$element] ?? 0) + $count;
    }
}

//We want to be able to compare them, make sure it's the same order
ksort($elementsLeft);
ksort($elementsRight);

$coeffLeft = [];
$coeffRight = [];

foreach($left as $molecule => $filler) $coeffLeft[$molecule] = 1;
foreach($right as $molecule => $filler) $coeffRight[$molecule] = 1;

$toCheck = [[$elementsLeft, $elementsRight, $coeffLeft, $coeffRight]];

while(true) {
    $newCheck = [];

    foreach($toCheck as [$elementsLeft, $elementsRight, $coeffLeft, $coeffRight]) {

        $hash = serialize($coeffLeft) . "-" . serialize($coeffRight);

        //Make sure we don't test several time the same coefficients
        if(isset($history[$hash])) continue;
        else $history[$hash] = 1;

        if($elementsLeft == $elementsRight) {
            foreach($coeffLeft as $name => $count) {
                if($count == 1) $coeffLeft[$name] = $name;
                else $coeffLeft[$name] .= $name;
            }
            foreach($coeffRight as $name => $count) {
                if($count == 1) $coeffRight[$name] = $name;
                else $coeffRight[$name] .= $name;
            }
    
            echo implode(" + ", $coeffLeft) . " -> " . implode(" + ", $coeffRight) . PHP_EOL;
    
            break 2;
        }

        foreach($elementsLeft as $element => $count) {
            if($elementsRight[$element] == $count) continue; //We have the same amount on both sides
    
            //We need more on the left
            if($elementsRight[$element] > $count) {
                foreach($left as $moleculeID => $molecule) {
                    //This molecule has the element we need
                    if(isset($molecule[$element])) {
                        $elementsLeft2 = $elementsLeft;
                        $coeffLeft2 = $coeffLeft;
    
                        //Add enough to reach the current count on right
                        while($elementsLeft2[$element] < $elementsRight[$element]) {
                            foreach($molecule as $element2 => $count2) $elementsLeft2[$element2] += $count2;
    
                            $coeffLeft2[$moleculeID]++;
                        }
    
                        $newCheck[] = [$elementsLeft2, $elementsRight, $coeffLeft2, $coeffRight];
                    }
                }
            } //We need more on the right
            else {
                foreach($right as $moleculeID => $molecule) {
                    //This molecule has the element we need
                    if(isset($molecule[$element])) {
                        $elementsRight2 = $elementsRight;
                        $coeffRight2 = $coeffRight;
    
                        //Add enough to reach the current count on left
                        while($elementsRight2[$element] < $elementsLeft[$element]) {
                            foreach($molecule as $element2 => $count2) $elementsRight2[$element2] += $count2;
    
                            $coeffRight2[$moleculeID]++;
                        }

                        $newCheck[] = [$elementsLeft, $elementsRight2, $coeffLeft, $coeffRight2];
                    }
                }
            }
        }
    }

    $toCheck = $newCheck;
}

error_log(microtime(1) - $start);
