<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $expression = preg_replace('/[a-zA-Z0-9]/', '', stream_get_line(STDIN, 10000 + 1, "\n"));

    error_log(var_export($expression, true));

    $cmp = "";
    while($expression != $cmp) {
        $cmp = $expression;
        $expression = strtr($expression, [
            '()' => '', 
            '((' => '', 
            '))' => '', 
            ')(' => '', 
            '[]' => '',
            '[[' => '',
            ']]' => '',
            '][' => '', 
            '{}' => '',
            '{{' => '',
            '}}' => '',
            '}{' => '', 
            '<>' => '',
            '>>' => '',
            '<<' => '',
            '><' => '']);
    }

    if(strlen($expression)) echo "false\n";
    else echo "true\n";
}
?>
