<?php

const ANGLE = 45;
const DIRECTIONS = [[0, -1], [1, -1], [1, 0], [1, 1], [0, 1], [-1, 1], [-1, 0], [-1, -1]];

class Logo {
    private $direction;
    private $pen;
    private $symbols;
    private $coordinates;
    private $background;
    private $grid;

    function __construct() {
        $this->direction = 0;
        $this->pen = 1;
        $this->symbols = ["characters" => "#", "index" => 0];
        $this->coordinates = ["x" => 0, "y" => 0];
        $this->background = " ";
        $this->grid = [];
    }

    //Turtle is changing direction
    public function changeDirection(int $turns) {
        $this->direction = ($this->direction + $turns + 8) % 8;
    }

    //We have run all the commands, print the logo
    public function draw() {
        //We need the coordinates of the top left & bottom right of the art generated
        $minY = min(array_keys($this->grid));
        $maxY = max(array_keys($this->grid));
        $minX = INF;
        $maxX = -INF;

        foreach($this->grid as $y => $line) {
            $minX = min(min(array_keys($line)), $minX);
            $maxX = max(max(array_keys($line)), $maxX);
        }

        $width = $maxX - $minX + 1;

        for($y = $minY; $y <= $maxY; ++$y) {
            $line = str_repeat($this->background, $width);

            foreach($this->grid[$y] ?? [] as $x => $c) $line[$x - $minX] = $c;

            echo rtrim($line) . PHP_EOL;
        }
    }

    //Turle is moving
    public function move(int $turns) {
        [$xm, $ym] = DIRECTIONS[$this->direction];

        for($i = 0; $i < $turns; ++$i) {
            //Pen is down, add symbol
            if($this->pen) {
                $this->grid[$this->coordinates["y"]][$this->coordinates["x"]] = $this->symbols["characters"][$this->symbols["index"]];
                $this->symbols["index"] = ($this->symbols["index"] + 1) % strlen($this->symbols["characters"]);
            }
    
            $this->coordinates["x"] += $xm;
            $this->coordinates["y"] += $ym;
        }

    }

    //Set background of the logo
    public function setBackground(string $value) {
        $this->background = $value;
    }

    //Set the status of the pen
    public function setPen(int $value) {
        $this->pen = $value;
    }

    //Set the characters used by the pen
    public function setSymbols(string $value) {
        $this->symbols["characters"] = $value;
        $this->symbols["index"] = 0;
    }
}

function parse(string $input): void {

    global $logo;

    if(empty($input = trim($input))) return;

    $command = "";
    $count = 0;

    foreach(str_split($input . ";") as $c) {

        switch($c) {
            case "[": ++$count; break;
            case "]": --$count; break;
            case ";": 
                if($count == 0) {
                    $cmd = substr($command, 0, 2);

                    if(strcasecmp($cmd, "RT") == 0) $logo->changeDirection(intdiv(intval(substr($command, 3)), ANGLE)); //Turning right
                    elseif(strcasecmp($cmd, "LT") == 0) $logo->changeDirection(intdiv(intval(substr($command, 3)) * -1, ANGLE)); //Turning left
                    elseif(strcasecmp($cmd, "PU") == 0) $logo->setPen(0); //PENUP
                    elseif(strcasecmp($cmd, "PD") == 0) $logo->setPen(1); //PENDOWN
                    elseif(strcasecmp($cmd, "FD") == 0) $logo->move(intval(substr($command, 3))); //Turtle is moving
                    elseif(strcasecmp($cmd, "SE") == 0) $logo->setSymbols(substr($command, 6)); //Changes the symbols printed
                    elseif(strcasecmp($cmd, "CS") == 0) $logo->setBackground(substr($command, 3)); //Changes the background
                    elseif(strcasecmp($cmd, "RP") == 0) {
                        preg_match("/^RP ([0-9]+)\s?\[(.*)\]$/i", $command, $matches);

                        for($i = 0; $i < $matches[1]; ++$i) {
                            parse($matches[2]);
                        }
                    }

                    $command = "";
                    continue 2;
                }
                break;
        }

        $command .= $c;
    }
}

$logo = new Logo();

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    parse(trim(fgets(STDIN)));
}

$logo->draw();
