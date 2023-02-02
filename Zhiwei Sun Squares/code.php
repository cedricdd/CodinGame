<?php

fscanf(STDIN, "%d", $n);

$solutions = 0;

//We know that a, b, c & d are <= sqrt(n)
for($b = 0; $b <= sqrt($n); ++$b) {
    for($c = 0; $c <= sqrt($n); ++$c) {
        for($d = 0; $d <= sqrt($n); ++$d) {
            $e = sqrt($b + 3 * $c + 5 * $d);

            if($e == intval($e)) {
                $a = sqrt($n - ($b ** 2) - ($c ** 2) - ($d ** 2));

                if($a == intval($a)) ++$solutions;
            }
        }
    }
}

echo $solutions . PHP_EOL;
