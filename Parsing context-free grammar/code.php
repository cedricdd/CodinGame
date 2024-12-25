<?php

$start2 = microtime(1);

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%s", $start);
for ($i = 0; $i < $N; $i++) {
    [$a, $b] = explode(" -> ", trim(fgets(STDIN)));

    if(ctype_lower($b)) $g2[$b][$a] = 1;
    else $g1[] = [$a, $b[0], $b[1]];
}

fscanf(STDIN, "%d", $T);

// error_log(var_export($g1, 1));
// error_log(var_export($g2, 1));

for ($index = 0; $index < $T; $index++) {
    fscanf(STDIN, "%s", $word);

    $n = strlen($word);
    $table = [];

    for($i = 0; $i < $n; ++$i) {
        if(!isset($g2[$word[$i]])) {
            echo "false" . PHP_EOL;
            continue 2;
        }

        $table[$i][$i] = $g2[$word[$i]];
    }

    for($l = 2; $l <= $n; ++$l) {
        for($i = 0; $i <= $n - $l; ++$i) {
            $j = $i + $l - 1;

            for($k = $i; $k < $j; ++$k) {
                // error_log("i $i - j $j - k $k -- $i $k - " . ($k + 1) . " $j");

                foreach($g1 as [$a, $b, $c]) {
                    // error_log("testing $a $b $c");

                    if(isset($table[$i][$k][$b]) && isset($table[$k + 1][$j][$c])) {
                        $table[$i][$j][$a] = 1;
                        // error_log("adding $a in $i $j");
                    }
                }
            }
        }

        /*
        $progress = false;
        for ($i = 0; $i < $n; $i++) {
            for ($j = $i; $j < min($i + $l, $n); $j++) {
                if (isset($table[$i][$j])) {
                    $progress = true;
                    break 2;
                }
            }
        }

        if(!$progress) break;
        */
    }
 
    // error_log(var_export($table, 1));

    if(isset($table[0][$n - 1][$start])) echo "true" . PHP_EOL;
    else echo "false" . PHP_EOL;
}

error_log(microtime(1) - $start2);
