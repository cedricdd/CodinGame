<?php
fscanf(STDIN, "%d", $CP);
fscanf(STDIN, "%d", $NS);
fscanf(STDIN, "%d", $AP);

$appliances = [];
$sockets = array_fill(0, $NS, $CP);

for ($i = 0; $i < $AP; $i++) {
    $appliances[] = explode(":", trim(fgets(STDIN)));
}

//Sort by power
usort($appliances, function($a, $b) {
    return $b[1] <=> $a[1];
});

//Greedily add applicances
foreach($appliances as [$name, $power]) {
    foreach($sockets as $i => $left) {
        //We can add it to this socket
        if($left >= $power) {
            if($power >= 1000) unset($sockets[$i]); //We can't add anything else here
            else $sockets[$i] -= $power;
            continue 2;
        }
    }
}

fscanf(STDIN, "%d", $AL);

$appliances = [];

for ($i = 0; $i < $AL; $i++) {
    $appliances[] = explode(":", trim(fgets(STDIN)));
}

//Sort by power
usort($appliances, function($a, $b) {
    return $b[1] <=> $a[1];
});

$solution = "0";

foreach($appliances as [$name, $power]) {
    foreach($sockets as $i => $left) {
        //Anything with >= 1000 needs to be alone
        if(($power < 1000 || $left == $CP) && $left >= $power) {
            $solution = $name;
            break 2;
        }
    }
}

echo $solution . PHP_EOL;
