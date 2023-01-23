function getPerimeter(array $field): int {
    global $width, $height;

    $perimeter = 0;

    for($y = 0; $y < $height; ++$y) {
        for($x = 0; $x < $width; ++$x) {
            if($field[$y][$x] != "C") continue; //Skip if it's not a carrot

            //Check the 4 adjacents positions
            foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
                $checkX = $x + $xm;
                $checkY = $y + $ym;

                //If we are outside of the field of there's no carrot we increase perimeter
                if($checkX < 0 || $checkX >= $width || $checkY < 0 || $checkY >= $height || $field[$checkY][$checkX] == "X") ++$perimeter;
            }
        }
    }

    return $perimeter;
}

fscanf(STDIN, "%d %d", $height, $width);
fscanf(STDIN, "%d", $t);

$field = array_fill(0, $height, array_fill(0, $width, "C"));
$cols = array_fill(0, $width, $height);

foreach(explode(" ", trim(fgets(STDIN))) as $value) {
    $value -= 1; //Input values are not 0 based
    $field[--$cols[$value]][$value] = "X"; //Remove the carrot eaten by the rabbit
    echo getPerimeter($field) . PHP_EOL;
}
