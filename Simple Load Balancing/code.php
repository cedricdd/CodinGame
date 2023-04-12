<?php

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%d", $k);
$loads = array_map("intval", explode(" ", trim(fgets(STDIN))));

sort($loads);
$min = reset($loads);

for($index = 1; $index < $n; ++$index) {
    //If the server has the same load as the previous we skip
    if(($diff = $loads[$index] - $loads[$index - 1]) == 0) continue;

    $added = min($k, $index * $diff); //How many jobs we can add 
    $min += floor($added / $index); //The new minimal number of jobs on any server

    if(($k -= $added) == 0) break; //If we have added all the jobs we can stop
}

//If all the server have the same load and we still have jobs to affect the result can only be 0 or 1
if($k > 0) echo (($k % $n == 0) ? 0 : 1) . PHP_EOL;
else echo (end($loads) - $min) . PHP_EOL;
