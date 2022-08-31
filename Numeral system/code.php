<?php

$alphabet = array_flip(array_merge(range(0, 9), range("A", "Z")));
$minBase = 0;

preg_match("/(.+)\+(.+)=(.+)/", stream_get_line(STDIN, 100 + 1, "\n"), $numbers);

//Get the min base based on the chatacters used
foreach(str_split($numbers[0]) as $c) {
    $minBase = max($minBase, ($alphabet[$c] ?? 0) + 1);
}

//Find the first base where the equation is valid
for($i = $minBase; $i <= 36; ++$i) {
    if(intval($numbers[1], $i) + intval($numbers[2], $i) == intval($numbers[3], $i)) die("$i");
}
?>
