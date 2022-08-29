<?php

//Look-and-say series one step ahead
function step($string) {
    $step = "";

    foreach(preg_split('/(.)(?!\1|$)\K/', $string) as $group) {
        $step .= strlen($group) . $group[0];
    }

    return $step;
}

//Look-and-say series one step behind
function reverseStep($string) {
    $reverse = "";

    foreach(str_split($string, 2) as $group) {
        $reverse .= str_repeat($group[1], $group[0]);
    }

    return $reverse;
}

$string = stream_get_line(STDIN, 256 + 1, "\n");

while(true) {
    if(strlen($string) % 2 != 0) break; //We can't continue with an odd number of digits

    $reverse = reverseStep($string);
    
    //If not reversible or if we are in a loop we stop
    if(step($reverse) != $string || $reverse == $string) break;

    $string = $reverse;
};

echo $string . PHP_EOL;
?>
