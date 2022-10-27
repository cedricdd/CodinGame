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
        $moving = [[$position + 1, $missing]];

        for($j = $position + 1; $j < $N; ++$j) {
            //The amount at the current position is enough to not go negative
            if($A[$j] >= $missing) {
                $A[$j] -= $missing; //This is the only value we need to udpate
                break;
            }
            //Not enough, we continue and update the value of $missing
            else {
                $missing += $B[$j] - $A[$j];
                $moving[] = [$j + 1, $missing];
            }
        }

        //Add the moves from highest index to lowest
        foreach(array_reverse($moving) as [$index, $value]) {
            $moves[] = ($index + 1) . " -1 " . $value;
        }

        //We can jump to $j position
        $position = $j;
    }
}

echo count($moves) . PHP_EOL;
echo implode("\n", $moves) . PHP_EOL;
