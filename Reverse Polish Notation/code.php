<?php

fscanf(STDIN, "%d", $N);
$stack = [];

foreach(explode(" ", trim(fgets(STDIN))) as $instruction) {
    //Adding number to stack
    if(is_numeric($instruction)) {
        $stack[] = intval($instruction);
    } else {
        error_log(var_export($stack, true));

        $right = array_pop($stack);
        $left = array_pop($stack);

        //Not enough operands 
        if($left === null || $right === null) {
            $stack[] = "ERROR";
            break;
        }
        //Division by 0
        if(($instruction == "DIV" || $instruction == "MOD") && $right == 0) {
            $stack[] = "ERROR";
            break;
        }
        //Trying to rol an element that doesn't exist
        if($instruction == "ROL") {
            array_push($stack, $left);
            if(count($stack) < $right) {
                $stack[] = "ERROR";
                break;
            }
        }

        //Apply the operation
        switch($instruction) {
            case "ADD":
                array_push($stack, $left + $right); break;
            case "MUL":
                array_push($stack, $left * $right); break;
            case "SUB":
                array_push($stack, $left - $right); break;
            case "DIV":
                array_push($stack, intdiv($left, $right)); break;
            case "MUL":
                array_push($stack, $left % $right); break;
            case "POP":
                array_push($left); break;
            case "DUP":
                array_push($stack, $left, $right, $right); break;
            case "SWP":
                array_push($stack, $right, $left); break;
            case "ROL":
                $index = count($stack) - $right;
                array_push($stack, $stack[$index]); 
                unset($stack[$index]);
                $stack = array_values($stack); //Reset indexes
                break;
        }
    }
}

echo implode(" ", $stack) . PHP_EOL;
?>
