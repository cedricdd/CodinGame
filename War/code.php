<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

 function getCardScore($card) {
     switch($card) {
         case "J":
            return 11;
        case "Q":
            return 12;
        case "K":
            return 13;
        case "A":
            return 14;
        default:
            return intval($card);
     }
 }

function array_chop(&$array, $num) {
    $ret = array_slice($array, 0, $num);
    $array = array_slice($array, $num);
    return $ret;
}

// $n: the number of cards for player 1
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s", $card);
    $c1[] = getCardScore(rtrim($card, "DHCS"));
}
// $m: the number of cards for player 2
fscanf(STDIN, "%d", $m);
for ($i = 0; $i < $m; $i++) {
    fscanf(STDIN, "%s", $card);
    $c2[] = getCardScore(rtrim($card, "DHCS"));
}

$turns = 0;
$s1 = [];
$s2 = [];

while(true) {
    //If a war is happening, turn ends when the war ends
    if(count($s1) == 0) ++$turns;

    $s1[] = array_shift($c1);
    $s2[] = array_shift($c2);

    //Player 1 wins the cards
    if(end($s1) > end($s2)) {
        array_push($c1, ...array_chop($s1, count($s1)), ...array_chop($s2, count($s2)));
    } //Player 2 wins the cards
    elseif(end($s1) < end($s2)) {
        array_push($c2, ...array_chop($s1, count($s1)), ...array_chop($s2, count($s2))); 
    } //War is happening
    else {
        //Not enough cards left, it's a draw
        if(count($c1) < 4 || count($c2) < 4) {
            exit("PAT\n");
        }

        //We save the cards until we know who wins
        array_push($s1, ...array_chop($c1, 3));
        array_push($s2, ...array_chop($c2, 3));
    }

    //Game is over, one of player has no more cards
    if(count($c1) == 0) exit("2 " . $turns);
    elseif(count($c2) == 0) exit("1 " . $turns);
}
?>
