<?php

fscanf(STDIN, "%d", $n);

for ($i = 0; $i < $n; ++$i) {
    //We remove the timestamp and username
    $line = preg_replace("/\([0-9: ]+\) \w+\s?:/", "", trim(fgets(STDIN)));
    $reply = strpos($line, "Automaton2000") !== false; //Should automaton reply
    //The word Automaton2000 is ignored
    $line = trim(preg_replace("/(\s|^)Automaton2000(\s|$)/", "", $line));

    //Parse the line
    if(!empty($line)) {
        $words = explode(" ", $line);

        for($j = 0; $j <= count($words); ++$j) {
            $index = $words[$j - 1] ?? "__START__"; //First word
            $next = $words[$j] ?? "__END__"; //Last word
    
            $table[$index][$next] = ($table[$index][$next] ?? 0) + 1; //Increase the weight
        }
    }

    if($reply) {
        $index = "__START__";
        $answer = [];

        while(count($answer) < 30) {
            //If you must choose between multiple words with the same weight, choose according to the alphabetical order (case sensitive, uppercase first)
            array_multisort($table[$index], SORT_DESC, array_keys($table[$index]), SORT_NATURAL);

            if(array_key_first($table[$index]) == "__END__") break; 

            $answer[] = ($index = array_key_first($table[$index]));
        }

        echo implode(" ", $answer) . PHP_EOL;
    }
}
