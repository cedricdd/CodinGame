<?php

function splitNumber(string $N): array {
    if(strpos($N, ".") === false) return [$N, 0.0];

    [$whole, $decimal] = explode(".", $N);

    $decimal = "0." . $decimal;

    return [$whole, $decimal];
}

$N = stream_get_line(STDIN, 20 + 1, "\n");

if($N == 0) {
    echo "[0][00000000][00000000000000000000000]" . PHP_EOL . "0x00000000" . PHP_EOL;
} else {
    //Integers or decimal
    preg_match("/^([+-])?([0-9]+(?:\.[0-9]+)?)$/", $N, $matches);

    if($matches) {
        $s = $matches[1] == "-" ? 1 : 0;
        [$whole, $decimal] = splitNumber($matches[2]);
    }

    if(isset($whoe) == false) {
        //Scientific notation
        preg_match("/^([+-])?(.*)e([+-])?([0-9]+)$/", $N, $matches);

        error_log(var_export($matches, true));
        
        if($matches) {
            $s = $matches[1] == "-" ? 1 : 0;
            $number = $matches[2];
            $se = $matches[3] ?: "+";

            //Generate the number based on the scientific notation
            for($i = 0; $i < $matches[4]; ++$i) {
                $positionDot = strpos($number, ".");

                if($positionDot === false) {
                    //We just add a 0 at the end
                    if($se == "+") $number .= "0";
                    //We just add a dot before the last digit
                    else $number = substr($number, 0, -1) . "." . $number[-1];
                }
                
                else {
                    if($se == "-") {
                        //We need to add a 0 before moving the dot
                        if($positionDot <= 1) {
                            $number = "0" . $number;
                            ++$positionDot;
                        }
                        
                        //We move the dot one place to the left
                        $number = substr($number, 0, $positionDot - 1) . "." . $number[$positionDot - 1] . substr($number, $positionDot + 1);
                    } 
                    else {
                        //We move the dot one place to the right
                        if($positionDot < strlen($number) - 2) $number = substr($number, 0, $positionDot) . $number[$positionDot + 1] . "." . substr($number, $positionDot + 2);
                        //We just remove the dot
                        else $number = str_replace(".", "", $number);
                    }

                }
            }

            [$whole, $decimal] = splitNumber($number);
        }
    }

    //NaN
    if(isset($whole) == false) {
        echo "[0][11111111][11111111111111111111111]" . PHP_EOL . "NaN" . PHP_EOL;
    } else {
        $bWhole = decbin($whole);
        $bDecimal = "";

        while(true) {
            $decimal *= 2.0;

            if($decimal == 0.0) break;
            elseif($decimal < 1.0) $bDecimal .= "0";
            else {
                $bDecimal .= "1";
                $decimal -= 1.0;
            }
        }

        $binary = $bWhole . "." . $bDecimal;
        $positionFirstOne = strpos($binary, "1");
        $positionDot = strlen($bWhole);

        if($positionDot > $positionFirstOne) $exp = $positionDot - $positionFirstOne - 1;
        else $exp = ($positionFirstOne - $positionDot) * -1;

        $e = str_pad(decbin(127 + $exp), 8, "0", STR_PAD_LEFT);
        $m = substr($bWhole . $bDecimal, $positionDot - $exp);

        //We need to truncate to 23 bits
        if(strlen($m) > 23) {
            if($m[$index = 23] == 1) {
                while(true) {
                    if($m[$index - 1] == 0) {
                        $m[$index - 1] = 1; 
                        break;
                    } else {
                        $m[$index - 1] = 0;
                        --$index;
                    }
                }
            }

            $m = substr($m, 0, 23);
        }
        else $m = str_pad($m, 23, "0", STR_PAD_RIGHT);

        echo "[$s][$e][$m]" . PHP_EOL . "0x" . strtoupper(base_convert($s . $e . $m, 2, 16)) . PHP_EOL;
    }
}
