<?php

function setValue(array &$table, array &$output, int $x, int $y, int $value) {
    global $size;

    $table[$y][$x] = $value;
    $output[$y * 2] = substr_replace($output[$y * 2], str_pad($table[$y][$x], $size, " ", STR_PAD_RIGHT), $x * ($size + 1), $size);
}

fscanf(STDIN, "%d", $h);

$start = microtime(1);
$size = 0;
$output = [];

for ($y = 0; $y < $h; $y++) {
    $output[$y] = stream_get_line(STDIN, 1000 + 1, "\n");

    if($y % 2 == 0)  {
        $inputs = explode('|', $output[$y]);

        if($y == 0) $op = trim($inputs[0]);

        foreach($inputs as $x => $input) {
            if(strlen($input) > $size) $size = strlen($input);

            $table[$y >> 1][] = intval($input);

            if(empty(trim($input))) $unknown[] = [$x, $y >> 1];
        }
    }
}

$w = count($table[0]);
$h = ceil($h / 2);

/**
 * We use eval so we make sure we don't use any substraction since we have negative numbers as eval(return x - -y;); doesn't work.
 */
while($unknown) {
    foreach($unknown as $i => [$x, $y]) {
        //topmost row
        if($y == 0) {
            for($y2 = 1; $y2 < $h; ++$y2) {
                if($table[$y2][$x] != 0 && $table[$y2][0] != 0) {

                    switch($op) {
                        case '+': $value = eval("return " . $table[$y2][$x] . "+" . ($table[$y2][0] * -1) . ";"); break;
                        case '-': $value = eval("return " . $table[$y2][$x] . "+" . $table[$y2][0] . ";"); break;
                        case 'x': $value = eval("return " . $table[$y2][$x] . "/" . $table[$y2][0] . ";"); break;
                        default: exit("invalid operation");
                    }
                    
                    setValue($table, $output, $x, $y, $value);

                    unset($unknown[$i]);
                    continue 2;
                }
            }
        }
        //leftmost column
        elseif($x == 0) {
            for($x2 = 1; $x2 < $w; ++$x2) {
                if($table[$y][$x2] != 0 && $table[0][$x2] != 0) {

                    switch($op) {
                        case '+': $value = eval("return " . $table[$y][$x2] . "+" . ($table[0][$x2] * -1) . ";"); break;
                        case '-': $value = eval("return " . $table[0][$x2] . "+" . ($table[$y][$x2] * -1) . ";"); break;
                        case 'x': $value = eval("return " . $table[$y][$x2] . "/" . $table[0][$x2] . ";"); break;
                        default: exit("invalid operation");
                    }
                    
                    setValue($table, $output, $x, $y, $value);
                    
                    unset($unknown[$i]);
                    continue 2;
                }
            }
        }
        else {
            if($table[0][$x] != 0 && $table[$y][0] != 0) {
                
                switch($op) {
                        case '+': $value = eval("return " . $table[0][$x] . "+" . $table[$y][0] . ";"); break;
                        case '-': $value = eval("return " . $table[0][$x] . "+" . ($table[$y][0] * -1) . ";"); break;
                        case 'x': $value = eval("return " . $table[0][$x] . "*" . $table[$y][0] . ";"); break;
                        default: exit("invalid operation");
                    }
                    
                setValue($table, $output, $x, $y, $value);

                unset($unknown[$i]);
            }
        }
    }
}

echo implode(PHP_EOL, $output) . PHP_EOL;

error_log(microtime(1) - $start);
