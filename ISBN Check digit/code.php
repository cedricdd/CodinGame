<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $ISBN = trim(fgets(STDIN));

    if(strlen($ISBN) == 10) {
        if(!preg_match("/^[0-9]{9}[0-9X]$/", $ISBN)) {
            $invalid[] = $ISBN;
            continue;
        }

        $sum = 0;
        for($p = 0; $p < 9; ++$p) {
            $sum += $ISBN[$p] * (10 - $p);
        }

        if(($sum + strtr($ISBN[9], ["X" => 10])) % 11 != 0) $invalid[] = $ISBN;
    } else {
        if(!preg_match("/^[0-9]{13}$/", $ISBN)) {
            $invalid[] = $ISBN;
            continue;
        }

        $sum = 0;
        for($p = 0; $p < 12; ++$p) {
            $sum += $ISBN[$p] * (($p & 1) ? 3 : 1);
        }

        if(($sum + $ISBN[12]) % 10 != 0) $invalid[] = $ISBN;
    }
}

echo count($invalid) . " invalid:" . PHP_EOL;
echo implode("\n", $invalid) . PHP_EOL;
