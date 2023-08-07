<?php

$mother = explode(" ", preg_replace("/\s{2,}/", " ", trim(fgets(STDIN))));
$child = explode(" ", preg_replace("/\s{2,}/", " ", trim(fgets(STDIN))));

fscanf(STDIN, "%d", $numOfPossibleFathers);
for ($i = 0; $i < $numOfPossibleFathers; $i++) {
    $father = explode(" ", preg_replace("/\s{2,}/", " ", trim(fgets(STDIN))));

    for($j = 1; $j < count($father); ++$j) {
        
        $motherPair = "[" . preg_replace("/([^a-zA-Z0-9])/", "\\\\$1", $mother[$j + 1]) . "]";
        $fatherPair = "[" . preg_replace("/([^a-zA-Z0-9])/", "\\\\$1", $father[$j]) . "]";

        //For each pairs of the child, check if it's valid combinaison with the current father, if not move to next potential father
        if(preg_match("/" . $motherPair . $fatherPair . "|" . $fatherPair . $motherPair . "/", $child[$j + 1]) === 0) continue 2;
    }

    exit(substr($father[0], 0, -1) . ", you are the father!");
}
