<?php

//Count the number of digits for numbers [1 - $n}
function countDigits(int $n): int {

    $count = 0;

    for($i = 1; $i <= strlen($n); ++$i) {
        $count += $n - ((10 ** ($i - 1)) - 1);
    }

    return $count;
}

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $start, $end);

    --$start; //Start range need to be added too

    //Number of digits we need to add
    $digitsToAdd = countDigits($end) - countDigits($start);
    //Max number of digits for Alice
    $aliceDigits = $digitsToAdd >> 1;

    $size = strlen($start);

    while(true) {
        //The max number of pages that can still be added with $size digits
        $value = min(10 ** $size - $start - 1, intdiv($aliceDigits, $size));
        $start += $value;
        $aliceDigits -= $value * $size;

        //Not enough digits left to add another page
        if($aliceDigits <= $size) break;

        $size++;
    }

    echo $start . PHP_EOL;
}
?>
