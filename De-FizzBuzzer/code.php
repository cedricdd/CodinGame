<?php

//We just generate FizzBuzz for every numbers from 1 to 1000
for($number = 1000; $number > 0; --$number) {
    $converted = [];

    $chars = count_chars(strval($number), 0);

    for($c = $chars[51]; $c > 0; --$c) $converted[] = "Fizz";

    $i = $number;
    while ($i % 3 == 0) {
        $converted[] = "Fizz";
        $i /= 3;
    }

    for($c = $chars[53]; $c > 0; --$c) $converted[] = "Buzz";

    $i = $number;
    while ($i % 5 == 0) {
        $converted[] = "Buzz";
        $i /= 5;
    }

    if(count($converted) == 0) $dictionary[$number] = $number;
    else $dictionary[implode("", $converted)] = $number;
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $string = trim(fgets(STDIN));

    echo (isset($dictionary[$string]) ? $dictionary[$string] : 'ERROR') . PHP_EOL;
}
