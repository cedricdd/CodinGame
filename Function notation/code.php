<?php

function explodeMultiplication(string $function): string {
    $open = 0;
    $result = [];
    $expression = "";

    //Split the function at "."
    foreach(str_split($function . ".") as $i => $c) {
        if($c == "." && $open == 0) {
            $result[] = $expression;
            $expression = "";
        } else {
            $expression .= $c;

            if($c == "(") ++$open;
            elseif($c == ")") --$open;
        }
    }

    //If the expression is inside parentheses, make sure it's also rewritten
    foreach($result as $i => $expression) {
        if($expression[0] == "(") {
            $result[$i] = "(" . explodeAddition(substr($expression, 1, -1)) . ")";
        }
    }

    //The order is reversed
    return implode(" |> ", array_reverse($result));
}

//Split the function at "+"
function explodeAddition(string $function): string {
    $open = 0;
    $result = [];
    $expression = "";

    foreach(str_split($function . "+") as $i => $c) {
        if($c == "+" && $open == 0) {
            $result[] = explodeMultiplication($expression);
            $expression = "";
        } else {
            $expression .= $c;

            if($c == "(") ++$open;
            elseif($c == ")") --$open;
        }
    }

    return implode(" + ", $result);
}

echo explodeAddition(str_replace(" ", "", trim(fgets(STDIN)))) . PHP_EOL;
