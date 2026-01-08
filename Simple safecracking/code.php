<?php

const DIGITS = [
    3 => [1 => "one", 2 => "two", 6 => "six"],
    4 => [0 => "zero", 4 => "four", 5 => "five", 9 => "nine"],
    5 => [3 => "three", 7 => "seven", 8 =>"eight"],
];

[$msg, $code] = explode(':', strtolower(stream_get_line(STDIN, 256 + 1, "\n")));
$decoding = [];
$combination = "";

//The text is always the same, we have some letters to decode
foreach(str_split("the safe combination is") as $index => $letter) {
    if($letter != " ") {
        $decoding[$msg[$index]] = $letter;
    }
}

foreach(explode("-", $code) as $number) {
    $number = trim($number);
    $len = strlen($number);

    //Switch all the letters we know
    for($i = 0; $i < $len; ++$i) {
        if(isset($decoding[$number[$i]])) $number[$i] = $decoding[$number[$i]];
        else $number[$i] = '.';
    }

    //Find the proper digit
    foreach(DIGITS[$len] as $digit => $name) {
        if(preg_match("/$number/", $name)) $combination .= $digit;
    }
}

echo $combination . PHP_EOL;
