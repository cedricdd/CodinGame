<?php

const OPERATIONS = ["+", "-", "/", "*"];
const INV1 = ["+" => "-", "-" => "+", "*" => "*", "/" => "/"];
const INV2 = ["+" => "+", "-" => "-", "*" => "/", "/" => "*"];

//Split by addition/substraction
function sortAddSub(string $solution): string {

    $terms = ["+" => ["int" => [], "exp" => []], "-" => ["int" => [], "exp" => []]];
    $count = 0;
    $term = "";
    $prev = "+";

    foreach(str_split($solution . "+") as $c) {
        if($c === "(") ++$count;
        elseif($c === ")") --$count;
        elseif($count == 0 && ($c === "+" || $c === "-")) {
            if(ctype_digit($term)) $terms[$prev]["int"][] = $term; //It's an integer
            else $terms[$prev]["exp"][] = sortMulDiv($term); //It's an expression, extra sorting

            $term = "";
            $prev = $c;
            continue;
        }
        
        $term .= $c;
    }

    //Sort addition integers
    sort($terms["+"]["int"]);
    //Sort addition expressions
    usort($terms["+"]["exp"], function($a, $b) {
        $valueA = @eval("return $a;");
        $valueB = @eval("return $b;"); 

        if($valueA == $valueB) return $a <=> $b;
        else return $valueA <=> $valueB;
    });
    
    //Addition comes before substraction, integers before expressions
    $solution = implode("+", array_merge($terms["+"]["int"], $terms["+"]["exp"]));

    //We also have some substraction
    if(count($terms["-"]["int"]) + count($terms["-"]["exp"]) > 0) {
        //Sort Substraction integers
        sort($terms["-"]["int"]);
        //Sort Substraction expressions
        usort($terms["-"]["exp"], function($a, $b) {
            return eval("return $a;") <=> eval("return $b;");
        });

        //Integers before expressions
        $solution .= "-" . implode("-", array_merge($terms["-"]["int"], $terms["-"]["exp"]));
    }

    return $solution;
}

//Split by multiplicate/division
function sortMulDiv(string $solution): string {

    $terms = ["*" => ["int" => [], "exp" => []], "/" => ["int" => [], "exp" => []]];
    $count = 0;
    $term = "";
    $prev = "*";

    foreach(str_split($solution . "*") as $c) {
        if($c === "(") ++$count;
        elseif($c === ")") --$count;
        elseif($count == 0 && ($c === "*" || $c === "/")) {
            if(ctype_digit($term)) $terms[$prev]["int"][] = $term; //It's an integer
            elseif($term[0] === "(") $terms[$prev]["exp"][] = "(" . sortAddSub(substr($term, 1, -1)) . ")"; //We need to sort the expression inside the parantheses
            else $terms[$prev]["exp"][] = $term; //It's an expression

            $term = "";
            $prev = $c;
            continue;
        }
        
        $term .= $c;
    }

    //Sort multiplication integers
    sort($terms["*"]["int"]);
    //Sort multiplication expressions
    usort($terms["*"]["exp"], function($a, $b) {
        $valueA = @eval("return $a;");
        $valueB = @eval("return $b;"); 

        if($valueA == $valueB) return $a <=> $b;
        else return $valueA <=> $valueB;
    });
    
    //Multiplication comes before division, integers before expressions
    $solution = implode("*", array_merge($terms["*"]["int"], $terms["*"]["exp"]));

    //We also have some division
    if(count($terms["/"]["int"]) + count($terms["/"]["exp"]) > 0) {
        //Sort division integers
        sort($terms["/"]["int"]);
        //Sort division expressions
        usort($terms["/"]["exp"], function($a, $b) {
            return eval("return $a;") <=> eval("return $b;");
        });

        //Integers before expressions
        $solution .= "/" . implode("/", array_merge($terms["/"]["int"], $terms["/"]["exp"]));
    }

    return $solution;
}

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

