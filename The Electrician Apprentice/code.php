<?php

fscanf(STDIN, "%d", $C);
for ($i = 0; $i < $C; $i++) {
    $wiring[] = trim(fgets(STDIN));
}

fscanf(STDIN, "%d", $A);
for ($i = 0; $i < $A; $i++) {
    $switch = trim(fgets(STDIN));

    $switches[$switch] = ($switches[$switch] ?? 0) ^ 1;
}

foreach($wiring as $string) {
    preg_match("/([^ ]+) (.*)/", $string, $matches);

    [, $name, $info] = $matches;

    $sequences = preg_split("/([-=] )/", $info, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    $status = 1;

    //Check each sequence leading to this equipment
    for($i = 0; $i < count($sequences); $i += 2) {
        $local = $sequences[$i][0] == "-" ? 1 : 0; //Serie starts ON, parallel starts as OFF

        //Check each switch in the sequence
        foreach(explode(" ", trim($sequences[$i + 1])) as $switch) {
            if($sequences[$i][0] == "-") $local &= ($switches[$switch] ?? 0);
            else $local |= ($switches[$switch] ?? 0);
        }

        $status &= $local;
    }

    echo "$name is " . ($status ? "ON" : "OFF") . PHP_EOL;
}
