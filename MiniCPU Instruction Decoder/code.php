<?php

$program = explode(" ", stream_get_line(STDIN, 500 + 1, "\n"));
$count = count($program);
$registers = ['00' => 0, '01' => 0, '02' => 0, '03' => 0];

for($i = 0; $i < $count; ++$i) {
    error_log("$i - " . $program[$i]);

    switch($program[$i]) {
        case "01"://MOV - Load value YY into register RX
            $registers[$program[++$i]] = hexdec($program[++$i]);
            break;
        case "02"://ADD - Add register RY to register RX
            $registers[$program[++$i]] = ($registers[$program[$i]] + $registers[$program[++$i]]) % 256;
            break;
        case "03"://SUB - Subtract register RY from register RX
            $registers[$program[++$i]] = ($registers[$program[$i]] - $registers[$program[++$i]] + 256) % 256;
            break;
        case "04"://MUL - Multiply register RX by register RY
            $registers[$program[++$i]] = ($registers[$program[$i]] * $registers[$program[++$i]]) % 256;
            break;
        case "05"://INC - Increment register RX by 1
            $registers[$program[++$i]] = ($registers[$program[$i]] + 1) % 256;
            break;
        case "06"://DEC - Decrement register RX by 1
            $registers[$program[++$i]] = ($registers[$program[$i]] - 1 + 256) % 256;
            break;
        case "FF"://Halt execution
            break 2;
        default: exit("invalid command: " . $program[$i]);
    }
}

error_log(var_export($registers, 1));

echo implode(PHP_EOL, $registers);
