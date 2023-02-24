<?php

function solve(string $s1, string $s2) {

    global $combinations;
    $size1 = strlen($s1);
    $size2 = strlen($s2);
    $min = min($size1, $size2);
    
    for($i = 1; $i < $size1; ++$i) {
        for($j = 0; $j < $size2 - 1; ++$j) {
            if(strcasecmp($s1[$i], $s2[$j]) == 0) {
                $combination = substr($s1, 0, $i) . strtolower(substr($s2, $j));

                if(strlen($combination) < $min) continue; //Combinaison is too short
                if(strpos($s1, $combination) === 0) continue; //Combinaison is just a sub-part or s1
                if(strpos($s2, $combination) === 0) continue; //Combinaison is just a sub-part of s2

                //Find how many shared letters we have
                for($shared = 1; $shared < min($size1 - $i, $size2 - $j); ++$shared) {
                    if(strcasecmp($s1[$i + $shared], $s2[$j + $shared]) != 0) break;
                }
                
                $combinations[$shared][] = $combination;
            }
        }
    }

    return $combinations;
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    preg_match("/([a-zA-Z]+) and ([a-zA-Z]+).*/", trim(fgets(STDIN)), $matches);

    [, $name1, $name2] = $matches;

    $combinations = [];

    //Get all the combinations we can create
    solve($name1, $name2);
    solve($name2, $name1); 

    if(count($combinations) == 0) echo "$name1 plus $name2 = NONE" . PHP_EOL;
    else {
        //We use the ones with the most shared letters
        $results = $combinations[max(array_keys($combinations))];
        sort($results); //Display them alphabetically

        echo "$name1 plus $name2 = " . implode(" ", $results) . PHP_EOL;
    }
}
