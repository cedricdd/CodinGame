<?php

$letters = [];

//We get all the distinct letter in a given word
function getLetters($word) {
    global $letters;

    foreach(array_unique(str_split($word)) as $x => $letter) {
        if(!isset($letters[$letter])) {
            $letters[$letter] = range((($x == 0) ? 1 : 0), 9); //The first letter can't be 0
        }
    }
}

$maxDigits = -INF;
$countMaxDigits = 0;

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s", $words[]);

    getLetters($words[$i]);

    $size = strlen($words[$i]);
    if($maxDigits < $size) {
        $maxDigits = $size;
        $countMaxDigits = 1;
    } elseif($maxDigits == $size) {
        ++$countMaxDigits;
    }
}

fscanf(STDIN, "%s", $total);
getLetters($total);

//If the result of the sum has more digits than the longest of the words we can limit to possiblities of the first letter of the total
if($maxDigits < strlen($total)) {
    $letters[$total[0]] = range(1, $countMaxDigits);
}

//We have associated each letter with a digit, test the sum with these values
function checkSolution($assoc) {
    global $words, $total, $start;

    //Replace the letters in each words
    $numbers = array_map(function($word) use ($assoc) {
        return strtr($word, $assoc);
    }, $words);

    //This solution is valid
    if(array_sum($numbers) == strtr($total, $assoc)) {
        //Output the letter//value in alphabetical order
        ksort($assoc);
        foreach($assoc as $letter => $value) echo "$letter $value" . PHP_EOL;
        exit();
    }
}

function solve(array $letters, array $assoc) {
    global $words, $total, $start;
    
    //All the letter are associated with a digit, test if the sum is correct
    if(count($letters) == 0) {
        checkSolution(array_flip($assoc));
    } //We test all the digits available for each letter
    else {
        $letter = array_key_last($letters);
        $possibilities = array_pop($letters);

        foreach($possibilities as $possibility) {
            //One digit can't be associated with more than one letter
            if(!isset($assoc[$possibility])) {
                solve($letters, $assoc + [$possibility => $letter]);
            }   
        }
    }
}

solve($letters, []);
?>
