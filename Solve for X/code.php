<?php

//Find the term that contains X and extract it
function findXTerm(array &$terms): array {
    foreach($terms as $operation => $list) {
        foreach($list as $i => $term) {
            if(strpos($term, "x") !== false) {
                unset($terms[$operation][$i]);
               
                return [$term, $operation];
            }
        }
    }
}

//Remove unnecessary parentheses
function removeParentheses(string $expression): array {
    //There's nothing to do, no parentheses
    if(strpos($expression, "(") === false) return [$expression, 0];

    $count = 0;
    $term = "";
    $operation = ".";
    $start = 0;
    $removed = 0;

    foreach(str_split($expression . ".") as $index => $character) {
        if($character === "(") ++$count;
        elseif($character === ")") --$count;
        elseif($count == 0 && in_array($character, ["+", "-", "*", "/", "."])) {

            //The term is a sub-expression, check if we can remove the parantheses
            if($term[0] == "(") {

                $term = substr($term, 1, -1);

                //First we make a recursive call to remove possible unnecessary parentheses inside the sub-expression
                [$termCleaned, $removedSubExp] = removeParentheses($term);

                $termsAddSub = splitAddSub($termCleaned);
                $termsMulDiv = splitMulDiv($termCleaned);

                //There are only multiplcations & divisions, parantheses can be removed
                if(count($termsAddSub["+"]) == 1 && $termsAddSub["+"][0] == $termCleaned) {
                    //We need to switch multiplication & division to remove the parantheses
                    if($operation == "/") {
                        $updatedExpression = "";

                        if($start > 0) $updatedExpression = substr($expression, 0, $start - $removed - 1);
                        if(count($termsMulDiv["/"]) > 0) $updatedExpression .= "*" . implode("*", $termsMulDiv["/"]);
                        if(count($termsMulDiv["*"]) > 0) $updatedExpression .= "/" . implode("/", $termsMulDiv["*"]);
                        $updatedExpression .= substr($expression, $index - $removed);
                    } //We can directly remove the parantheses
                    else {
                        $updatedExpression = substr($expression, 0, $start - $removed) . $termCleaned . substr($expression, $index - $removed);
                    }

                    $removed += 2 + $removedSubExp;
                    $expression = $updatedExpression;
                }

                //The operation before & after are addition, substraction or nothing, parantheses can be removed
                elseif(in_array($operation, [".", "+", "-"]) && in_array($character, [".", "+", "-"])) {
                     //We need to switch addition & subsraction to remove the parantheses
                    if($operation == "-") {
                        $updatedExpression = "";

                        if($start > 0) $updatedExpression = substr($expression, 0, $start - $removed - 1);
                        if(count($termsAddSub["-"]) > 0) $updatedExpression .= "+" . implode("+", $termsAddSub["-"]);
                        if(count($termsAddSub["+"]) > 0) $updatedExpression .= "-" . implode("-", $termsAddSub["+"]);
                        $updatedExpression .= substr($expression, $index - $removed);
                    } //We can directly remove the parantheses
                    else {
                        $updatedExpression = substr($expression, 0, $start - $removed) . $termCleaned . substr($expression, $index - $removed);
                    }

                    $removed += 2 + $removedSubExp;
                    $expression = $updatedExpression;
                }

                //The parentheses can't be removed but some have been removed inside the sub-expression
                elseif($term != $termCleaned) {
                    $expression = substr($expression, 0, $start - $removed) . "(" . $termCleaned . ")" . substr($expression, $index - $removed);
                    $removed += $removedSubExp;
                }
            }

            $start = $index + 1;
            $term = "";
            $operation = $character;
            continue;
        } 

        $term .= $character;
    }

    return [$expression, $removed];
}

