<?php

$alphabet = [
    "A" => ".-", "B" => "-...", "C" => "-.-.", "D" => "-..", "E" => ".", "F" => "..-.", "G" => "--.", "H" => "....", "I" => "..", 
    "J" => ".---", "K" => "-.-", "L" => ".-..", "M" => "--", "N" => "-.", "O" => "---", "P" => ".--.", "Q" => "--.-", 
    "R" => ".-.", "S" => "...", "T" => "-", "U" => "..-", "V" => "...-", "W" => ".--", "X" => "-..-", "Y" => "-.--", "Z" => "--..",
];

function converToMorse($word) {
    global $alphabet;

    $result = "";

    foreach(str_split($word) as $letter) {
        $result .= $alphabet[$letter];
    }

    return $result;
}

fscanf(STDIN, "%s", $L);

error_log(var_export("L " . $L, true)); 

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s", $word);

    $morse = converToMorse($word);

    //Several words can have the same morse representation.
    //We don't want to decode, just count the possibilities, we can merge them if we keep the # of words using this representation.
    $words[$morse] = ($words[$morse] ?? 0) + 1;

    //We save to sizes of the morse representations for optimization
    $sizes[strlen($morse)] = 1;
}

//We sort the sizes to be able to optimize the search by breaking
ksort($sizes);

$memorization[""] = 1; //If we end up with an empty code it means found a solution

function solve($code) {
    global $words, $memorization, $sizes;

    $length = strlen($code);

    //We know the value, return it
    if(isset($memorization[$code])) return $memorization[$code];

    $result = 0;

    //We test all the words we could have
    foreach($sizes as $size => $filler) {
        //We can stop, all the other words are too big
        if($size > $length) break;

        //The sub-part of the code that needs to match the word
        $subCode = substr($code, 0, $size);

        if(isset($words[$subCode])) {
            //Multiple words can have the same code, we need to count all the possibilities
            $result += solve(substr($code, $size)) * $words[$subCode];
        }      
    }

    return $memorization[$code] = $result;
}

echo solve($L) . PHP_EOL;
