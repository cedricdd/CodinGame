<?php

$powers = [];
$cells = [];
$total = 0;

function growCells(array &$powers, array &$cells, int &$total, int $max): void {

    $keys = array_keys($powers);
    $maxPower = max($keys);
    $minPower = min($keys);

    //Vat is full, time to eat the weak
    if($total == $max) {
        //Nothing to eat
        if($maxPower == $minPower) return;

        foreach($powers[$maxPower] as $nameMax) {

            $value = intdiv($cells[$nameMax], 10);
            
            foreach($powers[$minPower] as $nameMin) {
                //The cell needs to have enough to be eaten (can't go below 0)
                if($cells[$nameMin] >= $value) {
                    $cells[$nameMin] -= $value;
                    $cells[$nameMax] += $value;
    
                    continue 2; //A cell can only eat one other cell each time
                }
            }
        }
    } //There's still some space in the vat
    else {
        //Enough space for every cells to double
        if($total * 2 <= $max) {
            foreach($cells as &$value) $value *= 2;
            $total *= 2;
        } //Split the remaining space among the higher power cells 
        else {
            $addedValue = intdiv($max - $total, count($powers[$maxPower])); 

            foreach($powers[$maxPower] as $name) {
                $value = min($cells[$name], $addedValue);
                $total += $value;
                $cells[$name] += $value;
            }
        }
    }
}

fscanf(STDIN, "%d %d", $max, $duration);
for ($cycle = 1; $cycle <= $duration; $cycle++) {
    //Cells that are already in the vat are growing
    if($cycle > 1) growCells($powers, $cells, $total, $max);

    fscanf(STDIN, "%s %d %d", $name, $initialCount, $power);

    if($name == "STOP!") break; //We got the STOP instruction, ending

    if($initialCount == 0) continue; //We ignore instruction with initial count being 0

    if($total + $initialCount > $max) die("OVERFLOW!"); //Scientist gone mad, vat overflows

    $powers[$power][] = $name;
    $cells[$name] = $initialCount;
    $total += $initialCount;
}

if($max - $total) echo "EMPTY: " . ($max - $total) . PHP_EOL;

//Show the status of each cells
foreach($cells as $name => $value) {
    echo $name . ": " . $value . PHP_EOL;
}
?>
