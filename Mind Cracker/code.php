<?php

$start = microtime(1);

fscanf(STDIN, "%d", $nColors);
fscanf(STDIN, "%d", $size);
fscanf(STDIN, "%d", $nLines);
for ($i = 0; $i < $nLines; $i++) {
    $tries[] = explode(" ", trim(fgets(STDIN)));
}

//Sort by most incorrect positions
usort($tries, function($a, $b) {
    return $b[2] <=> $a[2];
});

function checkCorrect(int $indexGuess, int $position, int $correctLeft, array $colors): string {
    global $size, $nLines, $tries;
    
    //If the there is no correct left for that guess, remove the color used at each positions
    while($correctLeft == 0) {
        for($k = $position; $k < $size; ++$k) {
            unset($colors[$k][$tries[$indexGuess][0][$k]]);
            
            if(count($colors[$k]) == 0) return ""; //This was the last possible color
        }

        if(++$indexGuess == $nLines) break; //This was the last guess
        $position = 0;
        $correctLeft = $tries[$indexGuess][1];
    }
    
    if($indexGuess == $nLines) {
        ksort($colors);

        //Generate all the codes possible based on the colors left for each positions
        return generateCode($colors);
    }
    
    $currentGuess = $tries[$indexGuess][0][$position];
    
    //Can the current guess be a good guess
    if(isset($colors[$position][$currentGuess])) {
        //We continue by assuming the current guess was a correct one
        if($result = checkCorrect($indexGuess, $position + 1, $correctLeft - 1, [$position => [$currentGuess => 1]] + $colors)) return $result;
    }
    
    //We can choose to consider the current guess as an incorrect one
    if($size - $position - 1 >= $correctLeft) {
        unset($colors[$position][$currentGuess]);

        if(count($colors[$position]) == 0) return ""; //This was the last possible color

          //We continue by assuming the current guess was an incorrect one
        if($result = checkCorrect($indexGuess, $position + 1, $correctLeft, $colors)) return $result;
    }

    return "";
}

function checkIncorrect(string $code): string {
    global $tries, $size, $start;

    foreach($tries as [$guess, , $incorrect]) {

        //Mark all the positions that are correct
        for($i = 0; $i < $size; ++$i) {
            if($guess[$i] == $code[$i]) $guess[$i] = "C";
        }
        
        //Check how many colors are in an incorrect position
        for($i = $size - 1; $i >= 0; --$i) {
            if($guess[$i] == "C") continue;

            //Check if the color appears at another position of the code
            for($j = 1; $j < $size; ++$j) {
                if($code[$i] == $guess[($i + $j) % $size]) {
                    
                    if(--$incorrect < 0) return ""; //We already have too many incorrect, can't be the solution

                    $guess[($i + $j) % $size] = "I";
                    break;
                }
            }
        }

        if($incorrect != 0) return ""; //Not enough incorrect, can't be the solution
    }

    return $code;
}

function generateCode(array $numbers, string $code = ""): string {
    global $size;
    
    //Code is full, check if incorrect positions match
    if(!$numbers) return checkIncorrect($code);
    
    $possibilities = array_shift($numbers);
    
    foreach($possibilities as $digit => $filler) {
        if($result = generateCode($numbers, $code . $digit)) return $result;
    }

    return "";
}

$possibilities = array_fill(0, $nColors, 1); //Initially each colors can be used at any positions
    
echo checkCorrect(0, 0, $tries[0][1], array_fill(0, $size, $possibilities)) . PHP_EOL;

error_log(microtime(1) - $start);
