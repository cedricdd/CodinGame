<?php

$alphabet = stream_get_line(STDIN, 200 + 1, "\n");
$message = stream_get_line(STDIN, 200 + 1, "\n");
$word = stream_get_line(STDIN, 200 + 1, "\n");

$alphabet = str_split($alphabet); //[0 => 'A', ...]
$alphabetFlip = array_flip($alphabet); //['A' => 0, ...]
$count = count($alphabet);

//We simply test all the combinaisons of a & b
for($a = 0; $a < $count; ++$a) {
    for($b = 0; $b < $count; ++$b) {
        $decoded = '';
        
        //Decode the message with the current values of a & b
        foreach(str_split($message) as $letter) {
            $decoded .= $alphabet[(($alphabetFlip[$letter] + $a) * $b) % $count];
        }
    
        //The guaranteed word is in the decoded, we have found the value of a & b
        if(strpos($decoded, $word) !== FALSE) {
            echo($decoded . "\n");
            exit();
        }
    }
}
?>
