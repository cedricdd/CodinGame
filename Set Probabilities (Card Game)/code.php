<?php

const INFOS = [
    [1, 2, 3],
    ['OUTLINED', 'STRIPED', 'SOLID'],
    ['RED', 'GREEN', 'PURPLE'],
    ['DIAMOND', 'OVAL', 'SQUIGGLE'],
];

function getThirdCard(string $c1, string $c2): string {
    $third = [];
    $card1 = explode("-", $c1);
    $card2 = explode("-", $c2);

    for($i = 0; $i < 4; ++$i) {
        if($card1[$i] == $card2[$i]) $third[$i] = $card1[$i]; //The third card needs the same value
        else //The third card needs a different value
        {
            foreach(INFOS[$i] as $info) {
                if($info != $card1[$i] && $info != $card2[$i]) {
                    $third[$i] = $info;
                    continue 2;
                }
            }
        }
    }

    return implode("-", $third);
}

$cards = [];
$candidates = [];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d %s %s %s", $number, $shading, $color, $shape);

    $index = $number . "-" . $shading . "-" . $color . "-" . $shape;

    //Generate the third card for every combinaison of two cards
    foreach($cards as $card => $_) {
        $third = getThirdCard($index, $card);

        $candidates[$third] = 1;
    }

    $cards[$index] = 1;
}

//We already have a set
foreach($candidates as $card => $_) if(isset($cards[$card])) exit("1.0000");

//Calculate the probablity
echo number_format(count($candidates) / (81 - $n), 4) . PHP_EOL;
