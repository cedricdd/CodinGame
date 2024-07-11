<?php


$output = array_fill(0, 5, '.');
$G = [];
$Y = [];
$negative = [];
$positive = [];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s %s", $guess, $result);

    error_log("$guess, $result");

    for($j = 0; $j < 5; ++$j) {
        if($result[$j] == 'G') {
            $output[$j] = $guess[$j];
            $G[$guess[$j]] = 1;
        }
        elseif($result[$j] == 'Y') {
            $Y[$j][$guess[$j]] = 1;
            $positive[$guess[$j]] = 1;
        }
        elseif($result[$j] == '_') $negative[$guess[$j]] = 1;
    }
}

//We found the solution
if(array_search('.', $output) === false) exit("^" . implode('', $output) . "$");

//We need to removed the letters with a Y or G from the negative look-ahead
$negative = array_diff_key($negative, $G);
$negative = array_diff_key($negative, $positive);

ksort($negative);

//We need to removed the letters with a G from the positive look-ahead
$positive = array_diff_key($positive, $G);

ksort($positive);

foreach($Y as $i => $list) {
    if($output[$i] != '.') continue;

    if(count($list) > 1) {
        ksort($list);

        $output[$i] = "(?![" . implode('', array_keys($list)) . "]).";
    } else $output[$i] = "(?!" . array_key_first($list) . ").";
}

echo "^" . (count($positive) ? implode('', array_map(function($a) { return "(?=.*" . $a . ")"; }, array_keys($positive))) : "") . (count($negative) ? "(?!.*[" . implode('', array_keys($negative)) . "])" : "") . implode('', $output) . "$" . PHP_EOL;
