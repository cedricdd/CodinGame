<?php

const MONTHS = [
    "Jan" => "0", "Feb" => "1", "Mar" => "2", "Apr" => "3", "May" => "4", "Jun" => "5",
    "Jul" => "6", "Aug" => "7", "Sep" => "8", "Oct" => "9", "Nov" => 'A', "Dec" => "B", 
];
$sum = 0;
$answer = "";

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $number = "";

    foreach(str_split(trim(fgets(STDIN)), 3) as $string) {
        $number .= MONTHS[$string];
    }

    $sum += base_convert($number, 12, 10); //Convert the input to a number in base 10 and add it to the sum
}

//Convert the sum to base 12 and replace each digit by the month
foreach(str_split(strtoupper(base_convert($sum, 10, 12))) as $character) {
    $answer .= array_search($character, MONTHS);
}

echo $answer . PHP_EOL;
