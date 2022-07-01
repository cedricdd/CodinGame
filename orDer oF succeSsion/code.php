<?php
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s %s %d %s %s %s", $name, $parent, $birth, $death, $religion, $gender);

    $family[$parent][] = [$name, $birth, $death, $religion, $gender];
}

function succession(array $branch) {
    global $family;

    //Order branch, M first, then by year of birth ASC
    usort($branch, function($a, $b) {
        if($a[4] == $b[4]) return $a[1] <=> $b[1];
        else return $b[4] <=> $a[4];
    });

    foreach($branch as $people) {
        //Still alive & not catholic
        if($people[2] == "-" && $people[3] != "Catholic") echo $people[0] . "\n";

        //Do descendants of current person if there's any 
        if(isset($family[$people[0]])) succession($family[$people[0]]);
    }
}

echo succession($family['-']);
?>
