<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %s %s", $o, $a1, $a2);
    $inputs[] = [$o, $a1, $a2];
}

function compute($i) {
    //We have already computed this value
    if(isset($values[$i])) return $values[$i];

    global $values, $inputs;

    list($operation, $left, $right) = $inputs[$i];

    if($left[0] == "$") { //Reference
        $index = ltrim($left, "$");
        $left = $values[$index] ?? compute($index);
    } 

    if($right[0] == "$") { //Reference
        $index = ltrim($right, "$");
        $right = $values[$index] ?? compute($index);
    } 
  
    switch($operation) {
        case "VALUE":
            $value = $left;
            break;
        case "ADD":
            $value = $left + $right;
            break;
        case "SUB":
            $value = $left - $right;
            break;
        case "MULT":
            $value = $left * $right;
            break;
    } 
    
    $values[$i] = $value; //Save value so we can directly re-use
    return $value;
}

for ($i = 0; $i < $N; $i++) {
    echo compute($i) . "\n";
}
?>
