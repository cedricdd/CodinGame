<?php

$index = 0;
$email = "";

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $email .= fgets(STDIN);
}

//Replace all the multiple choices
while(preg_match("/\([^\)]*\)/", $email, $match, PREG_OFFSET_CAPTURE)) {

    if(count($match) == 0) break; //Nothing left to replace

    $choices = explode("|", substr($match[0][0], 1, -1)); //List of choices

    //Replace list of choices by the "randomly" selected choice
    $email = substr_replace($email, $choices[$index++ % count($choices)], $match[0][1], strlen($match[0][0]));
}

echo $email;
