<?php

//Convert base 10 to base 26
function solveNumber(int $input): string {
    $result = "";

    do {
        $div = intdiv($input, 26);
        $rest = $input - ($div * 26);

        if($rest == 0) {
            $rest = 26;
            $input -= 1;
        }

        $result .= chr($rest - 1 + 65);

        $input = intdiv($input, 26);
    } while($input);

    return strrev($result);
}

//convert base 26 to base 10
function solveLabel(string $input): int {
    $result = 0;
    $length = strlen($input);

    for ($i = 0; $i < $length; ++$i) {
        $value = ord($input[$i]) - 65 + 1;

        $result += $value * (26 ** ($length - $i - 1));
    }

    return $result;
}

fscanf(STDIN, "%d", $n);

foreach(explode(" ", trim(fgets(STDIN))) as $input) {
    if(ctype_digit($input)) $output[] = solveNumber($input);
    else $output[] = solveLabel($input);
}

echo implode(" ", $output) . PHP_EOL;
