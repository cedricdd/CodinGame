<?php
fscanf(STDIN, "%d", $n);

$heights = array_map("intval", explode(" ", trim(fgets(STDIN))));

$starts = []; 
$ends = [];
$previousStart = 0;
$previousEnd = 0;

for($i = 1; $i <= $n; ++$i) {
    //Ascending order from left to right to find the potential start of area
    if($heights[$i - 1] > $previousStart) {
        $starts[] = [$heights[$i - 1], $i - 1];
        $previousStart = $heights[$i - 1];
    }
    //Ascending order from right to left to find the potential end of area
    if($heights[$n - $i] > $previousEnd) {
        $ends[] = [$heights[$n - $i], $n - $i];
        $previousEnd = $heights[$n - $i];
    }
}

$max = 0;

//We test all combinaisons of start & end
foreach($starts as [$startValue, $startIndex]) {
    foreach($ends as [$endValue, $endIndex]) {
        $max = max($max, (min($startValue, $endValue) * ($endIndex - $startIndex))); 
    }
}

echo $max . PHP_EOL;
?>
