<?php
fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $M);

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d", $invoices[]);
}
for ($i = 0; $i < $M; $i++) {
    $amount = trim(fgets(STDIN));
    $statements[] = [$amount, $amount, []];
}

$toCheck = [$statements];

foreach($invoices as $amount) {
    $newCheck = [];

    foreach($toCheck as $statements) {
        foreach($statements as $i => [$amountStart, $amountLeft, $list]) {
            if($amountLeft >= $amount) {
                $statementsUpdated = $statements;
                $statementsUpdated[$i][1] -= $amount;
                $statementsUpdated[$i][2][] = $amount;

                $newCheck[] = $statementsUpdated;
            }
        }
    }

    $toCheck = $newCheck;
}

foreach(range('A', 'Z') as $name) {
    $info = array_shift($toCheck[0]);

    if($info == null) break;
    else echo $name . " " . $info[0] . " - " . implode(" ", $info[2]) . PHP_EOL;
}
