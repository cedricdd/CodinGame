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
        if(preg_match("/([A-Z]+) can FLY/", $thruth, $match)) {
            if(isset($are[$match[1]])) {
                // error_log(var_export($match, 1));

                if($full) echo "All pigs can fly" . PHP_EOL;
                else echo "Some pigs can fly" . PHP_EOL;
                exit();
            } 
        }

        if(preg_match("/([A-Z]+) that can ([A-Z]+) can FLY/", $thruth, $match)) {
            if(isset($are[$match[1]]) && isset($can[$match[2]])) {
                // error_log(var_export($match, 1));

                if($full) echo "All pigs can fly" . PHP_EOL;
                else echo "Some pigs can fly" . PHP_EOL;
                exit();
            } 
        }

        if(preg_match("/([A-Z]+) with ([A-Z]+) can FLY/", $thruth, $match)) {
            if(isset($are[$match[1]]) && isset($have[$match[2]])) {
                // error_log(var_export($match, 1));

                if($full) echo "All pigs can fly" . PHP_EOL;
                else echo "Some pigs can fly" . PHP_EOL;
                exit();
            } 
        }

        if(preg_match("/([A-Z]+) with ([A-Z]+) that can ([A-Z]+) can FLY/", $thruth, $match)) {
            if(isset($are[$match[1]]) && isset($have[$match[2]]) && isset($can[$match[3]])) {
                // error_log(var_export($match, 1));

                if($full) echo "All pigs can fly" . PHP_EOL;
                else echo "Some pigs can fly" . PHP_EOL;
                exit();
            } 
        }

        if(preg_match("/([A-Z]+) with ([A-Z]+) are ([A-Z]+) that can FLY/", $thruth, $match)) {
            if(isset($are[$match[1]]) && isset($have[$match[2]])) {
                // error_log(var_export($match, 1));

                if($full) echo "All pigs can fly" . PHP_EOL;
                else echo "Some pigs can fly" . PHP_EOL;
                exit();
            } 
        }

        if(preg_match("/^([A-Z]+) are ([A-Z]+)$/", $thruth, $match)) {
            if(isset($are[$match[1]])) {
                $are[$match[2]] = 1;
                error_log("7 adding are " . $match[2]);
                $continue = true;

                unset($truths[$index]);
            }elseif(isset($have[$match[1]])) {
                $have[$match[2]] = 1;
                error_log("8 adding have " . $match[2] . " -- " . $match[1]);
                $continue = true;

                unset($truths[$index]);
            }
        }

        if(preg_match("/^([A-Z]+) are ([A-Z]+) that can ([A-Z]+)$/", $thruth, $match)) {
            if(isset($are[$match[1]])) {
                $are[$match[2]] = 1;
                error_log("7 adding are " . $match[2]);

                $can[$match[3]] = 1;
                error_log("12 adding can " . $match[3]);

                $continue = true;

                unset($truths[$index]);
            }
        }

        if(preg_match("/([A-Z]+) have ([A-Z]+)/", $thruth, $match)) {
            if(isset($are[$match[1]])) {
                $have[$match[2]] = 1;
                error_log("1 adding have " . $match[2]);
                $continue = true;

                unset($truths[$index]);
            } 
        }

        if(preg_match("/([A-Z]+) can ([A-Z]+)/", $thruth, $match)) {
            if(isset($are[$match[1]])) {
                $can[$match[2]] = 1;
                error_log("2 adding can " . $match[2]);
                $continue = true;

                unset($truths[$index]);
            }
        }

        if(preg_match("/([A-Z]+) that can ([A-Z]+) are ([A-Z]+)/", $thruth, $match)) {
            if(isset($are[$match[1]]) && isset($can[$match[2]])) {
                $are[$match[3]] = 1;
                error_log("3 adding are " . $match[3]);
                $continue = true;

                unset($truths[$index]);
            }
        }

        if(preg_match("/([A-Z]+) that can ([A-Z]+) have ([A-Z]+)/", $thruth, $match)) {
            if(isset($are[$match[1]]) && isset($can[$match[2]])) {
                $have[$match[3]] = 1;
                error_log("11 adding have " . $match[3]);
                $continue = true;

                unset($truths[$index]);
            }
        }

        if(preg_match("/([A-Z]+) with ([A-Z]+) can ([A-Z]+)/", $thruth, $match)) {
            // error_log(var_export($match, 1));

            if(isset($are[$match[1]]) && isset($have[$match[2]])) {
                $can[$match[3]] = 1;
                error_log("9 adding can " . $match[3]);
                $continue = true;

                unset($truths[$index]);
            } 
        }

        if(preg_match("/([A-Z]+) with ([A-Z]+) are ([A-Z]+)/", $thruth, $match)) {
            // error_log(var_export($match, 1));

            if(isset($are[$match[1]]) && isset($have[$match[2]])) {
                $are[$match[3]] = 1;
                error_log("12 adding are " . $match[3]);
                $continue = true;

                unset($truths[$index]);
            } 
        }

        if(preg_match("/([A-Z]+) with ([A-Z]+) are ([A-Z]+) that can ([A-Z]+)/", $thruth, $match)) {
            // error_log(var_export($match, 1));

            if(isset($are[$match[1]]) && isset($have[$match[2]])) {
                $are[$match[3]] = 1;
                error_log("4 adding are " . $match[3]);

                $can[$match[4]] = 1;
                error_log("5 adding can " . $match[4]);
                $continue = true;

                unset($truths[$index]);
            } 
        }

        if(preg_match("/([A-Z]+) with ([A-Z]+) that can ([A-Z]+) can ([A-Z]+)/", $thruth, $match)) {
            // error_log(var_export($match, 1));

            if(isset($are[$match[1]]) && isset($have[$match[2]]) && isset($can[$match[3]])) {
                $can[$match[4]] = 1;
                error_log("6 adding can " . $match[4]);
                $continue = true;

                unset($truths[$index]);
            } 
        }
    }

    //Switch to 'some'
    if(!$continue && $full) {
        error_log("switching to some");

        foreach($truths as $index => $thruth) {
            if(preg_match("/^([A-Z]+) with ([A-Z]+) are PIGS$/", $thruth, $match)) {
                $are[$match[1]] = 1;
                error_log("adding some " . $match[1]);

                $have[$match[2]] = 1;
                error_log("adding have " . $match[2]);
                $continue = true;

                unset($truths[$index]);
            }
            if(preg_match("/^([A-Z]+) are PIGS$/", $thruth, $match)) {
                $are[$match[1]] = 1;
                error_log("adding some " . $match[1]);
                $continue = true;

                unset($truths[$index]);
            }
        }

        $full = false;
        $continue = true;
    }

} while($continue);

echo "No pigs can fly" . PHP_EOL;
