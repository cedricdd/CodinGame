<?php

fscanf(STDIN, "%d", $target);
fscanf(STDIN, "%d", $containersCount);
for ($i = 0; $i < $containersCount; $i++) {
    fscanf(STDIN, "%d", $capacity);
    $bottles[$capacity] = 0; //Each container has a unique capacity  
}

$step = 0;
$checked = [];
$toCheck[] = $bottles;

while(true) {

    $newCheck = [];

    //Check all the solutions we can make with the current number of steps
    foreach ($toCheck as $key => $bottles) {

        //Don't re-check a configuration we already checked
        $state = implode(" ", $bottles);

        if(isset($checked[$state])) continue;
        else $checked[$state] = 1;

        foreach($bottles as $c1 => $v1) {

            if($v1 == $target) break 3;

            //There's someting in the bottle
            if($v1) {
                //Try to transert water in another bottle 
                foreach($bottles as $c2 => $v2) {
                    if($c1 == $c2 || $v2 == $c2) continue;
    
                    $space = $c2 - $v2;

                    //Amount of water we can move to the other bottle
                    $transfered = ($v1 > $space) ? $space : $v1;
    
                    $bottles[$c1] -= $transfered;
                    $bottles[$c2] += $transfered;
                    $newCheck[] = $bottles;

                    //Reset bottles
                    $bottles[$c1] += $transfered;
                    $bottles[$c2] -= $transfered;
                }

                //Empty the bottle
                $bottles[$c1] = 0;
                $newCheck[] = $bottles;

                $bottles[$c1] = $v1; //Reset bottle value
            } else {
                //Fill up the bottle
                $bottles[$c1] = $c1;
                $newCheck[] = $bottles;

                $bottles[$c1] = $v1; //Reset bottle value
            }
        }

    }

    ++$step;
    $toCheck = $newCheck;
}

echo $step . PHP_EOL;
?>
