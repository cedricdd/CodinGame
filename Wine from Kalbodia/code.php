<?php

/*
 * Generate the hash of the string
 * BBBSAAA & rrrmppp => AAABCCC
 * SBSAS & mrmpm => ABACA
 */
function getHash(string $string): string {
    $from = array_unique(str_split($string)); //The characters in the original string in the order of appearance
    $to = array_slice(range("A", "Z"), 0, count($from)); //The characters we use to replace them

    return strtr($string, array_combine($from, $to));
}

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $requests[] = getHash(trim(fgets(STDIN)));
}

$answer = array_fill(0, $N, 0); //Fill with default values so it's already sorted

for ($i = 0; $i < $N; $i++) {
    $answer[array_search(getHash(trim(fgets(STDIN))), $requests)] = $i + 1;
}

echo implode("\n", $answer) . PHP_EOL;
