<?php

fscanf(STDIN, "%d %d", $value, $n);

while($n--) {
    $binary = decbin($value); //Convert to binary 
    $next = substr_count($binary, '1')  * 3 + substr_count($binary, '0')  * 4; //Letters of the spelled out number

    //We are converging to a fixed value way faster than the number of most steps, we can stop as soon as the value repeat itself
    if($next == $value) break;
    else $value = $next;
}

echo $value;
?>
