<?php

$formula = stream_get_line(STDIN, 1000 + 1, "\n");

$formula = str_replace("XOR", "^", $formula);
$formula = str_replace("AND", "&", $formula);
$formula = str_replace("OR", "|", $formula);

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s %s", $name, $value);

    $formula = str_replace($name, $value == "TRUE" ? 1 : 0, $formula);
}

if(eval("return " . str_replace("X", "1", $formula) . ";") || eval("return " . str_replace("X", "0", $formula) . ";")) echo "Satisfiable" . PHP_EOL;
else echo "Unsatisfiable" . PHP_EOL;
