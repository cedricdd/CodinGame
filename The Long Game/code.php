<?php

const OPERATIONS = ["+", "-", "/", "*"];

$start = microtime(1);

$numbers = explode(" ", trim(fgets(STDIN)));

//Generate all the permutations with the list of numbers
function generatePermutations(array $numbers, array $permutation, array &$permutations): void {
    if(count($numbers) == 0) {
        $permutations[implode("-", $permutation)] = $permutation; //We don't need duplicate permutations
        return;
    }

    foreach($numbers as $i => $number) {
        $permutation[] = $number;
        unset($numbers[$i]);
        generatePermutations($numbers, $permutation, $permutations);

        $numbers[$i] = $number;
        array_pop($permutation);
    }
}

$solutions = [];
$permutations = [];
generatePermutations($numbers, [], $permutations);

foreach($permutations as [$n1, $n2, $n3, $n4]) {
    foreach(OPERATIONS as $op1) {
        foreach(OPERATIONS as $op2) {
            foreach(OPERATIONS as $op3) {
                //1-2-3
                if(round(@eval("return (($n1 $op1 $n2) $op2 $n3) $op3 $n4;"), 4) == 24) $solutions[] = "(($n1 $op1 $n2) $op2 $n3) $op3 $n4";
                //1-3-2
                if(round(@eval("return ($n1 $op1 $n2) $op2 ($n3 $op3 $n4);"), 4) == 24) $solutions[] = "($n1 $op1 $n2) $op2 ($n3 $op3 $n4)";
                //2-1-3
                if(round(@eval("return ($n1 $op1 ($n2 $op2 $n3)) $op3 $n4;"), 4) == 24) $solutions[] = "($n1 $op1 ($n2 $op2 $n3)) $op3 $n4";
                //2-3-1
                if(round(@eval("return $n1 $op1 (($n2 $op2 $n3) $op3 $n4);"), 4) == 24) $solutions[] = "$n1 $op1 (($n2 $op2 $n3) $op3 $n4)";
                //3-2-1
                if(round(@eval("return $n1 $op1 ($n2 $op2 ($n3 $op3 $n4));"), 4) == 24) $solutions[] = "$n1 $op1 ($n2 $op2 ($n3 $op3 $n4))";
            }
        }
    }
}

if(count($solutions) == 0) exit("not possible");

//Remove spaces
foreach($solutions as $solution) $solutions1[preg_replace("/\s/", "", $solution)] = 1;

foreach($solutions1 as $solution => $filler) {
    //Only addition & substraction + only multiplication & division
    if(preg_match("/^[0-9\+\-\(\)]+$/", $solution) || preg_match("/^[0-9\*\/\(\)]+$/", $solution)) {
        unset($solutions1[$solution]);

        $solutions1[preg_replace("/[\(\)]/", "", $solution)] = 1;
    }
}

do {
    $changed = false;

    //Remove unnecessary parentheses
    foreach($solutions1 as $solution => $filler) {
        //Multiplication & division inside a parenthese
        if(preg_match("/(.*)\(((?:[0-9]+|\([^\(\)]+\))\*(?:[0-9]+|\([^\(\)]+\)))\)(.*)/", $solution, $matches)) {
            unset($solutions1[$solution]);

            $updated = $matches[1] . $matches[2] . $matches[3];

            $solutions1[$updated] = 1;

            error_log("here $solution => $updated");

            if(eval("return $solution;") != eval("return $updated;")) error_log("not matching!!!!!!!!!");

            $changed = true;
        } 
    }
} while($changed);

error_log(var_export($solutions1, true));

error_log(microtime(1) - $start);
