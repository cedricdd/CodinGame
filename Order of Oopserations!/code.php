<?php

function parse(string $S): string {
    //Addition
    if(preg_match("/((?<!\d)-?\d+)\+(-?\d+)/", $S, $match)) {
        return parse(str_replace($match[0], strval(intval($match[1]) + intval($match[2])), $S));
    }
    //Division
    if(preg_match("/((?<!\d)-?\d+)\/(-?\d+)/", $S, $match)) {
        return parse(str_replace($match[0], strval(intval($match[1]) / intval($match[2])), $S));
    }
    //Subtraction
    if(preg_match("/((?<!\d)-?\d+)\-(-?\d+)/", $S, $match)) {
        return parse(str_replace($match[0], strval(intval($match[1]) - intval($match[2])), $S));
    }
    //Multiplication
    if(preg_match("/((?<!\d)-?\d+)\*(-?\d+)/", $S, $match)) {
        return parse(str_replace($match[0], strval(intval($match[1]) * intval($match[2])), $S));
    }
    //No operation left
    return $S;
}

echo parse(trim(fgets(STDIN))) . PHP_EOL;
