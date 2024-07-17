<?php

preg_match_all("/([A-Z]+|[0-9]+)/", trim(fgets(STDIN)), $matches, PREG_OFFSET_CAPTURE);

foreach($matches[0] as [$sequence, $start]) {
    if(!isset($occ[$sequence])) $occ[$sequence] = [1, strlen($sequence), $start];
    else $occ[$sequence][0]++;
}

uasort($occ, function($a, $b) {
    if($a[0] == $b[0]) {
        if($a[1] == $b[1]) {
            return $a[2] <=> $b[2];
        } else return $b[1] <=> $a[1];
    }
    else return $b[0] <=> $a[0];
});

$mostCommon = array_key_first($occ);

echo $occ[$mostCommon][0] . PHP_EOL . $mostCommon . PHP_EOL;
