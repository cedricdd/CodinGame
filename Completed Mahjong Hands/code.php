<?php

function addTiles(string $tiles, array &$hand) {
    $size = strlen($tiles) - 1;
    $suit = $tiles[$size];

    for($i = 0; $i < $size; ++$i) {
        $hand[$suit][$tiles[$i]]++;
    }
}

function checkWinning(int $pairs, int $sets, array $hand) {
    foreach($hand as $suit => $info) {
        foreach($info as $digit => &$count) {
            if($hand[$suit][$digit] == 0) continue;
    
            //We are making a set with 3 tiles in a connected run
            if($suit != 'z' && $digit <= 7 && $hand[$suit][$digit] && $hand[$suit][($digit + 1)] && $hand[$suit][($digit + 2)]) {
                $hand2 = $hand;
                $hand2[$suit][$digit]--;
                $hand2[$suit][$digit + 1]--;
                $hand2[$suit][$digit + 2]--;

                checkWinning($pairs, $sets + 1, $hand2);
            }
    
            switch($hand[$suit][$digit]) {
                case 0: continue 2;
                case 1:
                    if($suit != 'z' && !($digit == 1 || $digit == 9)) return;
                    break;
                case 2: ++$pairs; break;
                case 3: ++$sets; break;
                default: return;
            }

            $hand[$suit][$digit] = 0;
        }
    }

    if(($sets == 4 && $pairs == 1) || $pairs == 7 || $pairs == 1) exit("TRUE") . PHP_EOL;
}

$hand = ['m' => array_fill(1, 9, 0), 'p' => array_fill(1, 9, 0), 's' => array_fill(1, 9, 0), 'z' => array_fill(1, 7, 0)];

preg_match_all("/([1-9]+[mpsz])/", trim(fgets(STDIN)), $matches);

foreach($matches[0] as $tiles) addTiles($tiles, $hand);

checkWinning(0, 0, $hand); //Check if the hand is a winning hand

echo "FALSE" . PHP_EOL;
