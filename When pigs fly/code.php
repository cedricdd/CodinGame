<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $truths[] = trim(fgets(STDIN));
}

error_log(var_export($truths, 1));

$fullMatch = true;
$infos = ["PIGS" => 1]; //We can merge objects, traits & abilities because there's no overlap in names
$are = ["PIGS" => 1];
$have = [];
$can = [];

while(true) {
    error_log("starting cheks");

    $foundInfo = false;

    foreach($truths as $index => $thruth) {

        if(preg_match("/^([A-Z]+)(?: with ([A-Z]+))?(?: and ([A-Z]+))?(?: that can ([A-Z]+))? (?:are|can|have) ([A-Z]+)(?: with ([A-Z]+))?(?: that can ([A-Z]+))?$/", $thruth, $match)) {

            $left = true;
            $leftInfo = [];
            $right = true;
            $rightInfo = [];

            //Check everything on the left
            for($i = 1; $i <= 4; ++$i) {
                if(!empty($match[$i])) {
                    $leftInfo[$match[$i]] = 1;
                    if(!isset($infos[$match[$i]])) $left = false;
                } 
            }
            //Check everything on the right
            for($i = count($match) - 1; $i > 4; --$i) {
                if(!empty($match[$i])) {
                    $rightInfo[$match[$i]] = 1;
                    if(!isset($infos[$match[$i]])) $right = false;
                } 
            }

            if(!$fullMatch && $right) {
                $infos += $leftInfo;
                $foundInfo = true;
    
                unset($truths[$index]);
            }

            if($left) {
                $infos += $rightInfo;
                $foundInfo = true;
    
                unset($truths[$index]);
            }
        }
    }

    if(isset($infos["FLY"])) {
        if($fullMatch) exit("All pigs can fly");
        else exit("Some pigs can fly");
    }

    if($foundInfo) continue; //We re-check to find more info

    //Switch to 'some'
    if($fullMatch) {
        error_log("switching to some");

        $fullMatch = false;
        $foundInfo = true;
    } else exit("No pigs can fly");

};
