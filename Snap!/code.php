<?php

const PRECEDENCE = ['C' => 1, 'D' => 2, 'H' => 3, 'S' => 4];

$p0 = [];
$p1 = [];

for ($i = trim(fgets(STDIN)); $i--;) {
    fscanf(STDIN, "%s", $card);

    preg_match("/(.+)(.)/", $card, $match);

    $p0[] = [$match[1], $match[2]];
}

for ($i = trim(fgets(STDIN)); $i--;) {
    fscanf(STDIN, "%s", $card);

    preg_match("/(.+)(.)/", $card, $match);

    $p1[] = [$match[1], $match[2]];
}

if(count($p0) + count($p1) == 0) exit("Go get some cards!");
if(count($p0) == 0) exit("Winner: Player 2\n" . count($p1));
if(count($p1) == 0) exit("Winner: Player 1\n" . count($p0));

$pile = [];
$index = 0;

while(true) {
    array_unshift($pile, array_shift(${"p".$index})); //Add the card to the deck

    //We have a snap
    if(count($pile) > 1 && $pile[0][0] == $pile[1][0]) {
        if(PRECEDENCE[$pile[0][1]] < PRECEDENCE[$pile[1][1]]) $index ^= 1; //It's the other player who won the snap
            
        ${"p".$index} = array_merge(${"p".$index}, array_reverse($pile)); //Add the pile to the player's cards

        if(count(${"p". ($index ^ 1)}) == 0) exit("Winner: Player " . ($index + 1) . "\n" . count(${"p" . $index}));

        $pile = [array_shift(${"p".$index})];
    }

    //The player has lost
    if(count(${"p".$index}) == 0) {
        $index ^= 1;
        exit("Winner: Player " . ($index + 1) . "\n" . count(${"p".$index}));
    }

    $index ^= 1;
}
