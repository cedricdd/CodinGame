<?php

class Logo {
    private $angle;
    private $pen;
    private $symbols;
    private $coordinates;
    private $background;
    private $grid;

    function __construct() {
        $this->angle = 90;
        $this->pen = 1;
        $this->symbols = ["characters" => "#", "index" => 0];
        $this->coordinates = [0, 0];
        $this->background = " ";
        $this->grid = [];
    }

    //Turtle is changing direction
    public function changeAngle(int $angle) {
        $this->angle = ($this->angle + $angle + 360) % 360;

        //error_log("Angle is now: " . $this->angle);
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
        error_log("Turle is at " . $this->coordinates[0] . " " . $this->coordinates[1] . " " . $this->pen);

        [$x, $y] = $this->coordinates;
        $radiant = deg2rad($this->angle);
        [$x1, $y1] = [$x + round(($turns - 1) * cos($radiant), 0, PHP_ROUND_HALF_UP), $y + round(($turns - 1) * sin($radiant), 0, PHP_ROUND_HALF_UP)];

        //Pen is down, add symbol
        if($this->pen) {

            [$x0, $y0] = [$x, $y];

            //https://en.wikipedia.org/wiki/Bresenham%27s_line_algorithm
            $dx = abs($x1 - $x0);
            $sx = ($x0 < $x1) ? 1 : -1;
            $dy = -abs($y1 - $y0);
            $sy = ($y0 < $y1) ? 1 : -1;
            $error = $dx + $dy;

            error_log("angle " . $this->angle . " x0 $x0 y0 $y0 -- x1 $x1 y1 $y1");
            
            while (true) {
                error_log("$x0 $y0");
                $this->grid[$y0][$x0] = $this->symbols["characters"][$this->symbols["index"]];
                $this->symbols["index"] = ($this->symbols["index"] + 1) % strlen($this->symbols["characters"]);

                if ($x0 == $x1 && $y0 == $y1) break;

                $e2 = 2 * $error;

                error_log("e2 $e2 -- dy $dy dx $dx error $error");

                if ($e2 >= $dy) {
                    if ($x0 == $x1) break;
                    $error = $error + $dy;
                    $x0 = $x0 + $sx;
                }
                if ($e2 <= $dx) {
                    if ($y0 == $y1) break;
                    $error = $error + $dx;
                    $y0 = $y0 + $sy;
                }
            }
        }

        $this->coordinates = [$x + round($turns * cos($radiant), 0, PHP_ROUND_HALF_UP), $y + round($turns * sin($radiant), 0, PHP_ROUND_HALF_UP)];

        error_log("Turle is at " . $this->coordinates[0] . " " . $this->coordinates[1]);
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

function setVariable(string $name, string $expression) {
    global $variables;

    $variables[$name] = getExpressionValue($expression);

    //error_log("$name is now: " . $variables[$name]);
}

function getExpressionValue(string $expression): int {
    global $variables;

    //error_log("Expression is: $expression");

    //Replace all the variables
    preg_match_all("/:([a-z]+)/", $expression, $matches);

    //error_log(var_export($matches, true));

    foreach($matches[1] as $match) {
        $expression = str_replace(":" . $match, $variables[$match], $expression);
    }

    return eval("return $expression;");
}

function parse(string $input): void {

    global $logo;

    $input = trim($input);
    if(empty($input)) return;

    $command = "";
    $count = 0;

    //Make sure the input ends with ;
    if($input[-1] != ";") $input .= ";";

    //error_log(var_export($input, true));

    foreach(str_split($input) as $index => $c) {

        switch($c) {
            case "[": ++$count; break;
            case "]": --$count; break;
            case ";": 
                if($count == 0) {
                    $command = trim($command);
                    $cmd = substr($command, 0, 2);

                    error_log($command);

                    if(strcasecmp($cmd, "RT") == 0) $logo->changeAngle(getExpressionValue(substr($command, 3)) * -1); //Turning right
                    elseif(strcasecmp($cmd, "LT") == 0) $logo->changeAngle(getExpressionValue(substr($command, 3))); //Turning left
                    elseif(strcasecmp($cmd, "SE") == 0) $logo->setSymbols(substr($command, 6)); //Changes the symbols printed
                    elseif(strcasecmp($cmd, "FD") == 0) $logo->move(getExpressionValue(substr($command, 3))); //Turtle is moving
                    elseif(strcasecmp($cmd, "MK") == 0) {
                        [$name, $expression] = explode(" ", substr($command, 4));
                        setVariable($name, $expression);
                    } elseif(strcasecmp($cmd, "RP") == 0) {
                        preg_match("/^RP (.+)\s\[(.*)\]$/i", $command, $matches);

                        //error_log(var_export($matches));

                        $count = getExpressionValue($matches[1]);

                        for($i = 0; $i < $count; ++$i) {
                            parse($matches[2]);
                        }
                    } else {
                        error_log("$index undefined command: " . $command);
                        exit();
                    }

                    /*
                    if(strcasecmp($cmd, "RT") == 0) $logo->changeDirection(intdiv(intval(substr($command, 3)), ANGLE)); //Turning right
                    
                    elseif(strcasecmp($cmd, "PU") == 0) $logo->setPen(0); //PENUP
                    elseif(strcasecmp($cmd, "PD") == 0) $logo->setPen(1); //PENDOWN
                    
                    
                    elseif(strcasecmp($cmd, "CS") == 0) $logo->setBackground(substr($command, 3)); //Changes the background
                    
                    */

                    $command = "";
                    continue 2;
                }
                break;
        }

        $command .= $c;
    }
}

$logo = new Logo();
$command = "";
$variables = [];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $command .= parse(trim(fgets(STDIN)));
}

$logo->draw();
