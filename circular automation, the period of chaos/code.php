<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem string.
 **/

fscanf(STDIN, "%d", $lineLength);
fscanf(STDIN, "%d", $maxIter);
fscanf(STDIN, "%d", $ruleNumber);

error_log(var_export("Length: " . $lineLength, true));
error_log(var_export("Max: " . $maxIter, true));
error_log(var_export("Rule #: " . $ruleNumber, true));

$binary = str_pad(decbin($ruleNumber), 8, "0", STR_PAD_LEFT);
$rules = [
    '111' => $binary[0],
    '110' => $binary[1],
    '101' => $binary[2],
    '100' => $binary[3],
    '011' => $binary[4],
    '010' => $binary[5],
    '001' => $binary[6],
    '000' => $binary[7],
];

error_log(var_export($rules, true));

$string = str_repeat("0", intdiv($lineLength, 2)) . "1" . str_repeat("0", intdiv($lineLength, 2));

$memory[$string] = 0;

//Check for as many transformations as we can
for($iter = 1; $iter <= $maxIter; ++$iter) {
    //We add a character at the start and the end for substr
    $string = $string[$lineLength - 1] . $string . $string[0];
  
    $transformation = "";

    //Apply the rule for each character
    for($i = 1; $i <= $lineLength; ++$i) $transformation .= $rules[substr($string, $i - 1, 3)];

    //We found a repetition 
    if(isset($memory[$transformation])) {
        echo $iter - $memory[$transformation];
        exit();
    }


    $memory[$transformation] = $iter;
    $string = $transformation;
}

echo("BIG\n");
?>
