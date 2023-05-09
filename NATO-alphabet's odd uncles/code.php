<?php

const ALPHABET = [
    0 => ["Authority","Bills","Capture","Destroy","Englishmen","Fractious","Galloping","High","Invariably","Juggling","Knights","Loose","Managing","Never","Owners","Play","Queen","Remarks","Support","The","Unless","Vindictive","When","Xpeditiously","Your","Zigzag"],
    1 => ["Apples","Butter","Charlie","Duff","Edward","Freddy","George","Harry","Ink","Johnnie","King","London","Monkey","Nuts","Orange","Pudding","Queenie","Robert","Sugar","Tommy","Uncle","Vinegar","Willie","Xerxes","Yellow","Zebra"],
    2 => ["Amsterdam","Baltimore","Casablanca","Denmark","Edison","Florida","Gallipoli","Havana","Italia","Jerusalem","Kilogramme","Liverpool","Madagascar","New-York","Oslo","Paris","Quebec","Roma","Santiago","Tripoli","Uppsala","Valencia","Washington","Xanthippe","Yokohama","Zurich"],
    3 => ["Alfa","Bravo","Charlie","Delta","Echo","Foxtrot","Golf","Hotel","India","Juliett","Kilo","Lima","Mike","November","Oscar","Papa","Quebec","Romeo","Sierra","Tango","Uniform","Victor","Whiskey","X-ray","Yankee","Zulu"],
];

$words = explode(" ", trim(fgets(STDIN)));

foreach(ALPHABET as $i => $list) {
    //This is the alphabet currently used
    if(count(array_diff($words, $list)) == 0) {
        foreach($words as $word) $answer[] = ALPHABET[($i + 1) % 4][ord($word[0]) - 65];
    }
}

echo implode(" ", $answer) . PHP_EOL;
