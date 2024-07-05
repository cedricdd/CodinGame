<?php

$analysis1 = [];
$analysis2 = [];
$circular = [];
$boats = [];

fscanf(STDIN, "%d", $n);

for ($i = 0; $i < $n; $i++) {
    $input = trim(fgets(STDIN));
    $inputSplit = preg_split("/ (is in front of|is not ahead of) /", $input, -1, PREG_SPLIT_DELIM_CAPTURE);

    if($inputSplit[1] == "is in front of") $analysis1[$inputSplit[0] . "-" . $inputSplit[2]] = [$inputSplit[0], $inputSplit[2], $input, $i];
    else $analysis2[$inputSplit[0] . "-" . $inputSplit[2]] = [$inputSplit[0], $inputSplit[2], $input, $i];

    //Check if already know these boats
    if(!isset($boats[$inputSplit[0]])) $boats[$inputSplit[0]] = 0;
    if(!isset($boats[$inputSplit[2]])) $boats[$inputSplit[2]] = 0;
}

//Check for contraditions 
foreach($analysis1 as [$a, $b, $name, $i]) {
    if(isset($analysis1[$b . "-" . $a]) || isset($analysis2[$a . "-" . $b])) $circular[$i] = $name;
}

foreach($analysis2 as [$a, $b, $name, $i]) {
    if(isset($analysis1[$a . "-" . $b]) || isset($analysis2[$b . "-" . $a])) $circular[$i] = $name;
}

//Circular reference detected
if(count($circular)) {
    ksort($circular); //Order of appearance
    
    echo implode("\n", $circular) . PHP_EOL;
}
else {
    ksort($boats, SORT_STRING | SORT_FLAG_CASE); //Display boats in alphabetical order (case-insensitive)

    do {
        $modified = false;

        //First work on all the "is in front of"
        foreach($analysis1 as [$a, $b]) {
            //$a needs to have an higher value than $b
            if($boats[$a] <= $boats[$b]) {
                $modified = true;

                $boats[$a] = $boats[$b] + 1;
            }
        }

        //The work on all the "is not ahead of"
        foreach($analysis2 as [$a, $b]) {
            //$a needs to be the same or smaller than $b
            if($boats[$a] > $boats[$b]) {
                $modified = true;

                $boats[$b] = $boats[$a];
            }
        }
    } while($modified); //Continue until all the constraints are verified

    foreach($boats as $name => $count) {
        echo implode(" ", array_merge(array_fill(0, $count, "_"), [$name])) . PHP_EOL;
    }
}
