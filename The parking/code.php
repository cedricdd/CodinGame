<?php

const CAR_SPOTS = 7;
const CAR_RATE = 1.2;
const MOTO_SPOTS = 2;
const MOTO_RATE = 0.7;
const FULL_DAY = 30;

$cars = [];
$motos = [];
$refusedCars = 0;
$refusedMotos = 0;
$fees = 0.0;

fscanf(STDIN, "%d", $H);

for ($j = 0; $j < $H; ++$j) {
    $inputs = explode(" ", trim(fgets(STDIN)));
    $count = count($inputs);

    //Vehicles are arriving
    if($inputs[1] == '>') {
        for($i = 2; $i < $count; ++$i) {
            if($inputs[$i][0] == 'C') {
                //No spots left for cars
                if(count($cars) == CAR_SPOTS) ++$refusedCars;
                else $cars[$inputs[$i]] = new Datetime($inputs[0]);
            } else {
                //No sports left for motos
                if(count($motos) == MOTO_SPOTS) ++$refusedMotos;
                else $motos[$inputs[$i]] = new Datetime($inputs[0]);
            }
        }
    } //Vehicles are leaving
    else {
        for($i = 2; $i < $count; ++$i) {
            if($inputs[$i][0] == 'C') {
                $diff = $cars[$inputs[$i]]->diff(new Datetime($inputs[0]));
                $diffInMinutes = $diff->i + ($diff->h * 60);

                if($diffInMinutes >= 30) $fees += CAR_RATE * ceil($diffInMinutes / 15);
                
                unset($cars[$inputs[$i]]);
            } else {
                $diff = $motos[$inputs[$i]]->diff(new Datetime($inputs[0]));
                $diffInMinutes = $diff->i + ($diff->h * 60);

                if($diffInMinutes >= 30) $fees += MOTO_RATE * ceil($diffInMinutes / 15);

                unset($motos[$inputs[$i]]);
            }
        }
    }
}

//Add the fees for the vehicles present at the end of the day
$fees += count($cars) * FULL_DAY + count($motos) * FULL_DAY;

echo number_format($fees, 1) . " " . $refusedCars . " " . $refusedMotos . PHP_EOL;
