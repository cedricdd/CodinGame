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
foreach($solutions as $solution) $solutionsTemp[preg_replace("/\s/", "", $solution)] = 1;

$solutions = $solutionsTemp;
$solutionsTemp = [];

foreach($solutions as $solution => $filler) {

    //Remove unnecessary parentheses:
    while(true) {
        //error_log("starting: $solution");
        $opening = [];

        foreach(str_split($solution) as $i => $c) {
            if($c === "(") $opening[] = $i;
            elseif($c === ")") {
                $begin = array_pop($opening);
    
                //error_log("found parant $begin $i");
    
                $updated = substr($solution, 0, $begin) . substr($solution, $begin + 1, $i - $begin - 1) . substr($solution, $i + 1);
    
                //error_log("updated: $updated");
    
                if(eval("return $updated;") == 24) {
                    //error_log("parant are useless");
    
                    $solution = $updated;

                    continue 2;
                }
            }
        }

        break;
    }

    //Rewrite expression with substraction
    if(preg_match("/(.*\-)\((.*)\)(.*)/", $solution, $matches)) {
        //error_log(var_export($matches, true));

        $terms = preg_split("/([\+\-])/", $matches[2], -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        //error_log(var_export($elements, true));

        foreach($terms as &$term) {
            $term = strtr($term, ["+" => "-", "-" => "+"]);
        }

        $solution = $matches[1] . implode("", $terms) . $matches[3];
    }

    //Rewrite expression with division
    if(preg_match("/(.*)\/\(([^\/]+)\/([^\/]+)\)(.*)/", $solution, $matches)) {
        //error_log(var_export($solution, true));
        //error_log(var_export($matches, true));

        $solution = $matches[1] . "*" . $matches[3] . "/" . $matches[2] . $matches[4];

        //error_log(var_export($solution, true));

        if(eval("return $solution;") != 24) error_log("!!!!!!!!!!!!!!!!");
    }

    error_log(var_export("solution is $solution", true));

    //Split by addition/substraction
    $terms = [];
    $countTerms = 0;
    $count = 0;
    $term = "";
    $prev = "+";

    foreach(str_split($solution . "+") as $c) {
        if($c === "(") ++$count;
        elseif($c === ")") --$count;
        elseif($count == 0 && ($c === "+" || $c === "-")) {
            $terms[$prev][ctype_digit($term)][] = $term;

            ++$countTerms;
            $term = "";
            $prev = $c;
            continue;
        }
        
        $term .= $c;
    }

    error_log(var_export($terms, true));

    if($countTerms > 1) {
        //Start with the additions

        //Sort integers
        sort($terms["+"][1]);
        
        $solution = implode("+", $terms["+"][1]);

        //Substractions

        if(count($terms["-"][1] ?? []) > 0) {
            //Sort integers
            sort($terms["-"][1]);
        
            $solution .= "-" . implode("-", $terms["-"][1]);
        }

        //error_log(var_export($addition, true));
        //error_log(var_export($substraction, true));
    }



    //3-a
    /*
    if(preg_match("/(.*?)([0-9]+(?:\*(?:[0-9]+|\([^\(\)]+\)))+)(.*)/", $solution, $matches)) {
        error_log(var_export($matches, true));

        $terms = [];
        $open = 0;

        for($i = 0; $i < count($matches[2]); ++$i) {

        }

        
    }

    //3-b
    if(preg_match("/^([0-9]+|\([^\(\)]+\))([\+\*])([0-9]+|\([^\(\)]+\))$/", $solution, $matches)) {
        //error_log(var_export($matches, true));

        if(is_int($matches[3]) || eval("return " . $matches[1] . ";") > eval("return " . $matches[3] . ";")) $solution = $matches[3] . $matches[2] . $matches[1];

        error_log("solution is now: $solution");
    }*/

    $solutionsTemp[$solution] = 1;
}

$solutions = $solutionsTemp;

error_log(var_export($solutions, true));

echo count($solutions) . PHP_EOL;

foreach($solutions as $solution => $filler) echo $solution . PHP_EOL;

error_log(microtime(1) - $start);
