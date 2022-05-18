<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $price);

for ($i = 0; $i < $N; $i++)
{
    fscanf(STDIN, "%d", $B[$i]);
}

if(array_sum($B) < $price) {
    exit("IMPOSSIBLE");
}

$totalAmount = 0;
for ($i = 0; $i < $N; $i++)
{
    $amounts[$i] = 0;
}

do {
    foreach($B as $key => $value) {
        if($value == 0) {
            unset($B[$key]);
            continue;
        }

        --$B[$key];
        ++$amounts[$key];

        if(++$totalAmount == $price) {
            sort($amounts);

            foreach($amounts as $key => $value) {
                echo $value . "\n";
            }
            exit();
        }
    }
} while (true);
?>
