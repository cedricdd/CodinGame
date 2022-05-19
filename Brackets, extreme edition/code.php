<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

 $pair = ['(' => ')', '[' => ']', '{' => '}'];
 $stack = []; 

fscanf(STDIN, "%s", $expression);

foreach(str_split($expression) as $character) {
    switch ($character) {
        case '(':
        case '[':
        case '{':
            $stack[] = $pair[$character];
            break;
        case ')':
        case ']':
        case '}':
            $match = array_pop($stack) ?? " ";
            if($character != $match) exit("false"); 
    }
}

if(count($stack)) echo "false\n";
else echo "true\n";
?>
