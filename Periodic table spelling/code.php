<?php

const ELEMENTS = array (
    'H' => ['H', 'He', 'Ho', 'Hf', 'Hg', 'Hs'],
    'L' => ['Li', 'La', 'Lu', 'Lr', 'Lv'],
    'B' => ['Be', 'B', 'Br', 'Ba', 'Bi', 'Bk', 'Bh'],
    'C' => ['C', 'Cl', 'Ca', 'Cr', 'Co', 'Cu', 'Cd', 'Cs', 'Ce', 'Cm', 'Cf', 'Cn'],
    'N' => ['N', 'Ne', 'Na', 'Ni', 'Nb', 'Nd', 'Np', 'No', 'Nh'],
    'O' => ['O', 'Os', 'Og'],
    'F' => ['F', 'Fe', 'Fr', 'Fm', 'Fl'],
    'M' => ['Mg', 'Mn', 'Mo', 'Md', 'Mt', 'Mc'],
    'A' => ['Al', 'Ar', 'As', 'Ag', 'Au', 'At', 'Ac', 'Am'],
    'S' => ['Si', 'S', 'Sc', 'Se', 'Sr', 'Sn', 'Sb', 'Sm', 'Sg'],
    'P' => ['P', 'Pd', 'Pr', 'Pm', 'Pt', 'Pb', 'Po', 'Pa', 'Pu'],
    'K' => ['K', 'Kr'],
    'T' => ['Ti', 'Tc', 'Te', 'Tb', 'Tm', 'Ta', 'Tl', 'Th', 'Ts'],
    'V' => ['V'],
    'Z' => ['Zn', 'Zr'],
    'G' => ['Ga', 'Ge', 'Gd'],
    'R' => ['Rb', 'Ru', 'Rh', 'Re', 'Rn', 'Ra', 'Rf', 'Rg'],
    'Y' => ['Y', 'Yb'],
    'I' => ['In', 'I', 'Ir'],
    'X' => ['Xe'],
    'E' => ['Eu', 'Er', 'Es'],
    'D' => ['Dy', 'Db', 'Ds'],
    'W' => ['W'],
    'U' => ['U'],
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
