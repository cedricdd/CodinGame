<?php

$b = explode('0', trim(fgets(STDIN)));

//We sort existing sequences of 1 from longest to shortest
$sorted = $b;
uasort($sorted, function($a, $b) {
    return strlen($b) <=> strlen($a);
});

$longest = 1;

foreach($sorted as $key => $string) {
    if(strlen($string) < ceil($longest / 2))  break; //We can't create a longest sequence anymore 

    //We check if we change the bit before the current sequence
    if(isset($b[$key - 1]) && ($length = strlen($b[$key - 1]) + strlen($string) + 1) > $longest) $longest = $length;
    //We check if we change the bit after the current sequence
    if(isset($b[$key + 1]) && ($length = strlen($b[$key + 1]) + strlen($string) + 1) > $longest) $longest = $length;
}

echo $longest . PHP_EOL;
