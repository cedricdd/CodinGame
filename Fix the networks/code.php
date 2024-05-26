<?php

fscanf(STDIN, "%d", $m);
for ($i = 0; $i < $m; $i++) {
    [$p, $s] = explode("/", trim(fgets(STDIN)));

    $binary = "";

    //Convert IP address in binary
    foreach(explode(".", $p) as $n) $binary .= str_pad(decbin($n), 8, '0', STR_PAD_LEFT);

    //No bit set to 1, it's valid
    if(strpos(substr($binary, $s), '1') === false) echo "valid " . (2 ** (32 - $s)) . PHP_EOL;
    else {
        $s = 32 - strpos(strrev($binary), '1'); //Find the position of the first bit set to 1
        echo "invalid " . $p . "/" . $s . " " . (2 ** (32 - $s)) . PHP_EOL;
    }
}
