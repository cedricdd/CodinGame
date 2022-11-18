<?php

fscanf(STDIN, "%d", $N);
$pattern = stream_get_line(STDIN, 128 + 1, "\n");

//Some lines don't start with the first character of the pattern create a string that will contain all the valid lines
$string = str_repeat($pattern, ceil($N / strlen($pattern)) + 1);

for($y = 0; $y < $N; ++$y) {
    $line = trim(fgets(STDIN));

    //If the line is not found inside our control string it's the line with the error
    if(strpos($string, $line) === false) {

        //We know there's only one error, exclude character one by one until the line is found in the control string
        for($x = 1; $x < $N; $x++) {
            //The last character excluded was the error
            if(strpos($string, substr($line, $x)) !== false) {
                echo "(" . ($x - 1) . "," . $y . ")";
                continue 2;
            }
        }
    }
}
