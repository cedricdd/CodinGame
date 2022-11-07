<?php

// game loop
while (TRUE)
{
    fscanf(STDIN, "%d", $n);

    [$type, ] = explode(":", trim(fgets(STDIN)));

    error_log("Type is: $type");

    $lines = [];

    for ($i = 0; $i < $n - 1; $i++) {
        $lines[] = stream_get_line(STDIN, 999 + 1, "\n");
    }

    error_log(var_export($lines, true)); 

    //Xn = Xn-1 + Xn-2
    if($type == "ss_n") {
        preg_match("/\[(.*)\]\[([0-9]+)\]/", $lines[0], $matches);
        
        $list = array_map("intval", array_slice(explode(",", $matches[1]), 0, -1));

        for($i = 5; $i <= $matches[2]; ++$i) {
            $list[$i] = $list[$i - 1] + $list[$i - 2];
        }

        error_log(var_export($list, true)); 

        echo array_pop($list) . PHP_EOL;
    }
    //Xn = Xn-1 + (X1-X0)
    elseif($type == "rs_n") {
        preg_match("/\[(.*)\]\[([0-9]+)\]/", $lines[0], $matches);
        
        $list = array_map("intval", array_slice(explode(",", $matches[1]), 0, -1));

        for($i = 5; $i <= $matches[2]; ++$i) {
            $list[$i] = $list[$i - 1] + $list[1] - $list[0];
        }

        error_log(var_export($list, true)); 

        echo array_pop($list) . PHP_EOL;
    }
    //Index of the letter in lower case in the alphacbet, a is index 0
    elseif($type == "ss_f") {
        echo (ord(preg_replace("/[A-Z]/", "", $lines[0])) - 97) . PHP_EOL;
    }
    //Index of the first letter in the alphacbet, a is index 0
    elseif($type == "rs_f") {
        echo (ord($lines[0][0]) - 97) . PHP_EOL;
    }

    elseif($type == "gs_m") {
        [, $ascii] = explode(": ", $lines[0]);
        echo chr($ascii) . chr($ascii - 1) . PHP_EOL;
    }
    elseif($type == "ss_m") {
        $alphabet = array_flip(array_merge(range('Z', 'A')));

        //error_log(var_export($alphabet, true)); 

        echo $alphabet[$lines[0]] . PHP_EOL;
    }
    //Number is given in "alarm clock" format
    elseif($type == "ss_asc") {
        $i = 0;
        $ans = "";

        $numbers = [
            '0' => [6, [" ++++ ", "+    +", "+    +", "+    +", "+    +"]],
            '1' => [6, [" ++++ ", "+++++ ", "  +++ ", "  +++ ", "  +++ "]],       
            '2' => [7, [" +++++ ", "++   ++", " +  ++ ", "   ++  ", "  ++   "]],
            '3' => [7, [" +++++ ", "++   ++", "    ++ ", "++   ++", " +++++ "]],
            '4' => [8, ["   ++++ ", " ++   ++", " ++   ++", "++++++++", "      ++"]],
            '5' => [6, ["++++++", "+     ", "++++  ", "    + ", "    + "]],
            '6' => [6, [" +++  ", "+     ", "++++  ", "+   + ", "+++   "]],
            '7' => [6, ["++++++", "    ++", "   ++ ", "  ++  ", " ++   "]],
            '8' => [4, [" ++ ", "+  +", " ++ ", "+  +", " ++ "]],
            '9' => [6, [" ++++ ", "+    +", " ++++ ", "    + ", "    + "]],
        ];

        while($i < strlen($lines[0])) {

            foreach($numbers as $digit => [$length, $list]) {
                for($y = 0; $y <= 4; ++$y) {
                    if(substr($lines[$y], $i, $length) != $list[$y]) continue 2;
                }

                $i += ($length + 1);
                $ans .= $digit;
            }
        }

        echo $ans . PHP_EOL;
    }
    //Output a index to change the color of the index, if the color is correct you get a green "g", otherwise you get a red "r" 
    elseif($type == "ss_con") {
        $a = ["R" => 0, "r" => 1, "G" => 2, "g" => 3, "B" => 4, "b" => 5, "y" => 6, "o" => 7, "p" => 8];
        $test = array_map(function($position) {
            return preg_split("//u", $position, -1, PREG_SPLIT_NO_EMPTY);
        }, explode("...", $lines[0]));

        //error_log(var_export($test, true)); 

        for($i = 0; $i < 6; ++$i) {
            if($test[$i][4] == "r") {
                echo ($i + 1) . PHP_EOL;
                continue 2;
            }
        }

        //We found all the colors, validate, no idea why you output 0 for that
        echo 0 . PHP_EOL;
    }
}
?>
