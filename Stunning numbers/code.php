<?php

const FLIP = ["3" => "*", "4" => "*", "6" => "9", "7" => "*", "9" => "6"];

function isStunning(string $n): string {
    return ($n == strtr(strrev($n), FLIP)) ? "true" : "false";
}

function getNextStunning(string $n): string {
    for($i = 0; $i < ceil(strlen($n) / 2); ++$i) {

        if($n[$i] == strtr($n[-($i + 1)], FLIP)) continue; //This position is already good
        else {
            //The case where the flipped is itself
            if($i == floor(strlen($n) / 2)) $v = strtr($n[$i], ["3" => "5", "4" => "5", "6" => "8", "7" => "8", "9" => "0"]);
            //The case where the flipped is another position
            else $v = strtr($n[$i], ["3" => "5", "4" => "5", "7" => "8"]);

            //We need to update the current position
            if($n[$i] != $v) {
                //1224XXXX => 12250000   
                $n = strval(intval(substr($n, 0, $i + 1)) + 1) . str_repeat("0", strlen($n) - $i - 1);

                $i = -1; 
                continue;
            }
            
            $flipped = strtr($v, FLIP);

            if($n[-($i + 1)] != $flipped) {
                //We can directly update the position
                if($n[-($i + 1)] < $flipped) $n[-($i + 1)] = $flipped;
                //Updating the position will increase the value of previous position
                else {
                    $n = strval(intval(substr($n, 0, -($i + 1))) + 1) . str_repeat("0", $i + 1);
                    $i = -1;
                }
            }
        }
    }

    return $n;
}

$n = trim(fgets(STDIN));

echo isStunning($n) . PHP_EOL; 

echo getNextStunning(strval($n + 1)) . PHP_EOL;
