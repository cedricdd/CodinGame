<?php

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d %d", $A, $B);

$index = 0;
$sequence = "";

while(strlen($sequence) < $N) {
    $digit = ($index & 1 ? $B : $A); //Get the next digit to append in the sequence
    //The digit should appear as many times as the value of $sequence[$index]
    //If $sequence[$index] doesn't exist (very start) just append $digit times
    $sequence .= str_repeat($digit, ($sequence[$index++] ?? $digit)); 
}

echo substr($sequence, 0, $N);
