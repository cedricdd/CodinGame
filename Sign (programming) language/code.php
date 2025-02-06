<?php

$program = stream_get_line(STDIN, 512 + 1, "\n");
$length = strlen($program);
$total = 0;
$counting = false;
$instuction = 0;

for($i = 0; $i < $length; ++$i) {
    if($program[$i] == "/") {
        if($counting) ++$instuction; //We are currently counting the instruction

        //Addition or Substraction
        if($program[$i + 1] == "$" || $program[$i + 1] == "/") {
            $sign = $program[$i + 1];
            $count = 0;
            $i += 2;

            while($program[$i] != "/") {
                ++$count;
                ++$i;
            }

            $total += $count * ($sign == "/" ? -1 : 1);
        } //Multiplication 
        elseif($program[$i + 1] == "*") {
            $sign = $program[$i + 2];
            $count = 0;
            $i += 3;

            if($sign == "$") {
                --$i;
                continue; //NOP
            }

            while($program[$i] != "/") {
                ++$count;
                ++$i;
            }

            $total *= ($sign == "*") ? ($count + 1) : ($count * -1);
        }
    } //Add inst count
    elseif($program[$i] == "$") {
        $counting ^= 1;
        $total += $instuction;
        $instuction = 0;
    }
}

echo $total . PHP_EOL;
