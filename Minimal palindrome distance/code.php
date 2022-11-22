<?php

fscanf(STDIN, "%d", $n);
$s = stream_get_line(STDIN, $n + 1, "\n");

//Checking if the string starting at position $i is a palindrome
for($i = 0; $i < $n; ++$i) {
    for($j = 1; $j <= ($n - $i) / 2; ++$j) {
        if($s[-$j] != $s[$i + $j - 1]) continue 2;
    }

    break; //We found a palindrome
}

echo $i . PHP_EOL;
