<?php

function build(string $name): array {
    global $targets, $actions, $prereqs, $files;
    static $building = [], $builded = [];
    $result = [];

    if(isset($builded[$name])) return []; //Already builded

    if(!isset($targets[$name])) return []; //There's nothing to do for this file
    
    if(isset($building[$name])) die("[Circular dependencies detected]");

    $building[$name] = true; 
    $dependencies = [];

    //Find all the dependencies to build
    foreach(($targets[$name] ?? []) as $dependency => $_) {
        if(!isset($builded[$dependency])) $dependencies[] = $dependency;
    }

    sort($dependencies); //We build them in alpha order

    foreach($dependencies as $dependency) $result = array_merge($result, build($dependency));

    $builded[$name] = true;
    unset($building[$name]);

    if(isset($files[$name])) {
        $upToDate = true;

        foreach(($prereqs[$name] ?? []) as $prereq) {
            //File isn't up to date, we need to build it
            if(isset($files[$prereq]) && $files[$prereq] >= $files[$name]) {
                $upToDate = false;
                break;
            }
        }

        if($upToDate) return [];
    }

    foreach($actions[$name] ?? [] as $action) $result[] = trim(str_replace("$@", $name, $action));

    $files[$name] = PHP_INT_MAX;

    return $result;
}

fscanf(STDIN, "%d", $nFiles);
for ($i = 0; $i < $nFiles; $i++) {
    fscanf(STDIN, "%s %d", $preexistingFile, $fileTime);

    $files[$preexistingFile] = $fileTime;
}

fscanf(STDIN, "%d", $nGoalTargets);

$goalTarget = explode(" ", trim(fgets(STDIN)));

fscanf(STDIN, "%d", $nLines);
$targets = [];
$actions = [];
$prereqs = [];
$output = [];

for ($i = 0; $i < $nLines; $i++) {
    $line = stream_get_line(STDIN, 1024 + 1, "\n");
    $line = preg_replace('/#.*$/', '', $line);
    $line = trim($line);

    if(strlen($line) == 0) continue;

    if(preg_match("/.*\:.*/", $line)) {
        [$T, $P] = array_map('trim', explode(":", $line));
      
        foreach(explode(" ", $T) as $target) {
            if(!isset($targets[$target])) $targets[$target] = [];

            $prerequisites = explode(" ", $P);

            $prereqs[$T] = array_merge($prerequisites, ($prereqs[$T] ?? []));

            if(strlen($P) == 0) continue;

            foreach(explode(" ", $P) as $prereq) {
                $targets[$T][$prereq] = true;
            }
        }
    } //Actions
    else {
        foreach(explode(" ", $T) as $target) {
            $line = str_replace("$^", $P, $line);
            $line = str_replace("$<", reset($prerequisites), $line);

            $actions[$target][] = $line;
        }
    }
}

foreach($goalTarget as $target) {
    $output = array_merge($output, build($target));
}

//Check targets that are not being built for unreachable cycle detection
foreach($targets as $target => $_) build($target);

if($output) echo implode(PHP_EOL, $output) . PHP_EOL;
echo "[Build complete]" . PHP_EOL;
