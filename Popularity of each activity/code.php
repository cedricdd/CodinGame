<?php

$attendees = array_fill(0, 9, 0);
$index = 0;

fscanf(STDIN, "%d", $height);

for ($y = 0; $y < $height; ++$y) {

    $index2 = $index;

    foreach(str_split(fgets(STDIN)) as $x => $c) {
        switch($c) {
            case "*": $attendees[$index2]++; break;
            case ":": $index2++; break;
            case "-": $index += 3; continue 3;
        }  
    }
}

$total = array_sum($attendees);

echo $total . " attendees" . PHP_EOL;
echo implode("\n", array_map(function($line) use ($total) {
    return implode(" ", array_map(function($value) use ($total) {
        return str_pad(round($value / $total * 100) . "%", 4, "_", STR_PAD_LEFT);
    }, $line));
}, array_chunk($attendees, 3))) . PHP_EOL;
