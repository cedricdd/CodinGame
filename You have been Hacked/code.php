<?php

const TYPES = ["ps" => 0, "bf" => 1, "mi" => 2];

fscanf(STDIN, "%d", $n);

for ($i = 0; $i < $n; $i++) {
    [$company, $p] = explode(':', trim(fgets(STDIN)));

    $companies[$company] = ['firewall' => $p, 'ps' => 0, 'bf' => 0, 'mi' => 0];
}

fscanf(STDIN, "%d", $a);

for ($i = 0; $i < $a; $i++) {
    [$name, $type, $s] = explode(':', trim(fgets(STDIN)));

    $companies[$name][$type] += $s;
}

foreach($companies as $name => $company) {
    $hacked = false;

    if($company["firewall"] < 7) {
        if($company["firewall"] < 5 && $company["bf"] >= 500 && $company["mi"] >= 1000) $hacked = true;
        elseif($company["bf"] >= 5000 && $company["mi"] >= 3000) $hacked = true;
    }

    echo $name . ":" . ($hacked ? "Hacked" : "Blocked") . PHP_EOL;
}
