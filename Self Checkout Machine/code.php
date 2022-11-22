<?php

$jam = [];
$machine = array_fill_keys([50, 20, 10, 5, 2, 1, '0.50', '0.20', '0.10', '0.05', '0.02', '0.01'], 0);

foreach(explode("+", trim(fgets(STDIN))) as $input) {
    [$count, $denomination] = explode("X", $input);

    if($count[-1] == "J") $jam[$denomination] = 1;
    else $machine[$denomination] = intval($count);
}

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%f %s", $bill, $given);

    $toReturn = -$bill;

    foreach(explode("+", $given) as $input) {
        [$count, $denomination] = explode("X", $input);
        $toReturn += $count * $denomination;
        $machine[$denomination] += $count; //Increase the count of this denomination 
    }

    //Floating presicion isn't perfect, some values could be wrong, using cents to work with integers
    $toReturn = round($toReturn * 100);

    //We have nothing to return
    if($toReturn == 0) {
        echo "0" . PHP_EOL;
        continue;
    }

    $answer = [];

    foreach($machine as $denomination  => &$value) {
        if($value == 0 || $denomination  * 100 > $toReturn) continue;

        //The machine gets jammed
        if(isset($jam[$denomination ])) die("ERROR: JAM");

        //How many of this denomination we are gonna use
        $valueReturned = min($value, intdiv($toReturn, $denomination  * 100));

        $answer[] = $valueReturned . "X" . $denomination ;

        $toReturn -= ($valueReturned * ($denomination  * 100)); //What's left to return
        $value -= $valueReturned; //Decrease the count of this denomination 
    }

    //Not enough money left
    if($toReturn != 0) die("ERROR: OUT OF MONEY");

    echo implode("+", $answer) . PHP_EOL; 
}
