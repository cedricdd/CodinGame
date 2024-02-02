<?php

const ELEMENTS = array (
    'H' => 
    array (
      0 => 'H',
      1 => 'He',
      2 => 'Ho',
      3 => 'Hf',
      4 => 'Hg',
      5 => 'Hs',
    ),
    'L' => 
    array (
      0 => 'Li',
      1 => 'La',
      2 => 'Lu',
      3 => 'Lr',
      4 => 'Lv',
    ),
    'B' => 
    array (
      0 => 'Be',
      1 => 'B',
      2 => 'Br',
      3 => 'Ba',
      4 => 'Bi',
      5 => 'Bk',
      6 => 'Bh',
    ),
    'C' => 
    array (
      0 => 'C',
      1 => 'Cl',
      2 => 'Ca',
      3 => 'Cr',
      4 => 'Co',
      5 => 'Cu',
      6 => 'Cd',
      7 => 'Cs',
      8 => 'Ce',
      9 => 'Cm',
      10 => 'Cf',
      11 => 'Cn',
    ),
    'N' => 
    array (
      0 => 'N',
      1 => 'Ne',
      2 => 'Na',
      3 => 'Ni',
      4 => 'Nb',
      5 => 'Nd',
      6 => 'Np',
      7 => 'No',
      8 => 'Nh',
    ),
    'O' => 
    array (
      0 => 'O',
      1 => 'Os',
      2 => 'Og',
    ),
    'F' => 
    array (
      0 => 'F',
      1 => 'Fe',
      2 => 'Fr',
      3 => 'Fm',
      4 => 'Fl',
    ),
    'M' => 
    array (
      0 => 'Mg',
      1 => 'Mn',
      2 => 'Mo',
      3 => 'Md',
      4 => 'Mt',
      5 => 'Mc',
    ),
    'A' => 
    array (
      0 => 'Al',
      1 => 'Ar',
      2 => 'As',
      3 => 'Ag',
      4 => 'Au',
      5 => 'At',
      6 => 'Ac',
      7 => 'Am',
    ),
    'S' => 
    array (
      0 => 'Si',
      1 => 'S',
      2 => 'Sc',
      3 => 'Se',
      4 => 'Sr',
      5 => 'Sn',
      6 => 'Sb',
      7 => 'Sm',
      8 => 'Sg',
    ),
    'P' => 
    array (
      0 => 'P',
      1 => 'Pd',
      2 => 'Pr',
      3 => 'Pm',
      4 => 'Pt',
      5 => 'Pb',
      6 => 'Po',
      7 => 'Pa',
      8 => 'Pu',
    ),
    'K' => 
    array (
      0 => 'K',
      1 => 'Kr',
    ),
    'T' => 
    array (
      0 => 'Ti',
      1 => 'Tc',
      2 => 'Te',
      3 => 'Tb',
      4 => 'Tm',
      5 => 'Ta',
      6 => 'Tl',
      7 => 'Th',
      8 => 'Ts',
    ),
    'V' => 
    array (
      0 => 'V',
    ),
    'Z' => 
    array (
      0 => 'Zn',
      1 => 'Zr',
    ),
    'G' => 
    array (
      0 => 'Ga',
      1 => 'Ge',
      2 => 'Gd',
    ),
    'R' => 
    array (
      0 => 'Rb',
      1 => 'Ru',
      2 => 'Rh',
      3 => 'Re',
      4 => 'Rn',
      5 => 'Ra',
      6 => 'Rf',
      7 => 'Rg',
    ),
    'Y' => 
    array (
      0 => 'Y',
      1 => 'Yb',
    ),
    'I' => 
    array (
      0 => 'In',
      1 => 'I',
      2 => 'Ir',
    ),
    'X' => 
    array (
      0 => 'Xe',
    ),
    'E' => 
    array (
      0 => 'Eu',
      1 => 'Er',
      2 => 'Es',
    ),
    'D' => 
    array (
      0 => 'Dy',
      1 => 'Db',
      2 => 'Ds',
    ),
    'W' => 
    array (
      0 => 'W',
    ),
    'U' => 
    array (
      0 => 'U',
    ),
);

function solve(string $word, string $elements = "") {
    global $results;

    //We have fully replaced the word with elements
    if(empty($word)) {
        $results[] = $elements;
        return;
    }

    //Test all the elements starting by the first letter of the word
    foreach((ELEMENTS[ucfirst($word[0])] ?? []) as $element) {
        if(stripos($word, $element) === 0) {
            solve(substr($word, strlen($element)), $elements . $element, $results);
        }
    }
}

$results = [];
solve(trim(fgets(STDIN)));

sort($results); //Order lexicographically

echo implode("\n", $results ?: ["none"]) . PHP_EOL;
