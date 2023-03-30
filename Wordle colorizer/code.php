<?php

fscanf(STDIN, "%s", $word);
fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {

    $answer = "XXXXX";
    $wordCheck = $word;
    $attempt = trim(fgets(STDIN));

    //Set good letters
    foreach(str_split($attempt) as $j => $c) {
        if($word[$j] == $c) {
            $answer[$j] = "#";
            $wordCheck[$j] = "*";
        }
    }

    //Set wrong positions
    foreach(str_split($attempt) as $j => $c) {
        if($answer[$j] == "X" && ($pos = strpos($wordCheck, $c)) !== false) {
            $answer[$j] = "O";
            $wordCheck[$pos] = "*";
        }
    }

    echo $answer . PHP_EOL;
}
