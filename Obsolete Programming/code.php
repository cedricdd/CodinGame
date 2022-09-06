<?php

$stack = [];
$definedInstructions = [];

//Extract & save the defined instructions
function getDefinedInstruction(string &$instructions, array &$definedInstructions): void {

    if(preg_match_all("/DEF ([A-Z0-9]+) ([A-Z0-9 ]+?) END/", $instructions, $matches)) {
        //Save the defined instruction & remove it from string
        for($i = 0; $i < count($matches[0]); ++$i) {
            $definedInstructions[$matches[1][$i]] = explode(" ", $matches[2][$i]);
            $instructions = str_replace($matches[0][$i], "", $instructions);
        }
    }

    //Remove multiple spaces created by the removal of defined instructions
    $instructions = trim(preg_replace("/\s{2,}/", " ", $instructions));
}

//Parse an array of instructions
function parseInstructions(array $instructions): void {
    global $stack, $definedInstructions;

    if(count($instructions) == 0) return;

    for($i = 0; $i < count($instructions); ++$i) {
        $instruction = $instructions[$i];

        //Just a number, add it to the stack
        if(is_numeric($instruction)) $stack[] = $instruction;
        //Simple operation + swap
        elseif(in_array($instruction, ['ADD', 'MUL', 'SUB', 'DIV', 'MOD', 'SWP'])) {
            $right = array_pop($stack);
            $left = array_pop($stack);

            switch($instruction) {
                case "ADD": array_push($stack, $left + $right); break;
                case "MUL": array_push($stack, $left * $right); break;
                case "SUB": array_push($stack, $left - $right); break;
                case "DIV": array_push($stack, intdiv($left, $right)); break;
                case "MOD": array_push($stack, $left % $right); break;
                case "SWP": array_push($stack, $right, $left); break;
            }
        }
        //Remove the top number
        elseif($instruction == "POP") array_pop($stack);
        //Duplicate the top number
        elseif($instruction == "DUP") {
            $stack = array_values($stack); //Reset indexes
            $stack[] = $stack[count($stack) - 1];
        }
        //Bring to the top the third number of the stack
        elseif($instruction == "ROT") array_push($stack, array_splice($stack, -3, 1)[0]);
        //Copy the second top number of the stack on the top
        elseif($instruction == "OVR") array_push($stack, array_slice($stack, -2, 1)[0]);
        //Check if top number is >= 0
        elseif($instruction == "POS") array_push($stack, (array_pop($stack) >= 0) ? 1 : 0);
        //Check if top number is 0
        elseif($instruction == "NOT") array_push($stack, (array_pop($stack) == 0) ? 1 : 0);
        //Output the top number
        elseif($instruction == "OUT") echo array_pop($stack) . PHP_EOL;
        //Condition
        elseif($instruction == "IF") {
            $condition = array_pop($stack);
            $actions = [[], []];
            $index = 0;
            $count = 1;

            while(true) {
                $actions[$index][] = $instructions[++$i];

                if($instructions[$i] == "IF") ++$count; //Found a nested IF
                //Remove the ELS & increment index if the ELS isn't in a nested condition
                elseif($instructions[$i] == "ELS" && $count == 1) array_pop($actions[$index++]); 
                //If the FI isn't in a nested condition we are at the end
                elseif($instructions[$i] == "FI" && --$count == 0) {
                    array_pop($actions[$index]);
                    break;
                }
            }

            //Parse the "then" or the "else" part
            parseInstructions($actions[($condition != 0) ? 0 : 1]);
        }
        //Defined instruction
        else parseInstructions($definedInstructions[$instruction]);
    }
}

$instructions = "";
fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $instructions .= trim(fgets(STDIN)) . " ";
}

getDefinedInstruction($instructions, $definedInstructions);

parseInstructions(explode(" ", $instructions));
?>
