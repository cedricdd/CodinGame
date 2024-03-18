<?php

$kangaroos = [];

fscanf(STDIN, "%d", $N);
for ($g = 0; $g < $N; $g++) {
    $words = explode(", ", trim(fgets(STDIN)));

    //Sort words by number of letters, a joey can't be bigger than the kangaroo
    usort($words, function($a, $b) {
        return strlen($b) <=> strlen($a);
    });

    for($i = 0; $i < count($words) - 1; ++$i) {
        //Check all the potential joeys
        for($j = $i + 1; $j < count($words); ++$j) {
            //We found a joey
            if(preg_match("/" . implode(".*", str_split($words[$j])) . "/", $words[$i])) $kangaroos[$words[$i]][] = $words[$j];
        }
    }
}

if(count($kangaroos) == 0) exit("NONE");

ksort($kangaroos);

foreach($kangaroos as $kangaroo => $joeys) {
    sort($joeys);
    echo $kangaroo . ": " . implode(", ", $joeys) . PHP_EOL;
}
