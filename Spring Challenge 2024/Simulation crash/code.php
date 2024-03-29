<?php

/**
 * @param (string)[] $codes The list of binary codes in the table
 * @return The shortest and smallest possible ambiguous sequence. If no such sequence exists, return "X"
 */
function crashDecode($codes) {

    $start = microtime(1);

    // Write your code here
    //error_log(var_export($codes, true));

    foreach($codes as $code) {
        $size = strlen($code);

        for($i = 1; $i <= $size; ++$i) {
            $s = substr($code, 0, $i);
            $suffix[$s][] = $code;
        }

        $myCodes[$code] = $size;
    }

    asort($myCodes);

    //error_log(var_export($myCodes, true));

    $shortest = INF;
    $bestSequence = "";

    foreach($myCodes as $code => $size) {
        //can't be the start, no ambiguity
        if(count($suffix[$code]) == 1) continue;

        foreach($suffix[$code] as $potentialCode) {
            if($potentialCode == $code) continue;

            $checked = [];
            $sequences = [[$code, $potentialCode]];

            while($sequences) {
                //error_log(var_export($sequences, true));
                $newSequences = [];

                foreach($sequences as [$s1, $s2]) {
                    $l1 = strlen($s1);
                    $l2 = strlen($s2);

                    //We switch so s1 is shorter than s2
                    if($l1 > $l2) [$s1, $s2, $l1, $l2] = [$s2, $s1, $l2, $l1];
                    
                    //This sequence is already longer than the current best
                    if($l2 > $shortest) continue;

                    $d = substr($s2, $l1 - $l2);

                    if(isset($checked[$d]) && $checked[$d] <= $l1) continue;
                    else $checked[$d] = $l1;

                    //We found an ambibuous sequence
                    if(isset($myCodes[$d])) {

                        if($shortest == $l2 && strcmp($bestSequence, $s2) < 0) continue;

                        $shortest = $l2;
                        $bestSequence = $s2;
                        continue;
                    }

                    for($k = 1; $k <= $l2 - $l1; ++$k) {
                        $c = substr($d, 0, $k);

                        if(isset($myCodes[$c])) {
                            $newSequences[] = [$s1 . $c, $s2];
                        }
                    }

                    foreach(($suffix[$d] ?? []) as $possibleCode) {
                        $newSequences[] = [$s2, $s1 . $possibleCode];
                    }
                }


                $sequences = $newSequences;
            }
        }
    }

    error_log("answer is $bestSequence");
    error_log(microtime(1) - $start);

    if(empty($bestSequence)) return "X";
    else return $bestSequence;
}
