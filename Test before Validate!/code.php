<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++)
{
    $actions[trim(fgets(STDIN))] = [];
}

fscanf(STDIN, "%d", $nbOrders);
for ($i = 0; $i < $nbOrders; $i++) {
    [$a, $b, $c] = explode(" ", trim(fgets(STDIN)));

    if($b == "before") [$c, $a] = [$a, $c];

    $actions[$a][$c] = 1; //We know $a needs $c to be done

    foreach($actions as $name => $list) {
        //If that action requieres $a
        if(isset($list[$a])) {
            $actions[$name][$c] = 1; //The action also requieres $c

            //The action requieres everything that requered to do $c
            foreach($actions[$c] as $d => $filler) $actions[$name][$d] = 1;
        }
    }
}

while(count($actions)) {
    foreach($actions as $name => $list) {
        //We do the first actions that doesn't requier anything else
        if(count($list) == 0) {
            echo $name . PHP_EOL;
            unset($actions[$name]);

            //Remove this action everywhere it was requiered
            foreach($actions as &$list2) unset($list2[$name]);

            continue 2;
        }
    }
}
