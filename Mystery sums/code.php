<?php

function solve(string $expression, int $result) {
    $position = strpos($expression, '?');

    //There is no more unknown digits
    if($position === false) {
        //The equation is correct
        if(eval("return $expression;") == $result) exit($expression . "= " . $result);

        return;
    }

    //The first digit of a number is never a 0
    $start = ($position == 0 || $expression[$position - 1] == ' ') ? 1 : 0;

    for($i = $start; $i < 10; ++$i) {
        $expression[$position] = $i;

        solve($expression, $result);
    }
}

$expression = stream_get_line(STDIN, 256 + 1, "\n");

[$expression, $result] = explode('=', $expression);

$result = intval($result);

solve($expression, $result);
