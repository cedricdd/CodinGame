<?php

fscanf(STDIN, "%d", $n);
$inputs = fgets(STDIN);

if(array_sum(explode(" ", $inputs)) == 0) {
    echo "Asystole" . PHP_EOL; //They are dead
    exit();
}

$inputs = explode(" 0 ", $inputs);

if(count($inputs) == 5) {
    [$prSegment, $qrsComplex, $stSegment, $tWave, $idle] = $inputs;
    $pWave = null;
}
else [$pWave, $prSegment, $qrsComplex, $stSegment, $tWave, $idle] = $inputs;

$qrsDuration = count(explode(" ", $qrsComplex)) * 5;
$pDuration = count(explode(" ", $pWave)) * 5;
$tMax = max(explode(" ", $tWave));

if(count(array_unique(explode(" ", $prSegment))) != 1 && count(array_unique(explode(" ", $stSegment))) != 1) echo "Atrial Fibrillation" . PHP_EOL;
elseif($tMax > 60 && $qrsDuration > 110 && ($pWave == null || array_unique(explode(" ", $pWave)) > 1)) echo "Hyperkalemia" . PHP_EOL;
elseif($pWave == null) echo "Atrial Stand Still" . PHP_EOL;
elseif($qrsDuration > 110) echo "Wolff Parkinson White Syndrome" . PHP_EOL;
elseif($tMax > 60) echo "Myocardial Infarction" . PHP_EOL;
elseif($pDuration < 60) echo "Short P" . PHP_EOL;
else echo "Normal " . round(60000 / ($n * 5)) . PHP_EOL;
