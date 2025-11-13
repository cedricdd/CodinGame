<?php

$p0 = [];
$p1 = [];

for ($i = trim(fgets(STDIN)); $i--;) {
    fscanf(STDIN, "%s", $card);

    preg_match("/(.+)./", $card, $match);

    $p0[] = $match[1];
}

for ($i = trim(fgets(STDIN)); $i--;) {
    fscanf(STDIN, "%s", $card);

    preg_match("/(.+)./", $card, $match);

    $p1[] = $match[1];
}

if(count($p0) + count($p1) == 0) exit("Go get some cards!");
if(count($p0) == 0) exit("Winner: Player 2\n" . count($p1));
if(count($p1) == 0) exit("Winner: Player 1\n" . count($p0));

$pile = [];
$index = 0;

while(true) {
    $card = array_shift(${"p".$index});

    array_unshift($pile, $card); //Add the card to the deck

    //We have a snap
    if(count($pile) > 1 && $pile[0] == $pile[1]) {

        ${"p".$index} = array_merge(${"p".$index}, $pile); //Add the pile to the player's cards

        $pile = [array_shift(${"p".$index})];
    }

    //The player has lost
    if(count(${"p".$index}) == 0) {
        $index ^= 1;
        exit("Winner: Player " . ($index + 1) . "\n" . count(${"p".$index}));
    }

    $index ^= 1;
}
