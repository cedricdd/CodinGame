<?php

const CARDINAL1 = ["1" => "one", "2" => "two", "3" => "three", "4" => "four", "5" => "five", "6" => "six", "7" => "seven", "8" => "eight", "9" => "nine"];
const CARDINAL2 = ["2" => "twenty", "3" => "thirty", "4" => "forty", "5" => "fifty", "6" => "sixty", "7" => "seventy", "8" => "eighty", "9" => "ninety"];
const CARDINAL3 = ["10" => "ten", "11" => "eleven", "12" => "twelve", "13" => "thirteen", "14" => "fourteen", "15" => "fifteen", "16" => "sixteen", "17" => "seventeen", "18" => "eighteen", "19" => "nineteen"];
const CARDINAL4 = ["", "thousand", "million", "billion", "trillion", "quadrillion", "quintillion"];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $cardinal = [];

    fscanf(STDIN, "%s", $number);

    //Special case, the number is 0
    if($number == 0) {
        echo "zero" . PHP_EOL;
        continue;
    }

    //Negative number
    if($number[0] == "-") {
        $cardinal[] = "negative";
        $number = substr($number, 1);
    }

    //We want the number to have a size divisible by 0 for easier parsing
    $number = str_split(str_pad($number, ceil(strlen($number) / 3) * 3, "0", STR_PAD_LEFT), 3);

    //Check all parts of the number, 3 digits at a time
    foreach($number as $index => $part) {

        if($part == "000") continue; //Nothing to do

        if($part[0] != "0") $cardinal[] = CARDINAL1[$part[0]] . " hundred";

        if($part[1] > 1) $cardinal[] = CARDINAL2[$part[1]] . (($part[2] != "0") ? "-" . CARDINAL1[$part[2]] : "");
        elseif($part[1] == 1) $cardinal[] = CARDINAL3[substr($part, 1)];
        elseif($part[2] != "0") $cardinal[] = CARDINAL1[$part[2]];

        $cardinal[] = CARDINAL4[count($number) - $index - 1];
    }

    echo implode(" ", array_filter($cardinal)) . PHP_EOL;
}
