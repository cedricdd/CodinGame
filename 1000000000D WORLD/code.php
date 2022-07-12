<?php

$a = explode(" ", stream_get_line(STDIN, 1000 + 1, "\n"));
$b = explode(" ", stream_get_line(STDIN, 1000 + 1, "\n"));

$result = 0;
$c1 = 0;
$c2 = 0;

while(count($a) || count($b)) {
    //We load next values of a
    if($c1 == 0) {
        $c1 = array_shift($a);
        $v1 = array_shift($a);
    }
    //We load next values of b
    if($c2 == 0) {
        $c2 = array_shift($b);
        $v2 = array_shift($b);
    }

    $min = min($c1, $c2);

    $result += ($v1 * $min * $v2);
    $c1 -= $min;
    $c2 -= $min;
}

echo $result;
?>
