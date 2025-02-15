<?php
//§ is the only that doesn't use single byte econding, no need to deal with that, just replace it with &
const NAMES = ['#' => "Block", '^' => "Thruster", '@' => "Gyroscope", '+' => "Fuel", "&" => "Core"];

fscanf(STDIN, "%d", $width);
fscanf(STDIN, "%d", $height);
fscanf(STDIN, "%d", $R);

for ($i = 0; $i < $height; $i++) {
    $grid[] = str_replace("§", "&", trim(fgets(STDIN)));
}

error_log(var_export($grid, 1));

$last = null;
$count = 0;
$output = [];

for($y = 0; $y < $height; ++$y) {
    for($x = 0; $x < $width; ++$x) {
        if(isset(NAMES[$grid[$y][$x]])) {
            if($grid[$y][$x] == $last) ++$count;
            else {
                if($count != 0) $output[] = $count . " " . NAMES[$last] . ($count > 1 ? 's' : '');

                $last = $grid[$y][$x];
                $count = 1;
            }
        }
    }
}

if($count != 0) $output[] = $count . " " . NAMES[$last] . ($count > 1 ? 's' : '');
if($R == 1) $output = array_reverse($output);

if(count($output) == 0) echo "Nothing" . PHP_EOL;
else echo implode(", ", $output) . PHP_EOL;
