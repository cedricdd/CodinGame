<?php

fscanf(STDIN, "%d %d %d", $base, $a, $b);
fscanf(STDIN, "%d", $k);
//We get each number in decimal & converted to the base we work on
$numbers = array_map(function($number) use ($base) {
    return [$number, base_convert($number, 10, $base)];
}, explode(" ", trim(fgets(STDIN))));

for($i = $a; $i <= $b; ++$i) {
    foreach($numbers as [$numberDec, $numberBase]) {
        $iDec = $i;

        while(true) {
            $iBase = strval(base_convert($iDec, 10, $base));

            //If it's a multiple of the number or it ends with the number it's Buzzle
            if($iDec % $numberDec == 0 || substr($iBase, -1) == $numberBase) {
                echo "Buzzle" . PHP_EOL;
                continue 3;
            }

            if($iDec < $base) break; //Nothing to sum anymore

            //Get the sum, convert each digit into decimal and sum them
            $iDec = array_sum(array_map(function($digit) use ($base) {
                return base_convert($digit, $base, 10);
            }, str_split($iBase)));
        }
    }

    echo $i . PHP_EOL;
}
