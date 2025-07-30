<?php

/**
  * A+B+C+D = X
  * A+E = B−E = C*E = D/E = S
  * A+B+C+D => (S−E) + (S+E) + (S/E) + (S×E) => 2*S + S/E + S*E
  */
function is_good($X) {
    //No matter the value of E we know that S can't be bigger than X/2 otherwise 2*S alone would be above X
    $max1 = $X >> 1;

    for ($S = 2; $S <= $max1; ++$S) {
        //E can't be bigger than S-1 because S-E needs to be a positive integer
        //E can't be bigger than X / S because S*E can't be bigger than X
        $max2 = min($S - 1, $X / $S);

        for ($E = 1; $E <= $max2; ++$E) {
            if ($S % $E !== 0) continue; //S/E needs to be an integer

            if (2 * $S + $S / $E + $S * $E === $X) return true;
        }
    }
    return false;
}

$start = microtime(1);

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d", $X);

    echo (is_good($X) ? "YES" : "NO") . PHP_EOL;
}

error_log(microtime(1) - $start);
