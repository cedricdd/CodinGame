<?php

function findLetters(string $phrase, int $nth): array {
    $positions = [];
    $letters = [];

    foreach(str_split($phrase) as $i => $c) {
        if(!ctype_alpha($c)) continue;
        if((ord($c) - 64) % $nth == 0) {
            $positions[] = $i;
            $letters[] = $c;
        }
    }

    return [$positions, $letters];
}

$phrase = stream_get_line(STDIN, 1024 + 1, "\n");

error_log(var_export("Scrambled: " . $phrase, true));

//Count the number of letters in each word
$words = array_map('strlen', explode(" ", $phrase));

//Reverse that list of numbers
$words = array_reverse($words);

$phrase = str_replace(" ", "", $phrase);
$offset = 0;

//Re-apply the revised word lengths to the letter sequence.
foreach($words as $i => $size) {
    $phrase = substr($phrase, 0, $size + $offset) . " " . substr($phrase, $size + $offset);
    $offset += $size + 1;
}

$phrase = trim($phrase);

error_log(var_export("STEP 3: " . $phrase, true));

//Find every 4th letter of the alphabet in the phrase
[$positions, $letters] = findLetters($phrase, 4);

//Reverse shift their positions one to the left
array_unshift($letters, array_pop($letters));

foreach($positions as $i => $position) {
    $phrase[$position] = $letters[$i];
}

error_log(var_export("STEP 2: " . $phrase, true));

//Find every 3th letter of the alphabet in the phrase
[$positions, $letters] = findLetters($phrase, 3);

//Reverse shift their positions one to the right
$letters[] = array_shift($letters);

foreach($positions as $i => $position) {
    $phrase[$position] = $letters[$i];
}

error_log(var_export("STEP 1: " . $phrase, true));

//Find every 2th letter of the alphabet in the phrase
[$positions, $letters] = findLetters($phrase, 2);

//Reverse their order 
$letters = array_reverse($letters);

foreach($positions as $i => $position) {
    $phrase[$position] = $letters[$i];
}

error_log(var_export("Unscrambled : " . $phrase, true));
echo $phrase . "\n";
?>
