<?php

const PERIODIC_TABLE = [
    1 => "H", 2 => "He", 3 => "Li", 4 => "Be", 5 => "B", 6 => "C", 7 => "N", 8 => "O", 9 => "F", 10 => "Fe",
    11 => "Na", 12 => "Mg", 13 => "Al", 14 => "Si", 15 => "P", 16 => "S", 17 => "Cl", 18 => "Ar", 19 => "K", 20 => "Ca",
    21 => "Sc", 22 => "Ti", 23 => "V", 	24 => "Cr", 25 => "Mn", 26 => "Fe", 27 => "Co", 28 => "Ni", 29 => "Cu", 30 => "Zn",
    31 => "Ga", 32 => "Ge", 33 => "As", 34 => "Se", 35 => "Br", 36 => "Kr", 37 => "Rb", 38 => "Sr", 39 => "Y", 40 => "Zr",
    41 => "Nb", 42 => "Mo", 43 => "Tc", 44 => "Ru", 45 => "Rh", 46 => "Pd", 47 => "Ag", 48 => "Cd", 49 => "In", 50 => "Sn",
    51 => "Sb", 52 => "Te", 53 => "I",  54 => "Xe", 55 => "Cs", 56 => "Ba", 57 => "La", 58 => "Ce", 59 => "Pr", 60 => "Nd",
    61 => "Pm", 62 => "Sm", 63 => "Eu", 64 => "Gd", 65 => "Tb", 66 => "Dy", 67 => "Ho", 68 => "Er", 69 => "Tm", 70 => "Yb", 
    71 => "Lu", 72 => "Hf", 73 => "Ta", 74 => "W",  75 => "Re", 76 => "Os", 77 => "Ir", 78 => "Pt", 79 => "Au", 80 => "Hg", 
    81 => "Tl", 82 => "Pb", 83 => "Bi", 84 => "Po", 85 => "At", 86 => "Rn", 87 => "Fr", 88 => "Ra", 89 => "Ac", 90 => "Th",
    91 => "Pa", 92 => "U" ,	93 => "Np", 94 => "Pu", 95 => "Am", 96 => "Cm", 97 => "Bk", 98 => "Cf", 99 => "Es", 100 => "Fm", 
    101 => "Md", 102 => "No", 103 => "Lr", 104 => "Rf", 105 => "Db", 106 => "Sg", 107 => "Bh", 108 => "Hs", 109 => "Mt", 110 => "Ds", 
    111 => "Rg", 112 => "Cn", 113 => "Nh", 114 => "Fl", 115 => "Mc", 116 => "Lv", 117 => "Ts", 118 => "Og"
];

const COLORS = [
    "W" => "GRAY", "w" => "WHITE", "R" => "RED", "r" => "LIGHT_RED", "G" => "GREEN", "g" => "LIGHT_GREEN",
    "B" => "BLUE", "b" => "LIGHT_BLUE", "y" => "YELLOW", "o" => "ORANGE", "P" => "PINK", "p" => "LIGHT_PINK",
    "V" => "VIOLET", "v" => "LIGHT_VIOLET"
];

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

    //Xn = Xn-1 + Xn-2
    if($type == "ss_n") {
        preg_match("/\[(.*)\]\[([0-9]+)\]/", $lines[0], $matches);
        
        $list = array_map("intval", array_slice(explode(",", $matches[1]), 0, -1));

        for($i = 5; $i <= $matches[2]; ++$i) {
            $list[$i] = $list[$i - 1] + $list[$i - 2];
        }

        echo array_pop($list) . PHP_EOL;
    }
    //Xn = Xn-1 + (X1-X0)
    elseif($type == "rs_n") {
        preg_match("/\[(.*)\]\[([0-9]+)\]/", $lines[0], $matches);
        
        $list = array_map("intval", array_slice(explode(",", $matches[1]), 0, -1));

        for($i = 5; $i <= $matches[2]; ++$i) {
            $list[$i] = $list[$i - 1] + $list[1] - $list[0];
        }

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
    //Symbol of the chemical element by it's atomic number
    elseif($type == "gs_m") {
        [, $value] = explode(": ", $lines[0]);

        echo PERIODIC_TABLE[$value] . PHP_EOL;
    }
    //Atomic number of a chemical element
    elseif($type == "ss_m") {
        $table = array_flip(PERIODIC_TABLE);

        echo $table[$lines[0]] . PHP_EOL;
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
        $inputs = array_map(function($position) {
            return preg_split("//u", $position, -1, PREG_SPLIT_NO_EMPTY);
        }, explode("...", $lines[0]));

        for($i = 0; $i < 6; ++$i) {
            if($inputs[$i][4] == "r") {
                echo ($i + 1) . PHP_EOL;
                continue 2;
            }
        }

        //We found all the colors, validate, no idea why you output 0 for that
        echo 0 . PHP_EOL;
    }
    //Output the full name of the only colors that has a "+" next to it
    elseif($type == "ss_colv") {
        preg_match("/[a-zA-Z](?=\+)/", $lines[0], $match);

        echo COLORS[$match[0]] . PHP_EOL;
    }
    //Just print the full name of the colors
    elseif($type == "rs_colv") {
        preg_match("/[a-zA-Z]/", $lines[0], $match);

        echo COLORS[$match[0]] . PHP_EOL;
    }
}
?>
