<?php

$permutation = stream_get_line(STDIN, 40 + 1, "\n");

preg_match_all("/\([^\(\)]+\)/", $permutation, $matches);

$max = 0;
$groups = [];
$results = [];

//We handle them from end to start
foreach(array_reverse($matches[0]) as $index => $permutation) {
    $IDs = array_map('intval', explode(" ", substr($permutation, 1, -1)));
    $n = count($IDs);

    $max = max($max, max($IDs));

    for($i = 0; $i < $n; ++$i) {
        $permutations[$index][$IDs[$i]] = $IDs[($i + 1) % $n];
    }
}   

//Find the transformation for each value
for($i = 1; $i <= $max; ++$i) {
    $value = $i;

    foreach($permutations as $list) {
        if(isset($list[$value])) $value = $list[$value];
    }

    $results[$i] = $value;
}

//Group the permutations
while(count($results)) {
    $group = [];
    $ID = array_key_first($results);

    while(true) {
        $nextID = $results[$ID] ?? 0;

        if($nextID == 0) break;

        unset($results[$ID]);
        $group[] = $ID;
        $ID = $nextID;
    } 

    if(count($group) > 1) $groups[] = "(" . implode(" ", $group) . ")";
}

if(count($groups) == 0) exit("()"); //Everything stays the same

sort($groups); //Lexicographic order

echo implode("", $groups) . PHP_EOL;
