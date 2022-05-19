<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

 //Code would no work with input signals > 64 characters as it be above the max int value

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%d", $m);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s %s", $inputName, $inputSignal);
    $inputs[$inputName] = [bindec(strtr($inputSignal, "-_", 10)), strlen($inputSignal)];
}
error_log(var_export(PHP_FLOAT_MAX , true));

for ($i = 0; $i < $m; $i++) {
    fscanf(STDIN, "%s %s %s %s", $outputName, $type, $inputName1, $inputName2);
    $outputs[$outputName] = [$type, $inputName1, $inputName2];
}

foreach($outputs as $name => $output) {
    list($type, $i1, $i2) = $output;

    switch($type) {
        case "AND": $result = $inputs[$i1][0] & $inputs[$i2][0];
            break;
        case "OR": $result = $inputs[$i1][0] | $inputs[$i2][0];
            break;
        case "XOR": $result = $inputs[$i1][0] ^ $inputs[$i2][0];
            break;
        case "NAND": $result = ~($inputs[$i1][0] & $inputs[$i2][0]);
            break;
        case "NOR": $result = ~($inputs[$i1][0] | $inputs[$i2][0]);
            break;
        case "NXOR": $result = ~($inputs[$i1][0] ^ $inputs[$i2][0]);
            break;
    }

    $result = decbin($result);

    //Result can be too big or too small based on operation
    $result = substr($result, $inputs[$i2][1] * -1); //Too big
    $result = str_pad($result, $inputs[$i2][1], '_', STR_PAD_LEFT); //Too small

    echo $name . " " . strtr($result, 10, "-_") . "\n";
}
?>
