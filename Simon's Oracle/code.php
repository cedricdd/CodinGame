<?php

fscanf(STDIN, "%d %d", $L, $N);

$secrets = range(0, 2 ** $L - 1);

//Secret can't be only 0
unset($secrets[0]);

error_log(var_export($secrets, 1));

$alphabet = range('Z', 'A');
$values = [];
$results = [];

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s", $query);

    $value = bindec($query);

    if(!isset($results[$value])) {
        $secret = null;

        foreach($values as $previousValue) {
            $xor = $value ^ $previousValue;

            error_log("$value - $previousValue => $xor");
        }
    }

    $values[] = $value;
}
