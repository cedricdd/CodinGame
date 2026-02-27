<?php

fscanf(STDIN, "%d %d", $L, $N);

$secrets = range(0, 2 ** $L - 1);

//Secret can't be only 0
unset($secrets[0]);

$alphabet = range('Z', 'A');
$values = [];
$results = [];
$secret = null;

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s", $query);

    $value = bindec($query); //We convert everything into integer

    //We don't already have a letter associated with this query
    if(!isset($results[$value])) {

        //We haven't been forced to pick a secret already, try another turn without picking one
        if($secret === null) {
            $secretEliminated = null;

            foreach($values as $previousValue) {
                $xor = $value ^ $previousValue;

                if(isset($secrets[$xor])) {
                    $secretEliminated = $secretEliminated ?? $xor; //If all the possible secrets left are eleminated this turn we use the first one eliminated as secret

                    unset($secrets[$xor]);
                }
            }

            //We are forced to select the secret
            if(count($secrets) == 0) $secret = $secretEliminated;
            else $results[$value] = array_pop($alphabet); //Set a letter to this query
        }

        //The secret has been picked, one of the previous selected query/letter will generate the secret
        if($secret !== null) {
            foreach($values as $previousValue) {
                if(($previousValue ^ $value) == $secret) {
                    $results[$value] = $results[$previousValue];

                    break;
                }
            }
        }
    }

    $values[] =  $value;
}

if(count($secrets) > 0) $secret = array_key_last($secrets);

echo str_pad(decbin($secret), $L, '0', STR_PAD_LEFT) . PHP_EOL;

foreach($values as $value) echo $results[$value] . PHP_EOL;
