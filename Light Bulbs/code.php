<?php

$source = stream_get_line(STDIN, 255 + 1, "\n");
$target = stream_get_line(STDIN, 255 + 1, "\n");

error_log(var_export("source :" . $source, true));
error_log(var_export("target :" . $target, true));

$checked = [];

function solve($source, $target) {

    global $checked;

    //Use saved value
    if(isset($checked[$source][$target])) return $checked[$source][$target];
    
    //Both are the same, no switch needed
    if($source == $target) return $checked[$source][$target] = 0;

    $size = strlen($source);

    //Find the first difference
    for($i = 0; $i < $size; ++$i) {
        if($source[$i] != $target[$i]) {
            //Just the last bulb, we can always directly switch it
            if($i == $size - 1) return $checked[$source][$target] = 1;

            //This is state we need to be able to switch the first difference
            $intermediate = "1" . str_repeat("0", max(0, $size - $i - 2));

            return $checked[$source][$target] = 
                1 // Switching the lightbulb
                + solve(substr($source, $i + 1), $intermediate) // Reaching the state where we can switch it
                + solve($intermediate, substr($target, $i + 1)); // Take care of the rest of the sequence
        }
    }

}

echo solve($source, $target);
?>
