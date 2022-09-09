<?php

const SIZE = 4;

//Generate all the possible codes based of the list of digits
function generatePossibleCodes(array &$digits, string $permutation = ""): void {

    if(strlen($permutation) == SIZE) {
        checkGuesses($permutation);
        return;
    }

    foreach($digits as $digit) {
        generatePossibleCodes($digits, $permutation . $digit);
    }
}

//Check if the code is valid, all the guesses would produce the same values of bulls & cows
function checkGuesses($code) {

    global $guesses, $start;

    foreach($guesses as [$guess, $bGuess, $cGuess]) {
        $bCode = 0;
        $cCode = 0;

        //Check bull value
        for($i = 0; $i < SIZE; ++$i) {
            //The digit of code & guess is the same, increase bull value
            if($code[$i] == $guess[$i]) {
                ++$bCode;
                $guess[$i] = "B"; //Can't use that number as cow
            } 
        }

        if($bCode != $bGuess) return; //If # of bulls doesn't match it's not the right code

        for($i = 0; $i < SIZE; ++$i) {
            if($guess[$i] == "B") continue; //This position was a bull

            //Check if the digit appears at another position of the code
            for($j = 1; $j < SIZE; ++$j) {
                if($code[$i] == $guess[($i + $j) % SIZE]) {
                    ++$cCode;
                    $guess[($i + $j) % SIZE] = "C"; //Can only use it once as cow
                }
            }
        }

        if($cCode != $cGuess) return; //If # of cows doesn't match it's not the right code
    }

    die("$code"); //All the guesses are good, we found the code
}

$digits = range(0, 9);

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %d %d", $guess, $bulls, $cows);
    
    if($bulls == SIZE) die("$guess"); //We have found the code

    //We know that the digits in the guess are the only digits in the code
    if($bulls + $cows == SIZE) {
        $digits = array_intersect($digits, str_split($guess));
    } //We know that the digits in the guess are not in the code
    elseif($bulls + $cows == 0) {
        $digits = array_diff($digits, str_split($guess));
        continue; //We don't need to keep the guess, we are excluding all the digits
    }

    $guesses[] = [$guess, $bulls, $cows];
}

generatePossibleCodes($digits);
?>
