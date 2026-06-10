<?php

function build(string $name) {
    global $targets, $actions, $prereqs, $output, $built;
    static $building = [];

    if(!isset($targets[$name])) return; //Nothing to do
    if(isset($building[$name])) die("[Circular dependencies detected]");

    $building[$name] = true; 
    $dependencies = [];

    foreach($targets[$name] as $dependency => $_) {
        if(!isset($built[$dependency])) $dependencies[] = $dependency;
    }

    sort($dependencies);

    foreach($dependencies as $dependency) build($dependency);

    foreach($actions[$name] ?? [] as $action) {
        $action = str_replace("$@", $name, $action);
        $action = str_replace("$<", array_key_first($targets[$name]), $action);
        $output[] = $action;
    }

    $built[$name] = true;
    unset($building[$name]);
}

fscanf(STDIN, "%d", $nTargets);

$targetsLine = explode(" ", trim(fgets(STDIN)));

fscanf(STDIN, "%d", $nLines);
$targets = [];
$actions = [];
$prereqs = [];
$output = [];
$build = [];

for ($i = 0; $i < $nLines; $i++) {
    $line = stream_get_line(STDIN, 1024 + 1, "\n");
    $line = preg_replace('/#.*$/', '', $line);
    $line = trim($line);

    if(strlen($line) == 0) continue;

    if(preg_match("/.*\:.*/", $line)) {
        [$T, $P] = array_map('trim', explode(":", $line));
      
        foreach(explode(" ", $T) as $target) {
            if(!isset($targets[$target])) $targets[$target] = [];
            $prereqs[$T] = $P;

            if(strlen($P) == 0) continue;

            foreach(explode(" ", $P) as $prereq) {
                $targets[$T][$prereq] = true;
            }
        }
    } //Actions
    else {
        foreach(explode(" ", $T) as $target) {
            $actions[$target][] = str_replace("$^", $P, $line);
        }
    }
}

if($nTargets == 0) $targetsLine = [array_key_first($targets)];

sort($targetsLine);

foreach($targetsLine as $target) build($target);

echo implode(PHP_EOL, $output) . PHP_EOL;
echo "[Build complete]" . PHP_EOL;
