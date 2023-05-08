<?php

$skip = false;
$body = false;

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    preg_match_all("/[^;]+(?:;\n?|$)/", fgets(STDIN), $matches);

    foreach($matches[0] as $match) {
        if(stripos(trim($match), "BEGIN") === 0) $body = true; //Start body of function
        if(stripos(trim($match), "END") === 0) $body = false; //End body of function
        if($body == false && preg_match("/^\s?INSERT\s/i", $match)) $skip = true; //Start of normal insert statement

        if($skip == false) echo $match;

        if($skip == true && strpos($match, ";") !== false) $skip = false; //End of instert statement
    }
}
