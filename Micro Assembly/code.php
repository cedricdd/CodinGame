<?php 

fscanf(STDIN, "%d %d %d %d", $a, $b, $c, $d);
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $instructions[] = stream_get_line(STDIN, 16 + 1, "\n");
}

function getValue($n) {
    global $a, $b, $c, $d;
    return (is_numeric($n)) ? $n : $$n;
}

for($i = 0; $i < $n; ++$i) {
    $inst = explode(" ", $instructions[$i]);

    switch($inst[0]) {
        case "MOV":
            ${$inst[1]} = getValue($inst[2]);
            break;
        case "ADD":
            ${$inst[1]} = getValue($inst[2]) + getValue($inst[3]);
            break;
        case "SUB":
            ${$inst[1]} = getValue($inst[2]) - getValue($inst[3]);
            break;
        case "JNE":
            if(${$inst[2]} != getValue($inst[3])) $i = $inst[1] - 1;
            break;
    }
}

echo $a . " " . $b . " " . $c . " " . $d;
?>
