<?php

const PREFIXES = ['', 'meth', 'eth', 'prop', 'but', 'pent', 'hex', 'hept', 'oct', 'non', 'dec'];

$formula = trim(fgets(STDIN));

preg_match_all("/[CHO][0-9]{0,}/", $formula, $matches);

error_log(var_export($matches, 1));

$atoms = ['C' => 0, 'O' => 0, 'H' => 0];

foreach($matches[0] as $part) {
    $atoms[$part[0]] += substr($part, 1) ?: 1;
}

error_log(var_export($atoms, 1));

if($atoms['C'] < 1 || $atoms['C'] > 10) exit('INVALID');
else $name = PREFIXES[$atoms['C']];

if($atoms['H'] == $atoms['C'] * 2 + 2) {
    if(substr($formula, -2) == 'OH' && $atoms['O'] == 1) $name .= 'anol';
    elseif($atoms['O'] == 0) $name .= 'ane';
    else $name = "INVALID";
}
elseif($atoms['H'] == $atoms['C'] * 2) {
    if(substr($formula, -4) == 'COOH' && $atoms['O'] == 2) $name .= 'anoic acid';
    elseif(substr($formula, -3) == 'CHO' && $atoms['O'] == 1) $name .= 'anal';
    elseif(preg_match("/^.+CO.+$/", $formula) && $atoms['O'] == 1) $name .= 'anone';
    elseif($atoms['O'] == 0) $name .= 'ene';
    else $name = "INVALID";
} else $name = "INVALID";


echo $name . PHP_EOL;
