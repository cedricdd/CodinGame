<?php

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $value);

$gates = explode(" ", trim(fgets(STDIN)));
$values = explode(" ", trim(fgets(STDIN)));

foreach($gates as $i => $gate) {
    switch($gate) {
        case 'NOT':
            $value ^= 1;
            break;
        case 'BUFFER':
            break;
        case 'AND':
            $value &= $values[$i];
            break;
        case 'NAND':
            $value = ($value & $values[$i]) ^ 1;
            break;
        case 'OR':
            $value |= $values[$i];
            break;
        case 'NOR':
            $value = ($value | $values[$i]) ^ 1;
            break;
        case 'XOR':
            $value ^= $values[$i];
            break;
        case 'XNOR':
            $value = $value == $values[$i] ? 1 : 0;
            break;
        default:
            die("$gate not supported");
    }
}

echo $value . PHP_EOL;
