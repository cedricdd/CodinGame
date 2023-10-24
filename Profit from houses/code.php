<?php

const STATES = ["Alabama" => "168.29", "Alaska" => "225.15", "Arizona" => "252.78", "Arkansas" => "152", "California" => "425.55", "Colorado" => "287.11", "Connecticut" => "260.28", "Delaware" => "226.86", "Florida" => "278.1", "Georgia" => "181", "Hawaii" => "681.09", "Idaho" => "262.82", "Illinois" => "183.2", "Indiana" => "154.63", "Iowa" => "195.81", "Kansas" => "150.37", "Kentucky" => "159.5", "Louisiana" => "152.44", "Maine" => "261.59", "Maryland" => "223.45", "Massachusetts" => "417.45", "Michigan" => "180.3", "Minnesota" => "200.66", "Mississippi" => "142", "Missouri" => "165.76", "Montana" => "309.35", "Nebraska" => "168.25", "Nevada" => "246.07", "New Hampshire" => "278.31", "New Jersey" => "310.26", "New Mexico" => "191.43", "New York" => "416.33", "North Carolina" => "202.96", "North Dakota" => "161.89", "Ohio" => "147.73", "Oklahoma" => "162.33", "Oregon" => "302.36", "Pennsylvania" => "174.65", "Rhode Island" => "325.85", "South Carolina" => "182.87", "South Dakota" => "199.99", "Tennessee" => "211.36", "Texas" => "189.3", "Utah" => "239.14", "Vermont" => "234.88", "Virginia" => "218", "Washington" => "315.38", "West Virginia" => "133.72", "Wisconsin" => "207.64", "Wyoming" => "207.64"];

$undervalued = [];

fscanf(STDIN, "%d", $numOfHouses);
for ($i = 0; $i < $numOfHouses; $i++) {
    preg_match("/\(([0-9]+)\) ([0-9]+) sqFt house for \\$([0-9,]+) in ([a-zA-Z ]+)/", trim(fgets(STDIN)), $infos);

    $difference = round(intval(str_replace(",", "", $infos[3])) - floatval(STATES[$infos[4]]) * floatval($infos[2]));

    //We only want houses undervalued by at least 25k
    if($difference <= -25000) {
        $undervalued[$infos[1]] = abs($difference);
    }
}

arsort($undervalued);

foreach($undervalued as $id => $value) {
    echo "(" . $id . ") is undervalued by $" . number_format($value) . PHP_EOL;
}

echo "Total potential profit is $" . number_format(array_sum($undervalued)) . PHP_EOL;
