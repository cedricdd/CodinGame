<?php

$acc = 0;
$dat = 0;
$outputs = [];
$jumps = [];

//Set data into a register
function setData(string $destination, int $value): void {
    global $acc, $dat, $outputs;

    $value = max(-999, min(999, $value));

    switch($destination) {
        case "x1": $outputs[] = $value; break;
        case "dat": $dat = $value; break;
        case "acc": $acc = $value; break;
    }
}

//Return the corresponding data
function getData(string $source): int {
    global $acc, $dat, $inputs;

    switch($source) {
        case "x0": return array_shift($inputs);
        case "dat": return $dat;
        case "acc": return $acc;
        default: return intval($source);
    }
}

fscanf(STDIN, "%d", $k);

$inputs = explode(" ", trim(fgets(STDIN)));

fscanf(STDIN, "%d", $n);

for ($i = 0; $i < $n; $i++) {
    $line = trim(fgets(STDIN));

    //This line contains a label
    if(preg_match("/([a-z_]+):(.*)/", $line, $matches)) {
        $jumps[$matches[1]] = $i;
        $instructions[] = trim($matches[2]);

    } else $instructions[] = $line;
}

$conditional = 0;
$index = 0;

while($index < $n) {
    $code = $instructions[$index];

    //It's just a comment, we have nothing to do
    if(empty($code) || $code[0] == "#") {
        $index++;
        continue;
    } //It's a one time instruction 
    elseif($code[0] == "@") {
        $instructions[$index] = "";
        $code = substr($code, 2);
    } //Conditional execution +
    elseif(($code[0] == "+" && $conditional == 1) || ($code[0] == "-" && $conditional == -1)) {
        $code = substr($code, 2);
    }
    
    //If the value in acc is 0, store a value of 100 in acc. Otherwise, store a value of 0 in acc
    if($code == "not") {
        setData("acc", (getData("acc") == 0 ? 100 : 0));
    } //Addition, multiplication or substraction
    elseif(preg_match("/^(add|mul|sub) (.*)$/", $code, $matches)) {
        $l = getData("acc");
        $r = getData($matches[2]);

        switch($matches[1]) {
            case "add": $value = $l + $r; break;
            case "mul": $value = $l * $r; break;
            case "sub": $value = $l - $r; break;
        }

        setData("acc", $value);
    } //Jump to the instruction following the specified label
    elseif(preg_match("/^jmp ([a-z_]*)$/", $code, $matches)) {
        $index = $jumps[$matches[1]];
        continue;
    } //Copy the value of the first operand into the second operand
    elseif(preg_match("/^mov (.*) (.*)$/", $code, $matches)) {
        setData($matches[2], getData($matches[1]));
    } //Branching instructions
    elseif(preg_match("/^(teq|tgt|tlt|tcp) (.*) (.*)$/", $code, $matches)) {
        $l = getData($matches[2]);
        $r = getData($matches[3]);

        switch($matches[1]) {
            case "teq": $conditional = ($l == $r) ? 1 : -1; break;
            case "tgt": $conditional = ($l > $r) ? 1 : -1; break;
            case "tlt": $conditional = ($l < $r) ? 1 : -1; break;
            case "tcp": $conditional = $l <=> $r; break;
        }
    } //Isolate the specified digit of the value in the acc register and stores it in the acc register
    elseif(preg_match("/^dgt (.*)$/", $code, $matches)) {
        $value = str_pad(strrev(strval(getData("acc"))), 3, "0");
        $value = $value[getData($matches[1])];

        setData("acc", intval(strrev($value)));
    } //Isolate the digit of acc specified by the first operand and set it to the value of the second operand
    elseif(preg_match("/^dst (.*) (.*)$/", $code, $matches)) {
        $value = str_pad(strrev(strval(getData("acc"))), 3, "0");
        $value[getData($matches[1])] = getData($matches[2]);

        setData("acc", intval(strrev($value)));
    }

    ++$index;
}

echo implode(" ", $outputs) . PHP_EOL;
