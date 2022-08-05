<?php

$expression = stream_get_line(STDIN, 256 + 1, "\n");

preg_match_all("/([+-][a-z]+)/", $expression, $matches);

foreach($matches[0] as $i => $sort) {
    $sorting[] = ($sort[0] == "+") ? "ASC" : "DESC"; //Sort ascending or descending
    $sortingID[substr($sort, 1)] = $i; //To save the inputs in the order of the sorting
}

$types = stream_get_line(STDIN, 256 + 1, "\n");
fscanf(STDIN, "%d", $N);

for ($i = 1; $i <= $N; $i++) {
    $input = stream_get_line(STDIN, 256 + 1, "\n");

    preg_match("/id:[0-9]+,(.*)/", $input, $match);

    foreach(explode(",", $match[1]) as $input) {
        preg_match("/([a-z]+):([0-9a-z]+)/", $input, $info);

        $inputs[$i][$sortingID[$info[1]]] = $info[2];
    }
}

function customSort(&$a, &$b, $i) {
    global $sorting;

    //Same value with the current parameter, if it's not the last parameter, compare with the next one
    if($a[$i] == $b[$i] && $i < count($sorting) - 1) return customSort($a, $b, $i + 1);
    //We can use the current parameter for sorting
    else return ($sorting[$i] == "ASC") ? $a[$i] <=> $b[$i] : $b[$i] <=> $a[$i];
}

//Sort the inputs following the sorting expression
uasort($inputs, function($a, $b) {
    return customSort($a, $b, 0);
});

echo implode("\n", array_keys($inputs));
?>
