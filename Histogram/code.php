<?php

$alphabet = range('A', 'Z');

$distribution = array_combine($alphabet, array_fill(0, 26, 0));

$alphabet = array_flip($alphabet);

foreach(str_split(strtoupper(trim(fgets(STDIN)))) as $c) {
    if(ctype_alpha($c)) $distribution[$c]++;
}

$sum = array_sum($distribution);

//Calculating the percentage of each letters
$distribution = array_map(function($count) use ($sum) {
    return round(($count / $sum) * 100, 2);
}, $distribution);

$output = array_fill(0, 53, "  +");

foreach($distribution as $letter => $percentage) {
    $index = $alphabet[$letter] * 2 + 1;
    
    $max = intval(round($percentage));

    //We need to represent this letter
    if($max > 0) {
        for($i = 0; $i < $max; ++$i) {
            if(!isset($output[$index - 1][$i + 3])) $output[$index - 1][$i + 3] = '-';
            if(!isset($output[$index + 1][$i + 3])) $output[$index + 1][$i + 3] = '-';
        }
    
        $output[$index - 1][$max + 3] = '+';
        $output[$index + 1][$max + 3] = '+';
    }

    $output[$index] = $letter . " |" . str_repeat(' ', $max) . ($max > 0 ? '|' : '') . $percentage . '%';
}

echo implode("\n", array_map('rtrim', $output)) . PHP_EOL;
