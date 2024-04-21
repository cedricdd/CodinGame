<?php

function getValue(string $string): int {
    $value = "";

    for($i = 0; $i < strlen($string); ++$i) {
        $value .= ord($string[$i]) - 96;
    }

    return intval($value);
}

$firstArray = explode(" ", trim(fgets(STDIN)));
$secondArray = explode(" ", trim(fgets(STDIN)));
$output = [];

foreach($firstArray as $i => $string) {
    $v1 = getValue($firstArray[$i]);
    $v2 = getValue($secondArray[$i]);
    $diff = abs($v1 - $v2);

    //Difference is odd
    if($diff & 1) {
        $letters = str_split($string);
        sort($letters);
        $output[] = implode("", $letters);
    } //Difference is even
    else {
        $sorted = "";
        $letters1 = array_flip(array_unique(str_split($firstArray[$i])));
        $letters2 = array_flip(array_unique(str_split($secondArray[$i])));
        $counts = count_chars($firstArray[$i], 1);

        //Sort letters present in the second array
        foreach(array_unique(str_split($secondArray[$i])) as $c) {
            error_log("checking $c");
            if(isset($letters1[$c])) $sorted .= str_repeat($c, $counts[ord($c)]);
        }

        //Sort letters not present in the second array
        foreach(array_unique(str_split($firstArray[$i])) as $c) {
            if(!isset($letters2[$c])) $sorted .= str_repeat($c, $counts[ord($c)]);
        }

        $output[] = $sorted;
    }
}

echo implode(" ", $output) . PHP_EOL;
