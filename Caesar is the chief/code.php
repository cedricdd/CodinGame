<?php

$alphabet = range("A", "Z");
$alphabetFlipped = array_flip($alphabet);
$textToDecode = str_split(trim(fgets(STDIN)));

//We test all the possible shifts, we start at 0 in case the message is not encoded
for($i = 0; $i < 26; ++$i) {
    $decoded = "";

    //Replace all the letters by the shift
    foreach($textToDecode as $c) $decoded .= ctype_alpha($c) ? $alphabet[($alphabetFlipped[$c] + $i) % 26] : $c;

    //If one of the word is CHIEF, we have decoded the message
    if(preg_match("/(^|\s)CHIEF(\s|$)/", $decoded)) exit("$decoded");
}

echo "WRONG MESSAGE" . PHP_EOL;
