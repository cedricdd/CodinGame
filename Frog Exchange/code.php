<?php

$line = trim(fgets(STDIN));

//Females go to the right
if($line[0] == "f") {
    $regexes = [
        "/(?<!m )f (m )?s(?= m)/" => "s $1f",
        "/(?<!m )s (f )?m/" => "m $1s",
        "/f (m )?s/" => "s $1f",
        "/s (f )?m/" => "m $1s",
    ];
} //Females go to the left
else {
    $regexes = [
        "/(?<=m )s (m )?f(?! m)/" => "f $1s",
        "/m (f )?s(?= f)/" => "s $1m",
        "/s (m )?f/" => "f $1s",
        "/m (f )?s/" => "s $1m",
    ];
}

while(true) {
    echo $line . PHP_EOL;

    foreach($regexes as $regex => $update) {
        $line = preg_replace($regex, $update, $line, -1, $replaced);

        if($replaced) continue 2;
    }

    break;
}
