<?php

function solve(string $expression): string {

    //We have a product to develop
    if(preg_match("/\(([^\(\)]+)\)\(([^\(\)]+)\)/", $expression, $matchesE)) {

        $left = preg_split("/(?=[+-])/", $matchesE[1], -1, PREG_SPLIT_NO_EMPTY);
        $right = preg_split("/(?=[+-])/", $matchesE[2], -1, PREG_SPLIT_NO_EMPTY);

        //We store the value of each constants
        $result = ['i' => 0, 'j' => 0, 'k' => 0, '' => 0];

        foreach($left as $L) {

            preg_match("/([\+\-]?)([0-9]*)([ijk]*)/", $L, $matchesL);

            $valueL = ($matchesL[2] ?: 1) * ($matchesL[1] == "-" ? -1 : 1);
            $indexL = $matchesL[3];

            foreach($right as $R) {

                preg_match("/([\+\-]?)([0-9]*)([ijk]*)/", $R, $matchesR);

                $valueR = ($matchesR[2] ?: 1) * ($matchesR[1] == "-" ? -1 : 1);
                $indexR = $matchesR[3];
 
                $value = $valueL * $valueR;

                switch($indexL . $indexR) {
                    case "i": 
                    case "jk": $index = "i"; break;
                    case "j":
                    case "ki": $index = "j"; break;
                    case "k":
                    case "ij": $index = "k"; break;
                    case "kj": $index = "i"; $value *= -1; break;
                    case "ik": $index = "j"; $value *= -1; break;
                    case "ji": $index = "k"; $value *= -1; break;
                    case "ii": 
                    case "jj": 
                    case "kk": $index = "";  $value *= -1; break;
                    default: $index = "";
                }

                //Increment the value of the constant
                $result[$index] += $value;
            }
        }

        //We are done with the product, transform our array of results into a string
        $resultExpression = "";

        array_walk($result, function ($v, $k) use (&$resultExpression) {
            //Negative number, only include the value if it's not -1
            if($v < 0) $resultExpression .= (($v != -1) ? $v : "-") . $k;
            //Positive number, we need to add the "+" and only include the value if it's not 1
            elseif($v > 0) $resultExpression .= "+" . (($v != 1) ? $v : "") . $k;
        });

        //Replace the product by the result and continue solving
        return solve(str_replace($matchesE[0], "(" . ltrim($resultExpression, "+") . ")", $expression));
    } 
    
    //Return the expression without the parentheses
    else return substr($expression, 1, -1);

}

echo solve(trim(fgets(STDIN))) . PHP_EOL;
