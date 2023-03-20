<?php

preg_match("/(.*)([+-])(.*)i/", trim(fgets(STDIN)), $matches);
fscanf(STDIN, "%d", $m);

[$cr, $ci] = [$matches[1], $matches[3] * ($matches[2] == "-" ? -1 : 1)];
[$nr, $ni] = [0, 0];

for($iteration = 1; $iteration < $m; ++$iteration) {
    //[a,b]^2 is defined as [a^2-b^2, 2*a*b]
    [$nr, $ni] = [$nr ** 2 - $ni ** 2 + $cr, 2 * $nr * $ni + $ci];

    if(sqrt($nr ** 2 + $ni ** 2) > 2) break;
}

echo $iteration . PHP_EOL;
