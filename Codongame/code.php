<?php

const CODON = [
    "UUU" => "F",
    "CUU" => "L",
    "AUU" => "I",
    "GUU" => "V",
    "UUC" => "F",
    "CUC" => "L",
    "AUC" => "I",
    "GUC" => "V",
    "UUA" => "L",
    "CUA" => "L",
    "AUA" => "I",
    "GUA" => "V",
    "UUG" => "L",
    "CUG" => "L",
    "AUG" => "M",
    "GUG" => "V",
    "UCU" => "S",
    "CCU" => "P",
    "ACU" => "T",
    "GCU" => "A",
    "UCC" => "S",
    "CCC" => "P",
    "ACC" => "T",
    "GCC" => "A",
    "UCA" => "S",
    "CCA" => "P",
    "ACA" => "T",
    "GCA" => "A",
    "UCG" => "S",
    "CCG" => "P",
    "ACG" => "T",
    "GCG" => "A",
    "UAU" => "Y",
    "CAU" => "H",
    "AAU" => "N",
    "GAU" => "D",
    "UAC" => "Y",
    "CAC" => "H",
    "AAC" => "N",
    "GAC" => "D",
    "UAA" => "Stop",
    "CAA" => "Q",
    "AAA" => "K",
    "GAA" => "E",
    "UAG" => "Stop",
    "CAG" => "Q",
    "AAG" => "K",
    "GAG" => "E",
    "UGU" => "C",
    "CGU" => "R",
    "AGU" => "S",
    "GGU" => "G",
    "UGC" => "C",
    "CGC" => "R",
    "AGC" => "S",
    "GGC" => "G",
    "UGA" => "Stop",
    "CGA" => "R",
    "AGA" => "R",
    "GGA" => "G",
    "UGG" => "W",
    "CGG" => "R",
    "AGG" => "R",
    "GGG" => "G",
];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $rna = trim(fgets(STDIN));

    error_log($rna);

    for($indice = 0; $indice < 3; ++$indice) {

        $sequence = "";
        $state = 0;
        $sequences[$indice] = [0, []];

        //Go through the rna
        for($s = $indice; $s <= strlen($rna) - 3; $s += 3) {
            $codon = substr($rna,$s, 3);

            //Starting a new sequence
            if($codon == "AUG") $state = 1;

            //Ending a sequence
            if(CODON[$codon] == "Stop" && $state) {
                $sequences[$indice][0] += strlen($sequence);
                $sequences[$indice][1][] = $sequence;

                $sequence = "";
                $state = 0;
            } //Add into the sequence
            elseif($state) $sequence .= CODON[$codon];
        }
    }

    //We sort by number of amino acids
    usort($sequences, function($a, $b) {
        return $a[0] <=> $b[0];
    });

    echo implode("-", end($sequences)[1]) . PHP_EOL;
}
