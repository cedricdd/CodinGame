<?php

fscanf(STDIN, "%d", $N);
$A = array_map("intval",explode(" ", trim(fgets(STDIN))));
$B = array_map("intval",explode(" ", trim(fgets(STDIN))));

$position = 0;
$moves = [];

while($position < $N) {

    //Values already match
    if($A[$position] == $B[$position]) $position++;

    //Value A > B, we just need to shift the difference to the right
    elseif($A[$position] > $B[$position]) {
        $moved = $A[$position] - $B[$position];
        $A[$position + 1] += $moved;
        $moves[] = ($position + 1) . " 1 $moved";
        $position++;
    } //Value B < A, we need to shift to the left
    else {
        $missing = $B[$position] - $A[$position]; //The initial amount that is missing
        $leftMoves = [($position + 2) . " -1 " . $missing];

        for($i = $position + 1; $i < $N; ++$i) {
            //The amount at the current position is enough to not go negative
            if($A[$i] >= $missing) {
                $A[$i] -= $missing; //This is the only value we need to udpate
                break;
            }
            //Not enough, we continue and update the value of $missing
            else {
                $missing += $B[$i] - $A[$i];
                array_unshift($leftMoves, ($i + 2) . " -1 " . $missing);
            }
        }

        //Add the left moves
        $moves = array_merge($moves, $leftMoves);

        //We can jump to $i position
        $position = $i;
    }
}

echo count($moves) . PHP_EOL;
echo implode("\n", $moves) . PHP_EOL;
