<?php

const POINTS = [97=>1, 98=>3, 99=>3, 100=>2, 101=>1, 102=>4, 103=>2, 104=>4, 105=>1, 106=>8, 107=>5, 108=>1, 109=>3, 110=>1, 111=>1, 112=>3, 113=>10, 114=>1, 115=>1, 116=>1, 117=>1, 118=>4, 119=>4, 120=>8, 121=>4, 122=>10];

fscanf(STDIN, "%s", $mode);
fscanf(STDIN, "%d", $n);

for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s %s", $name, $hand);

    $hands[$name] = [count_chars($hand, 1), 0, "", PHP_INT_MAX, ""];
}

// error_log(var_export($hands, 1));

fscanf(STDIN, "%d", $d);
for ($i = 0; $i < $d; $i++) {
    fscanf(STDIN, "%s", $word);

    $letters = count_chars($word, 1);
    $score = 0;

    foreach($letters as $letter => $occ) $score += POINTS[$letter] * $occ;

    foreach($hands as $name => [$hand]) {
        if($hand == $letters) {
            if($score > $hands[$name][1]) {
                $hands[$name][1] = $score; 
                $hands[$name][2] = $word; 
            } elseif($score == $hands[$name][1] && strcmp($hands[$name][2], $word) > 0) {
                $hands[$name][1] = $score; 
                $hands[$name][2] = $word; 
            }
            if($score < $hands[$name][3]) {
                $hands[$name][3] = $score;
                $hands[$name][4] = $word; 
            } elseif($score == $hands[$name][3] && strcmp($hands[$name][4], $word) > 0) {
                $hands[$name][3] = $score; 
                $hands[$name][4] = $word; 
            }
        }
    }
}

foreach($hands as $name => [, $max]) {
    //No valid words for this person
    if($max == 0) unset($hands[$name]);
}

if($mode == "high") {
    $best = max(array_column($hands, 1));

    foreach($hands as $name => [, $max, $word]) {
        if($max == $best) echo $name . " " . $word . PHP_EOL;
    }
} else {
    $best = min(array_column($hands, 1));

    foreach($hands as $name => [, , , $min, $word]) {
        if($min == $best) echo $name . " " . $word . PHP_EOL;
    }
}