foreach($solutions as $solution) {

    $solution = preg_replace("/\s/", "", $solution); //Remove the spaces

    //(($n1 $op1 $n2) $op2 $n3) $op3 $n4
    if(preg_match("/\(\(([0-9]+)(.)([0-9]+)\)(.)([0-9]+)\)(.)([0-9]+)/", $solution, $matches)) {
        $removeInner  = ($matches[4] == "+" || $matches[4] == "-" || $matches[2] == "*" || $matches[2] == "/");
        $removeOutter = ($matches[6] == "+" || $matches[6] == "-" || $matches[4] == "*" || $matches[4] == "/");

        //Solution without unnecessary parentheses
        $solution = ($removeOutter ? "" : "(") . ($removeInner ? "" : "(") . $matches[1] . $matches[2] . $matches[3] . ($removeInner ? "" : ")") . $matches[4] . $matches[5] . ($removeOutter ? "" : ")") . $matches[6] . $matches[7];
    }

    //($n1 $op1 $n2) $op2 ($n3 $op3 $n4)
    if(preg_match("/\(([0-9]+)(.)([0-9]+)\)(.)\(([0-9]+)(.)([0-9]+)\)/", $solution, $matches)) {
        $removeLeft  = ($matches[4] == "+" || $matches[4] == "-" || $matches[2] == "*" || $matches[2] == "/");
        $removeRight = ($matches[4] == "+" || $matches[4] == "-" || $matches[6] == "*" || $matches[6] == "/");

        if($removeRight) { //We need to change some operators
            if($matches[4] == "-") $matches[6] = INV1[$matches[6]];
            if($matches[4] == "/") $matches[6] = INV2[$matches[6]];
        }

        //Solution without unnecessary parentheses
        $solution = ($removeLeft ? "" : "(") . $matches[1] . $matches[2] . $matches[3] . ($removeLeft ? "" : ")") . $matches[4] . ($removeRight ? "" : "(") .$matches[5] . $matches[6] . $matches[7] . ($removeRight ? "" : ")");
    }

    //$n1 $op1 (($n2 $op2 $n3) $op3 $n4)
    if(preg_match("/([0-9]+)(.)\(\(([0-9]+)(.)([0-9]+)\)(.)([0-9]+)\)/", $solution, $matches)) {
        $removeInner  = ($matches[6] == "+" || $matches[6] == "-" || $matches[4] == "*" || $matches[4] == "/");
        $removeOutter = ($matches[2] == "+" || $matches[2] == "-" || $matches[6] == "*" || $matches[6] == "/");

        if($removeOutter) { //We need to change some operators
            if($matches[2] == "-") {
                if($removeInner) $matches[4] = INV1[$matches[4]];
                $matches[6] = INV1[$matches[6]];
            }
            if($matches[2] == "/") {
                if($removeInner) $matches[4] = INV2[$matches[4]];
                $matches[6] = INV2[$matches[6]];
            }
        }

        //Solution without unnecessary parentheses
        $solution = $matches[1] . $matches[2] . ($removeOutter ? "" : "(") . ($removeInner ? "" : "(") . $matches[3] . $matches[4] . $matches[5] . ($removeInner ? "" : ")") . $matches[6] . $matches[7] . ($removeOutter ? "" : ")");
    }

    //$n1 $op1 ($n2 $op2 ($n3 $op3 $n4))
    if(preg_match("/([0-9]+)(.)\(([0-9]+)(.)\(([0-9]+)(.)([0-9]+)\)\)/", $solution, $matches)) {
        $removeInner  = ($matches[4] == "+" || $matches[4] == "-" || $matches[6] == "*" || $matches[6] == "/");
        $removeOutter = ($matches[2] == "+" || $matches[2] == "-" || $matches[4] == "*" || $matches[4] == "/");

        if($removeInner) { //We need to change some operators
            if($matches[4] == "-") $matches[6] = INV1[$matches[6]];
            if($matches[4] == "/") $matches[6] = INV2[$matches[6]];
        }

        if($removeOutter) { //We need to change some operators
            if($matches[2] == "-") {
                $matches[4] = INV1[$matches[4]];
                if($removeInner) $matches[6] = INV1[$matches[6]];
            }
            if($matches[2] == "/") {
                $matches[4] = INV2[$matches[4]];
                if($removeInner) $matches[6] = INV2[$matches[6]];
            }
        }

        //Solution without unnecessary parentheses
        $solution = $matches[1] . $matches[2] . ($removeOutter ? "" : "(") . $matches[3] . $matches[4] . ($removeInner ? "" : "(") . $matches[5] . $matches[6] . $matches[7] . ($removeInner ? "" : ")") . ($removeOutter ? "" : ")");
    }

    //($n1 $op1 ($n2 $op2 $n3)) $op3 $n4
    if(preg_match("/\(([0-9]+)(.)\(([0-9]+)(.)([0-9]+)\)\)(.)([0-9]+)/", $solution, $matches)) {
        $removeInner  = ($matches[2] == "+" || $matches[2] == "-" || $matches[4] == "*" || $matches[4] == "/");
        $removeOutter = ($matches[6] == "+" || $matches[6] == "-" || $matches[2] == "*" || $matches[2] == "/");

        if($removeInner) { //We need to change some operators
            if($matches[2] == "-") $matches[4] = INV1[$matches[4]];
            if($matches[2] == "/") $matches[4] = INV2[$matches[4]];
        }

        //Solution without unnecessary parentheses
        $solution = ($removeOutter ? "" : "(") . $matches[1] . $matches[2] . ($removeInner ? "" : "(") . $matches[3] . $matches[4] . $matches[5] . ($removeInner ? "" : ")") . ($removeOutter ? "" : ")") . $matches[6] . $matches[7];
    }

    $solution = sortAddSub($solution);

    $solutionsUpdated[$solution] = 1;
}

//Sort the solutions
uksort($solutionsUpdated, function($a, $b) {
    $countA = substr_count($a, "(");
    $countB = substr_count($b, "(");

    if($countA == $countB) return $a <=> $b;
    else return $countA <=> $countB;
});

echo count($solutionsUpdated) . PHP_EOL;

foreach($solutionsUpdated as $solution => $filler) echo $solution . PHP_EOL;

error_log(microtime(1) - $start);
