<?php

fscanf(STDIN, "%d", $N);
foreach(explode(" ", trim(fgets(STDIN))) as $input) $inputs[] = [$input, []];

while(count($inputs) > 1) {
    $index = 0;

    //Find the first operation
    while(!in_array($inputs[$index][0], ["+", "-", "/", "*"])) ++$index;

    [$left, $right, $operator] = array_slice($inputs, $index - 2, 3);

    $pRight = false;
    $pLeft  = false;

    //Check if left or right requieres parantheses
    if($operator[0] != "+" && (isset($right[1]["+"]) || isset($right[1]["-"]))) $pRight = true;
    if($operator[0] == "/" && (isset($right[1]["/"]) || isset($right[1]["*"]))) $pRight = true;
    if(($operator[0] == "*" || $operator[0] == "/") && (isset($left[1]["+"]) || isset($left[1]["-"]))) $pLeft = true;

    $expression = ($pLeft ? "(" : "") . $left[0] . ($pLeft ? ")" : "") . " " . $operator[0] . " " . ($pRight ? "(" : "") . $right[0] . ($pRight ? ")" : "");

    //The operators that are used in the expression
    $operators = ($pLeft ? [] : $left[1]) + ($pRight ? [] : $right[1]) + [$operator[0] => 1];

    array_splice($inputs, $index - 2, 3, [[$expression, $operators]]);
}

echo $inputs[0][0] . PHP_EOL;
