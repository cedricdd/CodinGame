<?php

$fraction = stream_get_line(STDIN, 200 + 1, "\n");

error_log($fraction);

if($fraction[0] === '[') {
    $values = explode(', ', str_replace(';', ',', substr($fraction, 1, -1)));

    $numerator = 1;
    $denominator = array_pop($values);

    while($values) {
        $value = array_pop($values);

        $numerator += $value * $denominator;

        if($values) {
            [$numerator, $denominator] = [$denominator, $numerator];
        }
    }

    echo $numerator . "/" . $denominator . PHP_EOL;
} else {
    [$p, $q] = explode('/', $fraction);
    $values = [];

    while($q != 0) {
        $x = floor($p / $q);
        $values[] = $x;
        [$p, $q] = [$q, $p - $x * $q];
    }

    echo '[' . preg_replace('/\,/', ';', implode(", ", $values), 1) . ']' . PHP_EOL;
}
