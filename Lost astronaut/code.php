<?php

function isValid(int $number): bool {
    //A-Z
    if(($number >= 65 && $number <= 90)) return true;

    //a-z
    if(($number >= 97 && $number <= 122)) return true;

    //space
    if($number == 32) return true;

    return false;
}

fscanf(STDIN, "%d", $N);

$message = "";

foreach(preg_split("/(?<! ) | (?! )/", trim(fgets(STDIN))) as $c) {
    if(ctype_alpha($c) || $c === " ") $message .= $c;
    else {
        //It's not already a character, check binary, octal and hexadecimal
        foreach([2, 8, 16] as $base) {
            $decimal = base_convert($c, $base, 10);

            if(isValid($decimal)) {
                $message .= chr($decimal);
                continue 2;
            }
        }
    }
}

echo $message . PHP_EOL;
