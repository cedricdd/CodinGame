<?php

function addTiles(string $tiles, array &$hand) {
    $size = strlen($tiles) - 1;
    $suit = $tiles[$size];

    for($i = 0; $i < $size; ++$i) {
        $hand[$suit][$tiles[$i]]++;
    }
}

$hand = ['m' => array_fill(1, 9, 0), 'p' => array_fill(1, 9, 0), 's' => array_fill(1, 9, 0), 'z' => array_fill(1, 7, 0)];

preg_match_all("/([1-9]+[mpsz])/", trim(fgets(STDIN)), $matches);

foreach($matches[0] as $tiles) addTiles($tiles, $hand);

error_log(var_export($hand, 1));

$pairs = 0;
$sets = 0;

foreach($hand as $suit => $info) {
    foreach($info as $digit => &$count) {
        if($hand[$suit][$digit] == 0) continue;

        if($suit != 'z' && $digit <= 7) {
            while($hand[$suit][$digit] && $hand[$suit][($digit + 1)] && $hand[$suit][($digit + 2)]) {
                $sets++;

                $hand[$suit][$digit]--;
                $hand[$suit][$digit + 1]--;
                $hand[$suit][$digit + 2]--;
            }
        }

        switch($hand[$suit][$digit]) {
            case 0: continue 2;
            case 1:
                if($suit != 'z' && !($digit == 1 || $digit == 9)) {
                    error_log("We have $suit - $digit - " . $hand[$suit][$digit]);
                    exit("FALSE");
                }
                break;
            case 2: ++$pairs; break;
            case 3: ++$sets; break;
            default: exit("FALSE");
        }
    }
}

error_log("$pairs $sets");

if(($sets == 4 && $pairs == 1) || $pairs == 7 || $pairs == 1) echo "TRUE" . PHP_EOL;
else echo "FALSE" . PHP_EOL;
