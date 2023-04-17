<?php

$message = fgets(STDIN);
$frequency = array_combine(range("a", "z"), array_fill(0, 26, 0));

foreach(str_split(strtolower($message)) as $c) {
    if(ctype_alpha($c)) $frequency[$c]++;
}

arsort($frequency);

//Simple Caesar cipher, we just consider the most frequent letter to be "e" and get the shift
$shift = ord("e") - ord(array_key_first($frequency));

foreach(str_split($message) as $c) {
    if(ctype_alpha($c)) {
        //Apply the shift and keep the case
        echo chr(((ord(strtolower($c)) - 97 + $shift + 26) % 26) + (ord($c) >= 97 ? 97 : 65));
    }

    else echo $c;
}

echo PHP_EOL;
