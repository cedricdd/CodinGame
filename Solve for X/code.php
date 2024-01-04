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

//Split by multiplication/division
function splitMulDiv(string $equation): array {
    $count = 0;
    $term = "";
    $op = "*";
    $terms = ["*" => [], "/" => []];

    //The equation stars with the division sign
    if($equation[0] == "/") {
        $op = "/";
        $equation = substr($equation, 1);
    }

    foreach(str_split($equation . "*") as $c) {
        if($c === "(") ++$count;
        elseif($c === ")") --$count;
        elseif($count == 0 && ($c === "*" || $c === "/")) {
            $terms[$op][] = $term;
            $term = "";
            $op = $c;
            continue;
        } 

        $term .= $c;
    }

    return $terms;
}

//Split by addition/substraction
function splitAddSub(string $equation): array {
    $count = 0;
    $term = "";
    $op = "+";
    $terms = ["+" => [], "-" => []];

    //The equation stars with the negative sign
    if($equation[0] == "-") {
        $op = "-";
        $equation = substr($equation, 1);
    }

    foreach(str_split($equation . "+") as $c) {
        if($c === "(") ++$count;
        elseif($c === ")") --$count;
        elseif($count == 0 && ($c === "+" || $c === "-")) {
            $terms[$op][] = $term;
            $term = "";
            $op = $c;
            continue;
        } 

        $term .= $c;
    }

    return $terms;
}

function solve(string $termX, string $equation): string {

    error_log("Calling solve with $termX -- $equation");

    $terms = splitAddSub($termX);

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

    //We are done
    if($termX == "x") return $equation;

    $count = 0;
    $term = "";
    $op = "*";
    $start = 0;

    foreach(str_split($termX . "*") as $i => $c) {
        if($c === "(") ++$count;
        elseif($c === ")") --$count;
        elseif($count == 0 && ($c === "*" || $c === "/")) {
            if(strpos($term, "x") !== false) {
                //error_log("$term -- $start");
                
                if($start > 0) {
                    $s = substr($termX, 0, $start - 1);

                    error_log("before: $op -- $s");
                    if($op == "*") $equation = (ctype_digit($equation) ? $equation : "(" . $equation . ")") . "/" . (ctype_digit($s) ? $s : "(" . $s . ")");
                    else $equation = (ctype_digit($s) ? $s : "(" . $s . ")") . "/" . (ctype_digit($equation) ? $equation : "(" . $equation . ")");

                }
                if($i < strlen($termX)) {
                    $s = substr($termX, $i + 1);

                    error_log("after: $c -- " . $s);
                    if($c == "*") $equation = (ctype_digit($equation) ? $equation : "(" . $equation . ")") . "/" . (ctype_digit($s) ? $s : "(" . $s . ")");
                    else $equation = (ctype_digit($equation) ? $equation : "(" . $equation . ")") . "*" . (ctype_digit($s) ? $s : "(" . $s . ")");
                }

                $termX = $term;
                break;
            }

            $term = "";
            $op = $c;
            $start = $i + 1;
            continue;
        } 

        $term .= $c;
    }

    //We are done
    if($termX == "x") return $equation;
    //X is inside parentheses
    else return solve(substr($termX, 1, -1), $equation);
}

function removeParentheses(string $equation): string {
    error_log("Calling parentheses with -- $equation");

    //There's nothing to do, no parentheses
    if(strpos($equation, "(") === false) return $equation;

    $count = 0;
    $term = "";
    $op = "+";
    $start = 0;

    foreach(str_split($equation . "+") as $i => $c) {
        if($c === "(") ++$count;
        elseif($c === ")") --$count;
        elseif($count == 0 && ($c === "+" || $c === "-" || $c === "*" || $c === "/")) {
            error_log("working on $term -- $op -- $start -- $i");

            //The term is inside parantheses
            if($term[0] == "(") {
                
                //First we make a recursive call on the part inside the parentheses
                $term = removeParentheses(substr($term, 1, -1));

                /*
                //It's just an integer, parantheses are not needed
                if(ctype_digit($term)) {
                    error_log("($term) => $term");
                    $equation = str_replace("(" . $term . ")", $term, $equation);
                }
                */

                $termsAddSub = splitAddSub($term);
                $termsMulDiv = splitMulDiv($term);

                //error_log(var_export($termsAddSub, true));

                //There are no addition or substraction
                if(count($termsAddSub["+"]) == 1 && $termsAddSub["+"][0] == $term) {
                    if($op == "/") {
                        //error_log(var_export($termsMulDiv, true));

                        if($start > 0) $updatedEquation = substr($equation, 0, $start - 1);
                        if(count($termsMulDiv["/"]) > 0) $updatedEquation .= "*" . implode("*", $termsMulDiv["/"]);
                        if(count($termsMulDiv["*"]) > 0) $updatedEquation .= "/" . implode("/", $termsMulDiv["*"]);
                        $updatedEquation .= substr($equation, $i);

                        error_log($updatedEquation);
                        //exit();
                    } else {
                        error_log("($term) => $term");
                        $updatedEquation = substr($equation, 0, $start) . $term . substr($equation, $i);
                    }

                    return removeParentheses($updatedEquation);
                }

                //There are no mulitplication or division
                if(count($termsMulDiv["*"]) == 1 && $termsMulDiv["*"][0] == $term) {
                    if($op == "-") {
                        //error_log(var_export($termsMulDiv, true));

                        if($start > 0) $updatedEquation = substr($equation, 0, $start - 1);
                        if(count($termsAddSub["-"]) > 0) $updatedEquation .= "+" . implode("+", $termsAddSub["-"]);
                        if(count($termsAddSub["+"]) > 0) $updatedEquation .= "-" . implode("-", $termsAddSub["+"]);
                        $updatedEquation .= substr($equation, $i);

                        error_log($updatedEquation);
                        //exit();
                    } else {
                        error_log("($term) => $term");
                        $updatedEquation = substr($equation, 0, $start) . $term . substr($equation, $i);
                    }

                    return removeParentheses($updatedEquation);
                }
            }

            $start = $i + 1;
            $term = "";
            $op = $c;
            continue;
        } 

        $term .= $c;
    }

    return $equation;
}

$start = microtime(1);

fscanf(STDIN, "%d", $numEquations);
for ($i = 0; $i < $numEquations; $i++) {
    $equation = trim(fgets(STDIN));

    error_log("Equation: $equation");

    [$left, $right] = explode("=", $equation);

    if(strpos($right, "x") !== false) {
        $equation = $left;
        $termX = $right;
    }
    else {
        $equation = $right;
        $termX = $left;
    }

    $equation = solve($termX, $equation);
    $equation = removeParentheses($equation);

    echo "x=" . sortAddSub($equation) . PHP_EOL;
}


error_log(microtime(1) - $start);
