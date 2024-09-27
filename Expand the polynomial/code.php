<?php

fscanf(STDIN, "%s", $poly);

//Rewritte square, cubic, ... | (x-2)^2 => (x-2)(x-2)
if(preg_match("/^(\(.*\))\^([0-9])+$/", $poly, $match)) {
    $poly = str_repeat($match[1], $match[2]);
}

$poly = str_replace(")*(", ")(", $poly); //Remove the multiplication between parentheses

preg_match_all("/\((.*?)\)/", $poly, $matches);

$expressions = [];

foreach($matches[1] as $match) {
    $expression = [];

    $factors = preg_split("/([+-])/", $match, -1, PREG_SPLIT_DELIM_CAPTURE);
    $count = count($factors);
    $sign = 1;

    for($i = 0; $i < $count; ++$i) {
        if($i & 1) $sign = $factors[$i] == "+" ? 1 : -1; //The sign of the next factor
        else {
            if(ctype_digit($factors[$i])) $expression[0] = $factors[$i] * $sign; //It's just an integer
            else {
                preg_match("/^([0-9]+)?x(?:\^([0-9]+))?$/", $factors[$i], $powers);

                $exponent = !empty($powers[2] ?? '') ? $powers[2] : 1;
                $value = !empty($powers[1] ?? '') ? $powers[1] : 1;

                $expression[$exponent] = $value * $sign;
            }
        }
    }

    $expressions[] = $expression;
}

//While we have more than one 2 sub-expression, we multiply the first two
while(count($expressions) > 1) {
    $index = array_key_first($expressions);
    $expression = [];

    foreach($expressions[$index] as $exponent1 => $value1) {
        foreach($expressions[$index + 1] as $exponent2 => $value2) {
            $expression[$exponent1 + $exponent2] = ($expression[$exponent1 + $exponent2] ?? 0) + ($value1 * $value2);
        }
    }

    //Remove the two sub-expressions we worked on
    unset($expressions[$index]);
    unset($expressions[$index + 1]);
    //Add the result off the multiplication
    $expressions[] = $expression;
}

$result = array_pop($expressions);
$output = "";

krsort($result);

foreach($result as $exponent => $value) {
    if($value == 0) continue;

    if($value >= 0) $output .= '+';
    elseif($value == -1 && $exponent > 0) $output .= '-';

    if(abs($value) > 1 || $exponent == 0) $output .= $value;

    if($exponent > 1) $output .= "x^" . $exponent;
    elseif($exponent == 1) $output .= 'x';
}

echo ltrim($output, '+') . PHP_EOL;
