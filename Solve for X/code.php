<?php

//Split by addition/substraction
function sortAddSub(string $equation): string {

    $terms = splitAddSub($equation);
    $solution = "";

    //error_log($equation);
    //error_log(var_export($terms, true));

    foreach($terms as $operation => $list) {
        if(count($list) == 0) continue;

        $integers = [];
        $expressions = [];
    
        foreach($list as $term) {
            if(ctype_digit($term)) $integers[] = $term; //It's an integer
            else $expressions[] = sortMulDiv($term); //It's an expression, extra sorting
        }
    
        //Sort integers
        sort($integers);
        //Sort expressions
        usort($expressions, function($a, $b) {
            $valueA = @eval("return $a;");
            $valueB = @eval("return $b;"); 
    
            if($valueA == $valueB) return $a <=> $b;
            else return $valueA <=> $valueB;
        });

        //error_log(var_export($integers, true));
        //error_log(var_export($expressions, true));
        
        //Addition comes before substraction, integers before expressions
        $solution .= $operation . implode($operation, array_merge($integers, $expressions));
    }

    return ltrim($solution, "+");
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

//Split by addition/substraction
function splitAddSub(string $equation): array {
    $count = 0;
    $term = "";
    $prev = "+";
    $terms = ["+" => [], "-" => []];

    //The equation stars with the negative sign
    if($equation[0] == "-") {
        $prev = "-";
        $equation = substr($equation, 1);
    }

    foreach(str_split($equation . "+") as $c) {
        if($c === "(") ++$count;
        elseif($c === ")") --$count;
        elseif($count == 0 && ($c === "+" || $c === "-")) {
            $terms[$prev][] = $term;
            $term = "";
            $prev = $c;
            continue;
        } 

        $term .= $c;
    }

    return $terms;
}

function solve(string $equation): string {
    [$left, $right] = explode("=", $equation);

    if(strpos($right, "x") !== false) {
        $equation = $left;
        $toSolve = $right;
    }
    else {
        $equation = $right;
        $toSolve = $left;
    }

    $terms = splitAddSub($toSolve);

    //Find the term with "x"
    $termX = null;
    $xIsNegative = false;

    foreach($terms["+"] as $i => $term) {
        if(strpos($term, "x") !== false) {
            $termX = $term;
            unset($terms["+"][$i]);
            break;
        }
    }

    foreach($terms["-"] as $i => $term) {
        if(strpos($term, "x") !== false) {
            $termX = $term;
            unset($terms["-"][$i]);
            $xIsNegative = true;
            break;
        }
    }

    foreach($terms["+"] as $term) $equation .= "-" . $term; //Additions become Substractions
    foreach($terms["-"] as $term) $equation .= "+" . $term; //Substractions become Additions

    //X is negative, we need to switch additions/substractions in $equation
    if($xIsNegative) {
        $terms = splitAddSub($equation);

        $equation = implode("+", $terms["-"]);
        if(count($terms["+"]) > 0) $equation .= "-" .  implode("-", $terms["+"]);
    }

    return $equation;
}

$start = microtime(1);

fscanf(STDIN, "%d", $numEquations);
for ($i = 0; $i < $numEquations; $i++) {
    $equation = trim(fgets(STDIN));

    $equation = solve($equation);

    echo "x=" . sortAddSub($equation) . PHP_EOL;
}

error_log(microtime(1) - $start);
