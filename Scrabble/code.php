<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

 $points = [
     'e' => 1, 'a' => 1, 'i' => 1, 'o' => 1, 'n' => 1, 'r' => 1, 't' => 1, 'l' => 1, 's' => 1, 'u' => 1,
     'd' => 2, 'g' => 2,
     'b' => 3, 'c' => 3, 'm' => 3, 'p' => 3,
     'f' => 4, 'h' => 4, 'v' => 4, 'w' => 4, 'y' => 4,
     'k' => 5, 
     'j' => 8, 'x' => 8,
     'q' => 10, 'z' => 10, 
 ];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++)
{
    $word = stream_get_line(STDIN, 30 + 1, "\n");

    //We only get 7 letters
    if(strlen($word) > 7) {
        continue;
    } 
    
    $score = 0;
    foreach(str_split($word) as $letter) {
        $score += $points[$letter];
    }
    
    $dictionary[$word] = $score;
}

//error_log(var_export($dictionary, true)); 

//We group by similar score, word which appears first in the dictionary is the best
foreach($dictionary as $word => $score) {
    $words[$score][] = $word;
}

krsort($words);

$entry = stream_get_line(STDIN, 7 + 1, "\n");

foreach(str_split($entry) as $letter) {
    if(isset($letters[$letter])) {
        $letters[$letter] += 1;
    } else {
        $letters[$letter] = 1;
    }
}

error_log(var_export($letters, true)); 

foreach($words as $array_score) {
    foreach($array_score as $word) {

        $checkedLetters = [];
        foreach(str_split($word) as $letter) {
            if(isset($checkedLetters[$letter])) {
                $checkedLetters[$letter] += 1;
            } else {
                $checkedLetters[$letter] = 1;
            }

            //Word can't be made with the given letters
            if(!isset($letters[$letter]) || $letters[$letter] < $checkedLetters[$letter]) continue 2;
        }

        //We found the best word
        break 2;
    }
}

echo($word . "\n");
?>
