<?php

fscanf(STDIN, "%d %d", $height, $width);
fscanf(STDIN, "%d", $t);

$field = array_fill(0, $height, array_fill(0, $width, "C"));
$cols = array_fill(0, $width, $height - 1);
$perimeter = ($width + $height) * 2;

foreach(explode(" ", trim(fgets(STDIN))) as $value) {
    $value -= 1; //Input values are not 0 based

    //Check the 4 adjacents positions
    foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
        $checkX = $value + $xm;
        $checkY = $cols[$value] + $ym;

        //If we are outside of the field of there's no carrot perimeter decrease, otherwise it increase
        if($checkX < 0 || $checkX >= $width || $checkY < 0 || $checkY >= $height || $field[$checkY][$checkX] == "X") --$perimeter;
        else ++$perimeter;
    }
    
    $field[$cols[$value]--][$value] = "X"; //Update field and the Y position for the column

    echo $perimeter . PHP_EOL;
}
