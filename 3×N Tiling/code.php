<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

define("MODULO",1000000007);

/*
 * Height is only 1, if with is a multiple of 3 there's 1 solution otherwise there's none 
 */
function solve1($w) {
    if($w % 3 == 0) return 1;
    else return 0;
}

$memorization2[0] = 1;

/*
 * Height is 2 we can use the 2*2 or 2 3*1 so S(n) = S(n - 2) + S(n - 3)
 */
function solve2($w) {
    global $memorization2;

    if($w < 0) return 0;
    elseif(isset($memorization2[$w])) return $memorization2[$w];
    else return $memorization2[$w] = (solve2($w - 2) + solve2($w - 3)) % MODULO;
}

$startId = 3;
$memorization3 = [[1, 0, 0], [1, 0, 0], [1, 0, 0]];

/*
 * Height is 3
 * S(n)[0] is the case where everything is covered up to column n
 * S(n)[1] is the case where everything is covered up to column n-1 and there's 1/3 still to cover on column n
 * S(n)[2] is the case where everything is covered up to column n-1 and there's 2/3 still to cover on column n
 * 
 * We can use a 3*1, the whole column will be covered so S(n)[0] = S(n-1)[0];
 * We can use 3 1*3, the whole column will be covered so S(n)[0] = S(n-3)[0];
 * We can use a 2*2, forcing the use of a 3*1, there will be 1/3 left to be covered, additionally we can put the 2*2 at the top or bottom so S(n)[0] = S(n - 2)[1] * 2
 */
function solve3($w) {
    global $startId, $memorization3;

    for($i = $startId; $i <= $w; ++$i) {
        $memorization3[$i][0] = ($memorization3[$i - 1][0] + $memorization3[$i - 3][0] + (2 * $memorization3[$i - 2][1])) % MODULO;
        $memorization3[$i][1] = ($memorization3[$i - 1][2] + $memorization3[$i - 3][1]) % MODULO;
        $memorization3[$i][2] = ($memorization3[$i - 3][0] + $memorization3[$i - 3][2]) % MODULO;

        $startId++;
    }

    return $memorization3[$w][0];
}

fscanf(STDIN, "%d", $T);
for ($i = 0; $i < $T; $i++) {
    fscanf(STDIN, "%d %d", $h, $w);

    $solve = "solve" . $h;
    echo $solve($w) . "\n";
}
?>
