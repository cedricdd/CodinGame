<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $truths[] = trim(fgets(STDIN));
}

error_log(var_export($truths, 1));

$full = true;
$are = ["PIGS" => 1];
$have = [];
$can = [];

do {
    error_log("starting cheks");

    $continue = false;

    foreach($truths as $index => $thruth) {
        if(preg_match("/^([A-Z]+)( with [A-Z]+)?( and [A-Z]+)?( that can [A-Z]+)? (?:are [A-Z]+(?: with [A-Z]+)? that )?can FLY$/", $thruth, $match)) {
            if(isset($are[$match[1]])) {
                $count = count($match);

                //Make sure all the requirements are met
                for($i = 2; $i < $count; ++$i) {
                    if(preg_match("/ with ([A-Z]+)/", $match[$i], $match2) && !isset($have[$match2[1]])) continue 2;
                    if(preg_match("/ and ([A-Z]+)/", $match[$i], $match2) && !isset($have[$match2[1]])) continue 2;
                    if(preg_match("/ that can ([A-Z]+)/", $match[$i], $match2) && !isset($can[$match2[1]])) continue 2;
                }

                //Pigs can fly
                if($full) echo "All pigs can fly" . PHP_EOL;
                else echo "Some pigs can fly" . PHP_EOL;
                exit();
            } 
        }

        if(preg_match("/^([A-Z]+)( with [A-Z]+)?( and [A-Z]+)?( that can [A-Z]+)? are ([A-Z]+)( with [A-Z]+)?( that can [A-Z]+)?$/", $thruth, $match)) {

            if(!$full) {
                //Some pigs are this object
                if(isset($are[$match[5]])) {
                    $are[$match[1]] = 1;
                    error_log("18 adding are " . $match[1]);
                    $continue = true;
    
                    unset($truths[$index]);
                } //Some pigs have this trait
                elseif(isset($have[$match[5]])) {
                    $have[$match[1]] = 1;
                    error_log("18 adding have " . $match[1]);
                    $continue = true;
    
                    unset($truths[$index]);
                }
            }

            //Make sure all the requirements are met
            for($i = 2; $i <= 4; ++$i) {
                if(preg_match("/ with ([A-Z]+)/", $match[$i], $match2) && !isset($have[$match2[1]])) continue 2;
                if(preg_match("/ and ([A-Z]+)/", $match[$i], $match2) && !isset($have[$match2[1]])) continue 2;
                if(preg_match("/ that can ([A-Z]+)/", $match[$i], $match2) && !isset($can[$match2[1]])) continue 2;
            }

            //Adding an object
            if(isset($are[$match[1]])) {
                $are[$match[5]] = 1;
                error_log("7 adding are " . $match[5]);
                $continue = true;

                unset($truths[$index]);
            } //Adding a trait
            elseif(isset($have[$match[1]])) {
                $have[$match[5]] = 1;
                error_log("8 adding have " . $match[5]);
                $continue = true;

                unset($truths[$index]);
            }
        }

        if(preg_match("/^([A-Z]+)( with [A-Z]+)?( and [A-Z]+)?( that can [A-Z]+)? have ([A-Z]+)$/", $thruth, $match)) {

            //Make sure all the requirements are met
            for($i = 2; $i <= 4; ++$i) {
                if(preg_match("/ with ([A-Z]+)/", $match[$i], $match2) && !isset($have[$match2[1]])) continue 2;
                if(preg_match("/ and ([A-Z]+)/", $match[$i], $match2) && !isset($have[$match2[1]])) continue 2;
                if(preg_match("/ that can ([A-Z]+)/", $match[$i], $match2) && !isset($can[$match2[1]])) continue 2;
            }

            //Adding a trait
            if(isset($are[$match[1]])) {
                $have[$match[5]] = 1;
                error_log("1 adding have " . $match[5]);
                $continue = true;

                unset($truths[$index]);
            } 
        }

        if(preg_match("/^([A-Z]+)( with [A-Z]+)?( and [A-Z]+)?( that can [A-Z]+)? can ([A-Z]+)$/", $thruth, $match)) {

            // error_log(var_export($match, 1));

            //Make sure all the requirements are met
            for($i = 2; $i <= 4; ++$i) {
                if(preg_match("/ with ([A-Z]+)/", $match[$i], $match2) && !isset($have[$match2[1]])) continue 2;
                if(preg_match("/ and ([A-Z]+)/", $match[$i], $match2) && !isset($have[$match2[1]])) continue 2;
                if(preg_match("/ that can ([A-Z]+)/", $match[$i], $match2) && !isset($can[$match2[1]])) continue 2;
            }

            //Adding an abbility
            if(isset($are[$match[1]])) {
                $can[$match[5]] = 1;
                $continue = true;

                error_log("3 adding can " . $match[5]);

                unset($truths[$index]);
            }
        }
    }

    //Switch to 'some'
    if(!$continue && $full) {
        error_log("switching to some");

        $full = false;
        $continue = true;
    }

} while($continue);

echo "No pigs can fly" . PHP_EOL;
