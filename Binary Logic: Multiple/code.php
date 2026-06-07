<?php

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $value);

$gates = explode(" ", trim(fgets(STDIN)));
$operands = explode(" ", trim(fgets(STDIN)));

foreach($gates as $i => $gate) {
    switch($gate) {
        case "BUFFER": break;
        case "NOT": $value = !$value; break;
        case "AND": $value &= $operands[$i]; break;
        case "NAND": $value = !($value & $operands[$i]); break;
        case "OR": $value |= $operands[$i]; break;
        case "NOR": $value = !($value | $operands[$i]); break;
        case "XOR": $value ^= $operands[$i]; break;
        case "XNOR": $value = !($value ^ $operands[$i]); break;
        default: die("Unsuported gate: $gate");
    }
}

echo ($value ? 1 : 0) . PHP_EOL;
