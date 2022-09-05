<?php

fscanf(STDIN, "%d", $n);

$numbers = array_fill(1, 90, ["lines" => [], "cards" => []]);
$cardNumbersLeft = array_fill(0, $n, 24); //Number not called on each cards
$lineNumbersLeft = []; //Number not called on each lines

for ($i = 0; $i < $n; $i++) {
    $lineNumbersLeft = array_merge($lineNumbersLeft, [5, 5, 4, 5, 5, 5, 5, 4, 5, 5, 4, 4]);
    
    for ($y = 0; $y < 5; $y++) {
        foreach(fgetcsv(STDIN, 0, " ") as $x => $number) {
            if($x == 2 && $y == 2) continue;

            $numbers[$number]["lines"][] = $i * 12 + $y; //Row
            $numbers[$number]["lines"][] = $i * 12 + 5 + $x; //Col

            if($x == $y) $numbers[$number]["lines"][] = $i * 12 + 10; //Diagonal 1
            if($x + $y == 4) $numbers[$number]["lines"][] = $i * 12 + 11; //Diagonal 2

            $numbers[$number]["cards"][] = $i; //Card
        }
    }
}

$lineFound = false;

foreach(fgetcsv(STDIN, 0, " ") as $step => $number) {

    //If there's no full line yet
    if($lineFound == false) {
        //Update all the lines that have this number
        foreach($numbers[$number]["lines"] as $line) {
            //All the numbers of the line have been called
            if(--$lineNumbersLeft[$line] == 0) {
                echo ($step + 1) . PHP_EOL;
                $lineFound = true;
                break;
            }
        }
    }

    //Update all the cards that have this number
    foreach($numbers[$number]["cards"] as $card) {
        //All the numbers of the card have been called
        if(--$cardNumbersLeft[$card] == 0) {
            echo ($step + 1) . PHP_EOL;
            break 2;
        }
    }
}
?>
