<?php

[$e, $f, $a, $g, $b, $c, $d] = array_map("intval", str_split(trim(fgets(STDIN))));

$p1 = $e ^ $a ^ $b ^ $d;
$p2 = $f ^ $a ^ $c ^ $d;
$p3 = $g ^ $b ^ $c ^ $d;

/**
 * error in bit | p1 | p2 | d1 | p3 | d2 | d3 | d4 | no error
 * -------------|---------------------------------------------
 * p1 matches   | no | yes| no | yes| no | yes| no | yes
 * p2 matches   | yes| no | no | yes| yes| no | no | yes
 * p3 matches   | yes| yes| yes| no | no | no | no | yes
 */
if($p1 | $p2 | $p3) {
    if($p1 && !$p2 && !$p3) $e ^= 1;
    elseif(!$p1 && $p2 && !$p3) $f ^= 1;
    elseif($p1 && $p2 && !$p3) $a ^= 1;
    elseif(!$p1 && !$p2 && $p3) $g ^= 1;
    elseif($p1 && !$p2 && $p3) $b ^= 1;
    elseif(!$p1 && $p2 && $p3) $c ^= 1;
    elseif($p1 && $p2 && $p3) $d ^= 1;
}

echo base_convert($a . $b . $c . $d, 2, 16) . PHP_EOL;
