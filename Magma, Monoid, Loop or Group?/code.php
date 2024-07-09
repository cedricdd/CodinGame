<?php

$start = microtime(1);

fscanf(STDIN, "%d", $N);

$elements = explode(" ", trim(fgets(STDIN)));

for ($i = 0; $i < $N; $i++) {
    $input = explode(" ", trim(fgets(STDIN)));

    for($j = 1; $j <= $N; ++$j) {
        $magma[$input[0]][$elements[$j]] = $input[$j];
    }
}

$name = array_shift($elements);

$isMonoid = true;
$isGroup = true;
$identity = null;

//Check for Associativity
foreach($elements as $x) {
    foreach($elements as $y) {
        foreach($elements as $z) {
            //(x*y)*z = x*(y*z)
            if($magma[$magma[$x][$y]][$z] != $magma[$x][$magma[$y][$z]]) {
                $isMonoid = false;

                break 3;
            }
        }
    }
}

//Search the identity 
foreach($elements as $e) {
    foreach($elements as $x) {
        //e*x = x = x*e
        if($magma[$e][$x] != $x || $magma[$x][$e] != $x) continue 2;
    }

    $identity = $e;
    break;
}

//Check for Invertibility
if($identity !== null) {
    foreach($elements as $x) {
        foreach($elements as $y) {
            foreach($elements as $z) {
                //y*x = e = x*z
                if($magma[$y][$x] == $identity && $magma[$x][$y] == $identity) continue 3;
            }
        }

        $isGroup = false; 
        break;
    }
}

if($isMonoid && $isGroup) echo $name . " is a group" . PHP_EOL;
elseif($isMonoid) echo $name . " is a monoid" . PHP_EOL;
elseif($isGroup) echo $name . " is a loop" . PHP_EOL;
else echo $name . " is a magma" . PHP_EOL;

error_log(microtime(1) - $start);
