<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s", $equation);

    //Equation is true without any parenthesis
    if(eval("return " . str_replace("=", "==", $equation) . ";")) echo $equation . PHP_EOL;
    else {
        [$left, $right] = explode("=", $equation);

        //Split the left part into numbers & operations
        $split = preg_split("/(?<=[0-9])([\+\-\*\/])/", $left, 0, PREG_SPLIT_DELIM_CAPTURE);

        //Test parenthesis, starting by using 3 parts (2 numbers + 1 operation) then add 2 parts until the equation is tru
        $size = 1;
        while(count($split) >= $size * 2 + 1) {
            $paramUsed = $size * 2 + 1;

            for($start = 0; $start <= count($split) - $paramUsed; $start += 2) {
                $equation = implode("", array_slice($split, 0, $start)); //Before the '('
                $equation .= "(" . implode("", array_slice($split, $start, $paramUsed)) . ")"; //Inside the ()
                $equation .= implode("", array_slice($split, $start + $paramUsed)); //After the '('
                $equation .= "=" . $right;

                //Check if the equation is right with the current placement 
                if(eval("return " . str_replace("=", "==", $equation) . ";")) {
                    echo $equation . PHP_EOL;
                    continue 3;
                }
            }

            ++$size;
        }

        echo "IMPOSSIBLE\n";
    }
}
?>
