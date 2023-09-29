<?php

fscanf(STDIN, "%d", $t);
for ($i = 0; $i < $t; $i++) {
    fscanf(STDIN, "%s %s %s", $base, $target, $fixed);

    //Base and target are different length, it can't be done
    if(strlen($base) != strlen($target)) {
        echo "-1" . PHP_EOL;
        continue;
    }

    //Split base & target on fixed letters
    $explodedBase = preg_split("/[$fixed]/", $base, -1, PREG_SPLIT_NO_EMPTY);
    $explodedTarget = preg_split("/[$fixed]/", $target, -1, PREG_SPLIT_NO_EMPTY);

    //Different number of exploded parts, it can't be done
    if(count($explodedBase) != count($explodedTarget)) {
        echo "-1" . PHP_EOL;
        continue;
    }

    $swap = 0;

    foreach($explodedBase as $index => $stringBase) {
        $stringTarget = $explodedTarget[$index];

        //Base and target are different length, it can't be done
        if(strlen($stringBase) != strlen($stringTarget)) {
            echo "-1" . PHP_EOL;
            continue 2;
        }

        for($j = 0; $j < strlen($stringBase); ++$j) {
            //Letters are already identical, just continue
            if($stringBase[$j] == $stringTarget[0]) {
                $stringTarget = substr($stringTarget, 1);
            } else {
                //Find the first position of this letter
                $position = strpos($stringTarget, $stringBase[$j]);

                //The letter isn't in target, it can't be done
                if($position === false) {
                    echo "-1" . PHP_EOL;
                    continue 3;
                }

                //Remove the letter we just used
                $stringTarget = substr_replace($stringTarget, "", $position, 1);

                $swap += $position;
            }
        }
    }

    echo $swap . PHP_EOL;
}
