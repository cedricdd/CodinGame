<?php

//Check if the current ordering will be successful 
function checkImports(array $imports) {
    global $dependencies;

    $loaded = [];

    foreach($imports as $name) {

        foreach($dependencies[$name] ?? [] as $dependency) {
            //We can't load $name, $dependency has not been loaded yet
            if(!isset($loaded[$dependency])) {
                echo "Import error: tried to import $name but $dependency is required." . PHP_EOL;
                reordering($imports);
                return;
            }
        }

        $loaded[$name] = 1;
    }

    echo "Compiled successfully!" . PHP_EOL;
}

//Try to re-order the imports
function reordering(array $imports) {
    global $dependencies;

    $loaded = [];

    sort($imports); //We want to always load the smallest (lexicographically) module

    while(count($imports)) {

        foreach($imports as $i => $name) {
            //Check if we can load this module
            foreach($dependencies[$name] ?? [] as $dependency) {
                if(!isset($loaded[$dependency])) continue 2;
            }

            $loaded[$name] = 1;
            unset($imports[$i]);
            continue 2;
        }

        exit("Fatal error: interdependencies.");
    }

    echo "Suggest to change import order:" . PHP_EOL;

    foreach($loaded as $name => $filler) echo "import $name" . PHP_EOL;
}

fscanf(STDIN, "%d", $nImp);
for ($i = 0; $i < $nImp; $i++) {
    $imports[] = str_replace("import ", "", trim(fgets(STDIN)));
}
fscanf(STDIN, "%d", $nDep);
for ($i = 0; $i < $nDep; $i++) {
    preg_match("/(.*) requires (.*)/", trim(fgets(STDIN)), $matches);

    foreach(explode(", ", $matches[2]) as $dependency) $dependencies[$matches[1]][] = $dependency;
}

checkImports($imports);
