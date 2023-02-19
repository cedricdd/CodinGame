<?php

function solve(string $s1, string $s2): array {

    $combinations = [];
    $size1 = strlen($s1);
    $size2 = strlen($s2);
    $min = min($size1, $size2);
    
    for($i = 1; $i < $size1; ++$i) {
        for($j = 0; $j < $size2 - 1; ++$j) {
            if($s1[$i] == $s2[$j]) {
                $combination = substr($s1, 0, $i) . substr($s2, $j);

                if(strlen($combination) < $min) continue; //Combinaison is too short
                if(strpos($s1, $combination) === 0) continue; //Combinaison is just a sub-part or s1
                if(strpos($s2, $combination) === 0) continue; //Combinaison is just a sub-part of s2

                //Find how many shared letters we have
                for($shared = 1; $shared < min($size1 - $i, $size2 - $j); ++$shared) {
                    if($s1[$i + $shared] != $s2[$j + $shared]) break;
                }
                
                $combinations[$shared][] = ucfirst($combination);
            }
        }
    }

    for($i = 1; $i < $size2; ++$i) {
        for($j = 0; $j < $size1 - 1; ++$j) {
            if($s2[$i] == $s1[$j]) {
                $combination = substr($s2, 0, $i) . substr($s1, $j);

                if(strlen($combination) < $min) continue; //Combinaison is too short
                if(strpos($s1, $combination) === 0) continue; //Combinaison is just a sub-part or s1
                if(strpos($s2, $combination) === 0) continue; //Combinaison is just a sub-part of s2

                //Find how many shared letters we have
                 for($shared = 1; $shared < min($size1 - $j, $size2 - $i); ++$shared) {
                    if($s1[$j + $shared] != $s2[$i + $shared]) break;
                }
                
                $combinations[$shared][] = ucfirst($combination);
            }
        }
    }

    ksort($combinations);
    return $combinations;
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    preg_match("/([a-zA-Z]+) and ([a-zA-Z]+).*/", trim(fgets(STDIN)), $matches);

    [, $name1, $name2] = $matches;

    //Get all the combinations we can create
    $combinations = solve(strtolower($name1), strtolower($name2));

    if(count($combinations) == 0) echo "$name1 plus $name2 = NONE" . PHP_EOL;
    else {
        //We use the ones with the most shared letters
        $results = array_pop($combinations);
        sort($results); //Display them alphabetically

        echo "$name1 plus $name2 = " . implode(" ", $results) . PHP_EOL;
    }
}
