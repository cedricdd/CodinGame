<?php

$start = microtime(1);

[$folds, $cut] = explode("-", trim(fgets(STDIN)));

//The start of the paper
if($cut == "tl") $groups = ["1000" => 1];
elseif($cut == "tr") $groups = ["0100" => 1];
elseif($cut == "bl") $groups = ["0010" => 1];
elseif($cut == "br") $groups = ["0001" => 1];

$cuts = 0;
$foldsCount = strlen($folds);

//We unfold the paper
foreach(str_split(strrev($folds)) as $index => $fold) {
    //It's impossible to create a 'hole' with exactly 3 parts or the diagonals 0110 & 1001
    $newGroups = ["0001" => 0, "0010" => 0, "0100" => 0, "1000" => 0, "1100" => 0, "0011" => 0, "1010" => 0, "0101" => 0, "1111" => 0];

    foreach($groups as $group => $count) {
        if($count == 0) continue;

        //Unfold from left ot the right
        if($fold == 'R') {
            switch($group) {
                case "0001": $newGroups["0011"] += $count;  break;
                case "0010": 
                    $newGroups["0010"] += $count;  
                    $newGroups["0001"] += $count;  
                    break;
                case "0100": $newGroups["1100"] += $count;  break;
                case "1000": 
                    $newGroups["1000"] += $count;  
                    $newGroups["0100"] += $count;  
                    break;
                case "1010": 
                    $newGroups["1010"] += $count;  
                    $newGroups["0101"] += $count;  
                    break;
                case "0101": $newGroups["1111"] += $count;  break;
                case "0011": $newGroups["0011"] += 2 * $count;  break;
                case "1100": $newGroups["1100"] += 2 * $count;  break;
                default: exit("$group shouldn't exist!");
            }
        } //Unfold from the right to the left
        elseif($fold == 'L') {
            switch($group) {
                case "0001": 
                    $newGroups["0001"] += $count;  
                    $newGroups["0010"] += $count;  
                    break;
                case "0010": $newGroups["0011"] += $count;  break;
                case "0100": 
                    $newGroups["0100"] += $count;  
                    $newGroups["1000"] += $count;  
                    break;
                case "1000": $newGroups["1100"] += $count;  break;
                case "1010": $newGroups["1111"] += $count;  break;
                case "0101": 
                    $newGroups["0101"] += $count;  
                    $newGroups["1010"] += $count;  
                    break;
                case "0011": $newGroups["0011"] += 2 * $count;  break;
                case "1100": $newGroups["1100"] += 2 * $count;  break;
                default: exit("$group shouldn't exist!");
            }
        } //Unfold from the top to the bottom
        elseif($fold == 'B') {
            switch($group) {
                case "0001": $newGroups["0101"] += $count;  break;
                case "0010": $newGroups["1010"] += $count;  break;
                case "0100": 
                    $newGroups["0100"] += $count; 
                    $newGroups["0001"] += $count; 
                    break;
                case "1000": 
                    $newGroups["1000"] += $count;  
                    $newGroups["0010"] += $count;  
                    break;
                case "1010": $newGroups["1010"] += 2 * $count;  break;
                case "0101": $newGroups["0101"] += 2 * $count;  break;
                case "0011": $newGroups["1111"] += $count;  break;
                case "1100": 
                    $newGroups["1100"] += $count;  
                    $newGroups["0011"] += $count;  
                    break;
                default: exit("$group shouldn't exist!");
            }
        } //Unfold from the bottom to the top
        elseif($fold == 'T') {
            switch($group) {
                case "0001": 
                    $newGroups["0001"] += $count;  
                    $newGroups["0100"] += $count;  
                    break;
                case "0010": 
                    $newGroups["0010"] += $count;  
                    $newGroups["1000"] += $count;  
                    break;
                case "0100": $newGroups["0101"] += $count;  break;
                case "1000": $newGroups["1010"] += $count;  break;
                case "1010": $newGroups["1010"] += 2 * $count;  break;
                case "0101": $newGroups["0101"] += 2 * $count;  break;
                case "0011": 
                    $newGroups["0011"] += $count;    
                    $newGroups["1100"] += $count;    
                    break;
                case "1100": $newGroups["1111"] += $count;  break;

                default: exit("$group shouldn't exist!");
            }
        }
    }

    //We have created a 'full' cut, for each folds remaining the count will be multiply by 2
    if(($newGroups["1111"])) {
        $cuts += $newGroups["1111"] * (2 ** ($foldsCount - $index - 1));
        
        unset($newGroups["1111"]);
    }

    $groups = $newGroups;

    if(!$groups) break; //There is nothing left to work on
}

echo $cuts . PHP_EOL;

error_log(microtime(1) - $start);
