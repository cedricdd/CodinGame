<?php

$dict = [];
for($i = 32; $i <= 126; ++$i) $dict[] = chr($i);

$message = trim(fgets(STDIN));
fscanf(STDIN, "%s", $word);

for($i = 1; $i < 95; ++$i) {
    //Create the cypher based on this key
    $cypher = array_combine($dict, array_slice($dict, -$i, null, true) + array_slice($dict, 0, -$i, true));
    $decrypted = strtr($message, $cypher); //Decrypt the message

    //If the decrypted message contains the word it's the proper key
    if(preg_match("/(^|[\s\,\.\?\;\:\!])" . $word . "([\s\,\.\?\;\:\!]|$)/", $decrypted)) {
        echo $i . PHP_EOL . $decrypted . PHP_EOL;
        break;
    }
}
