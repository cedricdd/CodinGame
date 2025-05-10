<?php

preg_match_all("/[+-] [0-9]+/", '+ ' . trim(fgets(STDIN)), $matches);

$operations = [];
$count = count($matches[0]);

foreach($matches[0] as $match) {
    [$operation, $value] = explode(" ", $match);

    $operations[] = $operation == '+' ? "ADD cgx " . $value : "SUB cgx " . $value;
}

$output = [];

foreach($operations as $i => $operation) {
    if(!isset($operations[$i])) continue;

    $repeat = 1;

    foreach($operations as $j => $operation2) {
        if($j > $i && $operation2 == $operation) {
            unset($operations[$j]);

            ++$repeat;
        }
    }

    if($repeat > 1) $output[] = "REPEAT " . $repeat;
    $output[] = $operation;
}

$output[] = "EXIT";

echo implode(PHP_EOL, $output) . PHP_EOL;
