<?php

fscanf(STDIN, "%d", $c);
for ($i = 0; $i < $c; $i++) {
    $customers[trim(fgets(STDIN))] = range(0, 3);
}

fscanf(STDIN, "%d", $r);
for ($i = 0; $i < $r; $i++) {
    $rule = trim(fgets(STDIN));

    //Check if it's a rule we can directly apply
    if(preg_match("/There's nobody at floor ([0-3])/", $rule, $matches)) {
        foreach($customers as $name => $floors) unset($customers[$name][$matches[1]]);
    } elseif(preg_match("/([a-zA-Z ]+) is at floor ([0-3])/", $rule, $matches)) {
        $customers[$matches[1]] = [$matches[2] => $matches[2]];
    } elseif(preg_match("/([a-zA-Z ]+) is NOT at floor ([0-3])/", $rule, $matches)) {
        unset($customers[$matches[1]][$matches[2]]);
    } else {
        $rules[] = $rule;
    }
}

while(true) {

    foreach($rules as $index => $rule) {
        if(preg_match("/([a-zA-Z ]+) is just above ([a-zA-Z ]+)/", $rule, $matches)) {
            [, $name1, $name2] = $matches;

            //A floor can only be valid if the other customer can be on the floor directly below
            foreach($customers[$name1] as $floor) {
                if(!isset($customers[$name2][$floor - 1])) unset($customers[$name1][$floor]);
            }
            //A floor can only be valid if the other customer can be on the floor directly above
            foreach($customers[$name2] as $floor) {
                if(!isset($customers[$name1][$floor + 1])) unset($customers[$name2][$floor]);
            }
        }
        if(preg_match("/([a-zA-Z ]+) is higher than ([a-zA-Z ]+)/", $rule, $matches)) {
            [, $name1, $name2] = $matches;

            $min = min($customers[$name2]);

            //A floor can only be valid if the other customer can be on a floor below
            foreach($customers[$name1] as $floor) {
                if($floor <= $min) unset($customers[$name1][$floor]);
            }

            $max= max($customers[$name1]);

             //A floor can only be valid if the other customer can be on a floor above
            foreach($customers[$name2] as $floor) {
                if($floor >= $max) unset($customers[$name2][$floor]);
            }
        }
        elseif(preg_match("/([a-zA-Z ]+) is alone at his\/her floor/", $rule, $matches)) {
            //We already know the floor
            if(count($customers[$matches[1]]) == 1) {
                $floor = array_key_first($customers[$matches[1]]);

                foreach($customers as $name => $floors) {
                    if($name == $matches[1]) continue;
    
                    unset($customers[$name][$floor]);
                }

                unset($rules[$index]); //No need to check this rule again
            } //The customer can't be on any floors where we know for sure there's another customer 
            else {
                foreach($customers as $name => $floors) {
                    if($name == $matches[1]) continue;
    
                    if(count($floors) == 1) unset($customers[$matches[1]][array_key_first($floors)]);
                }
            }
        }
        elseif(preg_match("/There are exactly two customers at floor ([0-3])/", $rule, $matches)) {
            //We start by checking how many customers are for sure at this floor
            $alreadyFound = [];

            foreach($customers as $name => $floors) {
                if(count($floors) == 1 && array_key_first($floors) == $matches[1]) $alreadyFound[] = $name;
            }

            $leftToFind = 2 - count($alreadyFound);
            $list = [];

            //Get the customers that could be added at this floor
            foreach($customers as $name => $floors) {
                if(!isset($floors[$matches[1]])) continue; //Customer can't be at this floor
                if(in_array("$name is alone at his/her floor", $rules)) continue; //Customer need to be alone, he can't be at this floor
                if(in_array($name, $alreadyFound)) continue; //We already know that this customer is at this floor
                if(in_array("$name is with two other customers at his/her floor", $rules)) continue; //Customer can't be on a floor with only one other customer
                    
                $list[] = $name;
            }

            //There only one other customer at this floor, if we kown that 2 of the candidates are on the same floor, we can remove both
            if($leftToFind == 1 && count($list) > 1) {
                for($i = 0; $i < count($list); ++$i) {
                    for($j = $i + 1; $j < count($list); ++$j) {
                        if(in_array("$list[$i] is at the same floor as $list[$j]", $rules) || in_array("$list[$j] is at the same floor as $list[$i]", $rules)) {
                            unset($list[$i]);
                            unset($list[$j]);
                            continue 2;
                        }
                    }
                }
            }

            //We have found the proper floor
            if(count($list) == $leftToFind) {
                foreach($list as $name) {
                    $customers[$name] = [$matches[1] => $matches[1]];
                }

                unset($rules[$index]); //No need to check this rule again
            }
        }
        elseif(preg_match("/([a-zA-Z ]+) is at the same floor as ([a-zA-Z ]+)/", $rule, $matches)) {
            //Get the floors that are common to the customers
            $sameFloors = array_intersect($customers[$matches[1]], $customers[$matches[2]]);
            $customers[$matches[1]] = $sameFloors;
            $customers[$matches[2]] = $sameFloors;
        }
        elseif(preg_match("/([a-zA-Z ]+) is with two other customers at his\/her floor/", $rule, $matches)) {
            $possibleFloors = [];

            //Check all the floors the customers can go to see if there's only 3 possible customers
            foreach($customers[$matches[1]] as $floor) {

                $list = [];

                foreach($customers as $name2 => $floors) {
                    if(isset($floors[$floor])) $list[] = $name2;
                }

                if(count($list) == 3) $possibleFloors[$floor] = $list;
            }

            //We have found the proper floor, set it for the 3 customers
            if(count($possibleFloors) == 1) {
                $floor = array_key_first($possibleFloors);

                foreach($possibleFloors[$floor] as $name) $customers[$name] = [$floor => $floor];

                unset($rules[$index]); //No need to check this rule again
            }
        }
    }

    foreach($customers as $name => $floors) {
        if(count($floors) > 1) continue 2;
    }

    break;
}

foreach($customers as $name => $floors) {
    echo $name . " " . array_key_first($floors) . PHP_EOL;
 }
