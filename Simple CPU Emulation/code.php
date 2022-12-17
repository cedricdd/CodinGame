<?php

$registers = [0, 0, 0];
$skip = false;

foreach(str_split(trim(fgets(STDIN)), 4) as $opcode) {

    if($skip == true) {
        $skip = false;
        continue;
    }
    elseif($opcode[0] == "0") break;
    elseif($opcode[0] == "1") $registers[$opcode[1]] = hexdec(substr($opcode, 2));
    elseif($opcode[0] == "2") {
        $value = $registers[$opcode[2]] + $registers[$opcode[3]];

        if($value > 255) {
            $registers[2] = 1;
            $value %= 256;
        } else $registers[2] = 0;

        $registers[$opcode[2]] = $value;
    } elseif($opcode[0] == "3") {
        $registers[2] = ($registers[$opcode[2]] < $registers[$opcode[3]]);

        $registers[$opcode[2]] = $registers[$opcode[2]] - $registers[$opcode[3]];
        if($registers[$opcode[2]] < 0) $registers[$opcode[2]] += 256;
    } elseif($opcode[0] == "4") {
        $registers[$opcode[2]] |= $registers[$opcode[3]];
    } elseif($opcode[0] == "5") {
        $registers[$opcode[2]] &= $registers[$opcode[3]];
    } elseif($opcode[0] == "6") {
        $registers[$opcode[2]] ^= $registers[$opcode[3]];
    } elseif($opcode[0] == "7") {
        if($registers[$opcode[1]] == hexdec(substr($opcode, 2))) $skip = true;
    } elseif($opcode[0] == "8") {
        if($registers[$opcode[1]] != hexdec(substr($opcode, 2))) $skip = true;
    } elseif($opcode[0] == "9") {
        if($registers[$opcode[2]] == $registers[$opcode[3]]) $skip = true;
    } elseif($opcode[0] == "A") {
        if($registers[$opcode[2]] != $registers[$opcode[3]]) $skip = true;
    }
}

echo implode(" ", $registers) . PHP_EOL;
