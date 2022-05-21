<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%s %s", $p1, $p2);
$ratio = stream_get_line(STDIN, 50 + 1, "\n");

$a = [$p1[0] . $p1[2], $p1[0] . $p1[3], $p1[1] . $p1[2], $p1[1] . $p1[3]];
$b = [$p2[0] . $p2[2], $p2[0] . $p2[3], $p2[1] . $p2[2], $p2[1] . $p2[3]];

for($i = 0; $i < 4; ++$i) {
    for($j = 0; $j < 4; ++$j) {
        $t = (ord($a[$i][0]) < ord($b[$j][0])) ? $a[$i][0] . $b[$j][0] : $b[$j][0] . $a[$i][0];
        $t .= (ord($a[$i][1]) < ord($b[$j][1])) ? $a[$i][1] . $b[$j][1] : $b[$j][1] . $a[$i][1];

        $genotype[$t] = ($genotype[$t] ?? 0) + 1;
    }
}

$min = 16; //Max possible
foreach(explode(':', $ratio) as $g) {
    $value = $genotype[$g] ?? 0;
    $outputs[] = $value;
    if($value != 0 && $value < $min) $min = $value;
}

//Ratio of each genotypes
$outputs = array_map(function($output) use ($min) {
    return $output / $min;
}, $outputs);


echo implode($outputs, ':') . "\n";
?>
