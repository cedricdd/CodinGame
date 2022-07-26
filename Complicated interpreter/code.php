<?php

$variables = [];
$functions = [];

//Get the value, either an int or the name of the variable with format: $name
function getValue($value) {
    global $variables;

    if(is_numeric($value)) return $value;
    else {
        $name = substr($value, 1);

        //Invalid variable name
        if(!isset($variables[$name])) exit("ERROR");
        
        return $variables[$name];
    }
}

//Check the condition of an if statement
function checkCondition($condition) {
    //Logical and operator
    if(preg_match("/^(.*) and (.*)$/", $condition, $matches)) {
        return checkCondition($matches[1]) && checkCondition($matches[2]);
    } //Logical or operator
    elseif(preg_match("/^(.*) or (.*)$/", $condition, $matches)) {
        return checkCondition($matches[1]) || checkCondition($matches[2]);
    } //Not equal operator
    elseif(preg_match("/^(.*) != (.*)$/", $condition, $matches)) {
        return getValue($matches[1]) != getValue($matches[2]);
    } //Equality operator
    elseif(preg_match("/^(.*) == (.*)$/", $condition, $matches)) {
        return getValue($matches[1]) == getValue($matches[2]);
    } //Just a variable
    else return getValue($condition);
}

//Evaluate an instruction
function evaluate(string $instruction): void {
    global $variables, $functions;

    //This instruction is a comment, ignoring
    if(preg_match("/^\/\/.*$/", $instruction)) return;
    //Executes body for x amount of times
    elseif(preg_match("/^loop ([0-9]+) do (.*)$/", $instruction, $matches)) {
        for($i = 0; $i < $matches[1]; ++$i) evaluate($matches[2]);
    } 
    //If the condition given is true, execute the body, otherwise skip it
    elseif(preg_match("/^if (.*) then (.*)$/", $instruction, $matches)) {

        if(checkCondition($matches[1])) evaluate($matches[2]);
    } 
    //Creating a function 
    elseif(preg_match("/^([a-z]+) function (.*)$/", $instruction, $matches)) $functions[$matches[1]] = $matches[2];
    //Calling a function
    elseif(preg_match("/^([a-z]+)\(\)$/", $instruction, $matches)) {
        //Invalid function name
        if(!isset($functions[$matches[1]])) exit("ERROR");

        evaluate($functions[$matches[1]]);
    }
    //Deleting variable from memory
    elseif(preg_match("/^delete ([a-z]+)/", $instruction, $matches)) unset($variables[$matches[1]]);
    //Perform an operation (+ - *)
    elseif(preg_match('/^([a-z]+) (add|sub|mult) ([0-9]+|\$[a-z]+)$/', $instruction, $matches)) {
        $value = getValue($matches[3]);
        
        switch($matches[2]) {
            case "add":  $variables[$matches[1]] += $value; break;
            case "sub":  $variables[$matches[1]] -= $value; break;
            case "mult": $variables[$matches[1]] *= $value; break;
        }
    }  
    //Assigning value to variables
    elseif(preg_match('/^([a-z]+) = ([0-9]+|\$[a-z]+)$/', $instruction, $matches)) $variables[$matches[1]] = getValue($matches[2]);
}

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $line = stream_get_line(STDIN, 1024 + 1, "\n");

    preg_match_all('/\/\/.*$|loop [0-9]+ do .*|if .* then .*|[a-z]+ function .*|[a-z]+\(\)|delete [a-z]+|[a-z]+ (?:add|sub|mult) (?:[0-9]+|\$[a-z]+)|[a-z]+ = (?:[0-9]+|\$[a-z]+)|print/', $line, $matches);

    foreach($matches[0] as $match) {
        //Stop execution and print the variables
        if($match == "print") {
            echo implode(" ", $variables);
            exit();
        } else evaluate($match);
    }
}
?>
