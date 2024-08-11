<?php

//We are updating the combinaisons, using a relation
function updateOutput(string $header, int $index, string $characteristic, int $value) {
    global $combinaison, $headers;

    if($value == 1) {
        $combinaison[$header][$index] = [$characteristic => 1];

        foreach($headers as $header2) {
            if($header == $header2) continue;

            updateOutput($header2, $index, $characteristic, 0); //This characteristic can't be associated with anything else
        }
    } elseif(isset($combinaison[$header][$index][$characteristic])) {
        unset($combinaison[$header][$index][$characteristic]);

        //We know only have 1 characteristic left
        if(count($combinaison[$header][$index]) == 1) {
            updateOutput($header, $index, array_key_first($combinaison[$header][$index]), 1);
        }
    }
}

//We know that $a is not associated with $b
function isNotWith(array &$characteristics, string $a, string $b) {
    if(isset($characteristics[$a][$b])) return;
    else $characteristics[$a][$b] = 0;

    foreach($characteristics[$b] as $c => $value) {
        if($c == $a) continue;

        //Everything associated with $b will also NOT be associatd with $a
        if($value == 1) {
            isNotWith($characteristics, $a, $c);
            isNotWith($characteristics, $c, $a);
        }
    }
}

//We know that $a is associated with $b
function isWith(array &$characteristics, string $a, string $b) {
    if(isset($characteristics[$a][$b])) return;
    else $characteristics[$a][$b] = 1;

    foreach($characteristics[$b] as $c => $value) {
        if($c == $a) continue;

        //Everything associated with $b will also BE associatd with $a
        if($value == 1){
            isWith($characteristics, $a, $c);
            isWith($characteristics, $c, $a);
        } //Everything NOT associated with $b will also NOT be associatd with $a
        else {
            isNotWith($characteristics, $a, $c);
            isNotWith($characteristics, $c, $a);
        }
    }
}

$start = microtime(1);

$history = [];
$forbidden = [];
$indexes = [];
$characteristics = [];

fscanf(STDIN, "%d %d", $nbCharacteristics, $nbPeople);
for ($i = 0; $i < $nbCharacteristics; $i++) {

    $info = explode(" ", trim(fgets(STDIN)));

    foreach($info as $characteristic) {
        $characteristics[$characteristic] = [];
        $indexes[$characteristic] = $i - 1;
    }

    $infos[] = array_flip($info);
}

fscanf(STDIN, "%d", $nbLinks);
for ($i = 0; $i < $nbLinks; $i++) {
    preg_match("/(.*) ([&!]) (.*)/", trim(fgets(STDIN)), $link);

    [, $a, $op, $b] = $link;

    if($op == '&') {
        isWith($characteristics, $a, $b);
        isWith($characteristics, $b, $a);
    }
    else {
        isNotWith($characteristics, $a, $b);
        isNotWith($characteristics, $b, $a);
    }
}

//We use the first category as header
$headers = array_keys(array_shift($infos));
$default = array_fill(0, $nbPeople, $infos);
$combinaison = array_combine($headers, $default);

ksort($combinaison);

foreach($headers as $header) {
    foreach($characteristics[$header] as $characteristic => $value) {
        //We use every relations we know with the header
        updateOutput($header, $indexes[$characteristic], $characteristic, $value);
    }
}

while(true) {
    $finished = true;
    $improved = false;
    $failed = false;

    foreach($combinaison as $header => $list) {
        foreach($list as $index => $possibilities) {
            $count = count($possibilities);

            //We have nothing left, one of the guess we make was wrong
            if($count == 0) {
                $failed = true;
                break 2;
            } elseif($count > 1) {
                foreach($possibilities as $possibility => $filler) {
                    //Check if we can drop the possibility
                    foreach($characteristics[$possibility] as $characteristic => $value) {
                        $index2 = $indexes[$characteristic];

                        //We need this characteristic
                        if($value == 1 && !isset($combinaison[$header][$index2][$characteristic])) {
                            updateOutput($header, $index, $possibility, 0); //We can drop that characteristic

                            $improved = true;
                        }
                        
                        //We can't have this characteristic as certain
                        if($value == 0 && isset($combinaison[$header][$index2][$characteristic]) && count($combinaison[$header][$index2]) == 1) {
                            updateOutput($header, $index, $possibility, 0); //We can drop that characteristic

                            $improved = true;
                        }
                    }

                    //If we can't use that characteristic anywhere else, it has to go here
                    foreach($headers as $header2) {
                        if($header == $header2) continue;

                        if(isset($combinaison[$header2][$index][$possibility])) continue 2;
                    }

                    updateOutput($header, $index, $possibility, 1); //We can drop that characteristic

                    $improved = true;
                }

                if(count($possibilities) > 1) $finished = false;
            }
        }
    }

    if($finished) break;
    elseif($failed) { //We need to reload and make another guess
        [$combinaison, $forbidden] = array_pop($history);
        $improved = false;
    }
    
    //We need to make a guess
    if(!$improved) {
        foreach($combinaison as $headerName => $list) {
            foreach($list as $index => $possibilities) {
                //We can make a guess here
                if(count($possibilities) > 1) {
                    foreach($possibilities as $possibility => $filler) {
                        if(!isset($forbidden[$headerName][$possibility])) {
                            $forbidden[$headerName][$possibility] = 1;

                            $history[] = [$combinaison, $forbidden];

                            updateOutput($headerName, $index, $possibility, 1); //We can drop that characteristic

                            break 3;
                        }
                    }
                    
                }
            }
        }
    }
}

$output[] = implode(" ", array_keys($combinaison));

for($i = 0; $i < $nbCharacteristics - 1; ++$i) {
    $output[] = implode(" ", array_map("array_key_first", array_column($combinaison, $i)));
}

echo implode("\n", $output);

error_log("\n" . (microtime(1) - $start));
