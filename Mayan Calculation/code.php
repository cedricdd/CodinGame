<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

 //We save mayan numbers as imploded string so we can easily convert with array keys
$numbers = array_fill(0, 20, "");

fscanf(STDIN, "%d %d", $L, $H);
for ($i = 0; $i < $H; $i++) {
    fscanf(STDIN, "%s", $line);

    foreach(str_split($line, $L) as $index => $value) {
        $numbers[$index] .= $value;
    }
}

error_log(var_export($numbers, true));
$numbersReverse = array_flip($numbers);

$number = "";

//The left number
fscanf(STDIN, "%d", $S1);
for ($i = 1; $i <= $S1; $i++) {
    fscanf(STDIN, "%s", $line);

    if($i % $L == 0) {
        $left[] = $number . $line;
        $number = "";
    }
    else $number .= $line;
}

//The right number
fscanf(STDIN, "%d", $S2);
for ($i = 1; $i <= $S2; $i++) {
    fscanf(STDIN, "%s", $line);

    if($i % $L == 0) {
        $right[] = $number . $line;
        $number = "";
    }
    else $number .= $line;
}

fscanf(STDIN, "%s", $operation);

//Convert a mayan number to integer
function convertToInt($array) {
    global $numbersReverse;

    $result = 0;
    
    foreach(array_reverse($array) as $i => $mayanNumber) {
        $result += $numbersReverse[$mayanNumber] * pow(20, $i);
    }

    return $result;
}

//Convert an integer to an array of mayan numbers
function convertToMaya($number) {
    global $numbers;

    //Convert base 10 to 20
    while(true) {
        $quotient = intdiv($number, 20);

        if($quotient == 0) {
            $result[] = $numbers[$number];
            break;
        } else {
            $result[] = $numbers[$number % 20];
            $number = $quotient;
        }
    } 
        
    return array_reverse($result); //The converted number is read from bottom to top
}

switch($operation) {
    case "+":
        $result = convertToInt($left) + convertToInt($right);
        break;
    case "*":
        $result = convertToInt($left) * convertToInt($right);
        break;
    case "-":
        $result = convertToInt($left) - convertToInt($right);
        break;
    case "/":
        $result = intdiv(convertToInt($left), convertToInt($right));
        break;
}

foreach(convertToMaya($result) as $mayanNumber) {
    foreach(str_split($mayanNumber, $L) as $subPart) echo $subPart . "\n";
} 
?>
