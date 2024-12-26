<?php

$start2 = microtime(1);

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%s", $start);
for ($i = 0; $i < $N; $i++) {
    [$a, $b] = explode(" -> ", trim(fgets(STDIN)));

    if(ctype_lower($b)) $terminal[$b][$a] = 1;
    else $nonTerminal[$b[0]][$b[1]][$a] = 1;
}

fscanf(STDIN, "%d", $T);

for ($index = 0; $index < $T; $index++) {
    fscanf(STDIN, "%s", $word);

    $n = strlen($word);
    $table = [];

    //Init the table with empty values, we only need to top-right half of the array
    for($i = 0; $i < $n; ++$i) {
        $table[$i] = array_fill($i, $n - $i, []);
    }

    for($i = 0; $i < $n; ++$i) {
        //There is no way to create this work
        if(!isset($terminal[$word[$i]])) {
            echo "false" . PHP_EOL;
            continue 2;
        }

        //Add the non-terminals that can derive the letter
        $table[$i][$i] = $terminal[$word[$i]];
    }

    for($l = 2; $l <= $n; ++$l) { //For each length from 2 to n
        for($i = 0; $i <= $n - $l; ++$i) {
            $j = $i + $l - 1;

            for($k = $i; $k < $j; ++$k) {
                $left = $table[$i][$k];
                $right = $table[$k + 1][$j];

                foreach($nonTerminal as $a => $temp) {
                    if(!isset($left[$a])) continue; //We can skip all the rules starting with this symbol

                    foreach($temp as $b => $list) {
                        if(!isset($right[$b])) continue; //We can skip all the rules ending with this symbol

                        $table[$i][$j] += $list; //Add the symbols
                    }
                }
            }
        }
    }

    if(isset($table[0][$n - 1][$start])) echo "true" . PHP_EOL;
    else echo "false" . PHP_EOL;
}

error_log(microtime(1) - $start2);
