<?php

class Direct {
    public $name;
    public $parent;
    public $childrens;

    public function __construct($parent, string $name) {
        $this->parent = $parent;
        $this->childrens = [];
        $this->name = $name;
    }

    public function addDirectory(string $name) {
        $this->childrens[$name] = new Direct($this, $name);
    }
}

$root = new Direct(null, "root");
$current = $root;
$success = false;

fscanf(STDIN, "%d", $n);

for ($i = 0; $i < $n; $i++) {
    $line = stream_get_line(STDIN, 100 + 1, "\n");

    if($line == "pwd") {
        $d = $current;

        //If we are in the exit directory of if we have a direct line to it
        while($d->name != "root") {
            if($d->name == "exit") {
                $success = true;
                break;
            }

            $d = $d->parent;
        }
    } //Creating a new directory 
    elseif(preg_match('/^mkdir (.*)$/', $line, $match)) {
        $name = $match[1];

        $current->addDirectory($name);
    } elseif(preg_match('/^cd (.*)$/', $line, $match)) {
        $name = $match[1];

        //Moving back up
        if($name == "..") {
            if($current->name != "root") {
                $current = $current->parent;
            }
        } else {
            //Trying to pass into a directory that doesn't exist
            if(!isset($current->childrens[$name])) {
                exit("TRAPPED");
            }

            $current = $current->childrens[$name];
        }
    }
}

echo ($success ? "YOU ESCAPED" : "LOST") . PHP_EOL;
