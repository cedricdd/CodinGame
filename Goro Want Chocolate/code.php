<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/
fscanf(STDIN, "%d %d", $h, $w);

error_log(var_export($w . " " . $h, true));

$memorization = [];

function solve($w, $h) {
    global $memorization;

    //The oritentaion doesn't matter, to prevent duplicate info we always make sure $w >= $h
    if($w < $h) [$w, $h] = [$h, $w];

    if(isset($memorization[$w][$h])) return $memorization[$w][$h];

    //$w is divible by $h, the best is just $w / $h
    if($w % $h == 0) {
        $result = $w / $h;
    } else {
        $result = PHP_INT_MAX;

        //We cut on the vertical axis
        for($i = 1; $i <= $w >> 1; ++$i) {
            $r = solve($i, $h) + solve($w - $i, $h);
            if($r < $result) $result = $r;
        }
        //We cut on the horizontal axis
        for($i = 1; $i <= $h >> 1; ++$i) {
            $r = solve($w, $i) + solve($w, $h - $i);
            if($r < $result) $result = $r;
        }
    }

    $memorization[$w][$h] = $result;
    return $result;
}

echo solve($w, $h);
?>
