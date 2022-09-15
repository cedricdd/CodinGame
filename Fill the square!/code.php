<?php

fscanf(STDIN, "%d", $N);

$full = 2 ** $N - 1;
$press = [];

for ($y = 0; $y < $N; ++$y) {
    $states[] = bindec(strtr(trim(fgets(STDIN)), ".*", "01"));
}

//Pre-compute the changes applied when we press any rows at position $i
for($i = 0; $i < $N; ++$i) {
    $b = $N - $i - 1; //least/most significant bit is reversed compared to $i

    $press[$i][0] = 1 << $b; //We toggle the LED we press
    $press[$i][-1] = $press[$i][0]; //We toggle the LED above
    $press[$i][1] = $press[$i][0]; //We toggle the LED below
    if($i > 0) $press[$i][0] |= 1 << $b + 1; //We toggle the LED left
    if($i < $N - 1) $press[$i][0] |= 1 << $b - 1; //We toggle the LED right
}

function solve(array $states, string $pressed, int $min): void {

    global $press, $N, $full, $start1;

    $solution = $pressed;
    $check = $states;

    for($y = 1; $y < $N; ++$y) {
        //The previous line is all ON, we can't press on anything
        if($check[$y - 1] == $full) continue;

        for($x = 0; $x < $N; ++$x) {
            //If the LED on the previous row is not ON we need to press here
            if(!($check[$y - 1] & 1 << $N - $x - 1)) {
                //Save that we pressed the position
                $solution[$y * $N + $x] = "1";

                //Apply the changes of the press
                $check[$y] ^= $press[$x][0];
                if($y > 0) $check[$y - 1] ^= $press[$x][-1];
                if($y < $N - 1) $check[$y + 1] ^= $press[$x][1];
            }
        }
    }

    //We are sure that we can set all the rows [0;N-1[ to full ON, the only one we need to test is the last one
    if($check[$N - 1] == $full) {
        echo implode("\n", str_split(strtr($solution, "01", ".X"), $N));
        exit();
    } 

    //We need to test all the combinaisons on the first row
    for($i = $N - 1; $i >= $min; --$i) {
        $updatedStates = $states;
        $updatedStates[0] ^= $press[$i][0];
        $updatedStates[1] ^= $press[$i][1];
        $updatedPressed = $pressed;
        $updatedPressed[$i] = "1";
        solve($updatedStates, $updatedPressed, $i + 1);
    }
}

solve($states, str_repeat("0", $N * $N), 0);
?>
