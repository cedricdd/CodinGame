<?php

$level = 0;
$weights = array_combine(range("a", "z"), array_fill(0, 26, 0));

foreach(preg_split("/(-?[a-z])/", trim(fgets(STDIN)), -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE) as $input) {
    if(ctype_alpha($input)) $weights[$input] += 1 / ++$level; //Opening a new tag
    else --$level; //Closing a tag
}

arsort($weights);

echo key($weights) . PHP_EOL;
