<?php

fscanf(STDIN, "%d", $t);
for ($i = 0; $i < $t; $i++) {
    [$base, $target, $fixed] = explode(" ", trim(fgets(STDIN)));

    //Strings with different length can't be valid
    if(($s1 = strlen($base)) != ($s2 = strlen($target))) {
        echo "false" . PHP_EOL;
        continue;
    }

    $subBase = "";
    $subTarget = "";
    $decomp = [];

    //Find all the parts that need to contain the same letters
    for($j = 0; $j < $s1; ++$j) {
        //This is a letter we can't switch
        if(strpos($fixed, $base[$j]) !== false) {
            $decomp[] = [$subBase, $subTarget];
            $decomp[] = [$base[$j], $target[$j]];
        } else {
            $subBase .= $base[$j];
            $subTarget .= $target[$j];
        }
    }

    $decomp[] = [$subBase, $subTarget];

    foreach($decomp as [$base, $target]) {
        //By swapping we can create any combinaisons of letters, we just need to make sure both sides have the same letters with the same quantities.
        if(count_chars($base, 1) != count_chars($target, 1)) {
            echo "false" . PHP_EOL;
            continue 2;
        }
    }

    echo "true" . PHP_EOL;
}
