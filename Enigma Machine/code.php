<?php

$alphabet = range('A', 'Z'); //0 => A, 1 => B, ...
$alphabet2 = array_flip($alphabet); //A => 0, B => 1, ...
$operation = stream_get_line(STDIN, 256 + 1, "\n");
fscanf(STDIN, "%d", $pseudoRandomNumber);

for ($i = 0; $i < 3; $i++){
    $rotors[] = stream_get_line(STDIN, 27 + 1, "\n");
}
$message = stream_get_line(STDIN, 1024 + 1, "\n");

foreach(str_split($message) as $letter) {
    if($operation == "ENCODE") {
        $r = ($alphabet2[$letter] + $pseudoRandomNumber) % 26; //Caesar shift
        echo $rotors[2][$alphabet2[$rotors[1][$alphabet2[$rotors[0][$r]]]]]; //Apply the 3 rotors  
    } else {
        $r = strpos($rotors[0], $alphabet[strpos($rotors[1], $alphabet[strpos($rotors[2], $letter)])]); //Apply the 3 rotors  
        echo $alphabet[($r - $pseudoRandomNumber + 26) % 26]; //Caesar shift
    }

    $pseudoRandomNumber = ($pseudoRandomNumber + 1) % 26;
}
?>