function solveEquation(string $expressionX, string $expression): string {
    //We first work on additions & substractions
    $terms = splitAddSub($expressionX);

    //Find the term with "x"
    [$termX, $operationX] = findXTerm($terms);

    foreach($terms["+"] as $term) $expression .= "-" . $term; //Additions become Substractions
    foreach($terms["-"] as $term) $expression .= "+" . $term; //Substractions become Additions

    //We need to switch additions/substractions in $expression
    if($operationX == "-") {
        $terms = splitAddSub($expression);

        $expression = implode("+", $terms["-"]) . ((count($terms["+"]) > 0) ?  "-" .  implode("-", $terms["+"]) : "");
    }

    if($termX == "x") return $expression; //We are done, x is alone

    if(ctype_digit($expression) == false) $expression = "(" . $expression . ")"; //We are going to add multiplications/divisions, add parantheses if needed

    $terms = splitMulDiv($termX);

    //Find the term with "x"
    [$termX, $operationX] = findXTerm($terms);

    foreach($terms["/"] as $term) $expression .= "*" . $term; //Divisions become Multiplications
    foreach($terms["*"] as $term) $expression .= "/" . $term; //Multiplications become Divisions

    //We need to switch divisions/multiplications in $expression
    if($operationX == "/") {
        $terms = splitMulDiv($expression);

        $expression = implode("*", $terms["/"]) . ((count($terms["*"]) > 0) ? "/" .  implode("/", $terms["*"]) : "");
    }

    if($termX == "x") return $expression; //We are done, x is alone
    else return solveEquation(substr($termX, 1, -1), $expression); //X is inside a sub-expression, now solve that
}

//Sort the expression
function sortExpression(string $expression, string $sort): string {

    if($sort == "AddSub") $terms = splitAddSub($expression);
    else $terms = splitMulDiv($expression);

    $solution = "";

    foreach($terms as $operation => $list) {
        if(count($list) == 0) continue;

        $integers = [];
        $expressions = [];
    
        foreach($list as $term) {
            if(ctype_digit($term)) $integers[] = $term; //It's an integer
            //We need to sort the sub-expression
            elseif($sort == "MulDiv" && $term[0] == "(") $expressions[] = "(" . sortExpression(substr($term, 1, -1), "AddSub") . ")";
            //It's an expression
            else {
                if($sort == "AddSub") $expressions[] = sortExpression($term, "MulDiv"); 
                else $expressions[] = $term;
            }
        }
    
        //Sort integers
        sort($integers);
        //Sort expressions
        usort($expressions, function($a, $b) {
            $valueA = eval("return $a;");
            $valueB = eval("return $b;"); 
    
            if($valueA == $valueB) return $a <=> $b;
            else return $valueA <=> $valueB;
        });

        $solution .= $operation . implode($operation, array_merge($integers, $expressions));
    }

    return ltrim($solution, "+*");
}

//Split by addition/substraction
function splitAddSub(string $expression): array {
    $count = 0;
    $term = "";
    $operatrion = "+";
    $terms = ["+" => [], "-" => []]; //When we sort, additions come before substractions

    //The expression starts with the negative sign
    if($expression[0] == "-") {
        $operatrion = "-";
        $expression = substr($expression, 1);
    }

    foreach(str_split($expression . "+") as $character) {
        if($character === "(") ++$count;
        elseif($character === ")") --$count;
        elseif($count == 0 && ($character === "+" || $character === "-")) {
            $terms[$operatrion][] = $term;
            $term = "";
            $operatrion = $character;
            continue;
        } 

        $term .= $character;
    }

    return $terms;
}

//Split by multiplication/division
function splitMulDiv(string $expression): array {
    $count = 0;
    $term = "";
    $operatrion = "*";
    $terms = ["*" => [], "/" => []]; //When we sort, mulitiplications come before divisions

    //The expression starts with the division sign
    if($expression[0] == "/") {
        $operatrion = "/";
        $expression = substr($expression, 1);
    }

    foreach(str_split($expression . "*") as $character) {
        if($character === "(") ++$count;
        elseif($character === ")") --$count;
        elseif($count == 0 && ($character === "*" || $character === "/")) {
            $terms[$operatrion][] = $term;
            $term = "";
            $operatrion = $character;
            continue;
        } 

        $term .= $character;
    }

    return $terms;
}

$start = microtime(1);

fscanf(STDIN, "%d", $numEquations);
for ($i = 0; $i < $numEquations; $i++) {
    $equation = trim(fgets(STDIN));

    [$left, $right] = explode("=", $equation);

    if(strpos($right, "x") !== false) {
        $expression = $left;
        $expressionX = $right;
    }
    else {
        $expression = $right;
        $expressionX = $left;
    }

    $expression = solveEquation($expressionX, $expression);
    [$expression, ] = removeParentheses($expression);

    echo "x=" . sortExpression($expression, "AddSub") . PHP_EOL;
}

error_log(microtime(1) - $start);
