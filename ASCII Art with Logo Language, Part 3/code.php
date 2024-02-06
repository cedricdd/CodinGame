<?php

class Logo {
    private $angle;
    private $pen;
    private $symbols;
    private $coordinates;
    private $background;
    private $grid;
    private $gridInfo;

    function __construct() {
        $this->angle = 90;
        $this->pen = 1;
        $this->symbols = ["characters" => "#", "index" => 0];
        $this->coordinates = [0, 0];
        $this->background = " ";
        $this->grid = [];
        $this->gridInfo = ["maxX" => -INF, "minX" => INF, "maxY" => -INF, "minY" => INF];
    }

    //Turtle is changing direction
    public function changeAngle(int $angle) {
        $this->angle = ($this->angle + $angle + 360) % 360;
    }

    //We have run all the commands, print the logo
    public function draw() {
        $width = $this->gridInfo["maxX"] - $this->gridInfo["minX"] + 1;
        $lines = [];

        for($y = $this->gridInfo["minY"]; $y <= $this->gridInfo["maxY"]; ++$y) {
            $line = str_repeat($this->background, $width);

            foreach($this->grid[$y] ?? [] as $x => $c) $line[$x - $this->gridInfo["minX"]] = $c;

            $lines[] = rtrim($line);
        }

        //When we move North the Y coordinate increase but in the array moving "UP" decrease the value, we need to reverse the rows
        echo implode("\n", array_reverse($lines)) . PHP_EOL;
    }

    //Turle is moving
    public function move(int $turns) {
        [$x, $y] = $this->coordinates;
        $radiant = deg2rad($this->angle);

        //Pen is down, add symbol
        if($this->pen) {

            //Starting position
            [$x0, $y0] = [$x, $y];

            //Turtle doesn't leaves a symbols at the final position, we need to add them for $turns - 1
            [$x1, $y1] = [$x + round(($turns - 1) * cos($radiant), 0, PHP_ROUND_HALF_UP), $y + round(($turns - 1) * sin($radiant), 0, PHP_ROUND_HALF_UP)];

            //https://en.wikipedia.org/wiki/Bresenham%27s_line_algorithm
            $dx = abs($x1 - $x0);
            $sx = ($x0 < $x1) ? 1 : -1;
            $dy = -abs($y1 - $y0);
            $sy = ($y0 < $y1) ? 1 : -1;
            $error = $dx + $dy;

            while (true) {
                $this->grid[$y0][$x0] = $this->symbols["characters"][$this->symbols["index"]];
                $this->symbols["index"] = ($this->symbols["index"] + 1) % strlen($this->symbols["characters"]);

                //To display the results we need the min & max in both directions
                if($x0 < $this->gridInfo["minX"]) $this->gridInfo["minX"] = $x0;
                if($x0 > $this->gridInfo["maxX"]) $this->gridInfo["maxX"] = $x0;
                if($y0 < $this->gridInfo["minY"]) $this->gridInfo["minY"] = $y0;
                if($y0 > $this->gridInfo["maxY"]) $this->gridInfo["maxY"] = $y0;

                if ($x0 == $x1 && $y0 == $y1) break;

                $e2 = 2 * $error;

                if ($e2 >= $dy) {
                    if ($x0 == $x1) break;
                    $error += $dy;
                    $x0 += $sx;
                }
                if ($e2 <= $dx) {
                    if ($y0 == $y1) break;
                    $error += $dx;
                    $y0 += $sy;
                }
            }
        }

        //Update the final coordinate of the turtle
        $this->coordinates = [
            intval($x + round($turns * cos($radiant), 0, PHP_ROUND_HALF_UP)), 
            intval($y + round($turns * sin($radiant), 0, PHP_ROUND_HALF_UP))
        ];
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

//Replace the variables in the expression and evaluate it
function getExpressionValue(string $expression, array $variables): float {
    //Find all the variables
    preg_match_all("/:([a-zA-Z0-9_]+)/", $expression, $matches);

    //We need to replace the 'biggest' first so we don't replace a sub-part of another one by mistake
    usort($matches[1], function($a, $b) {
        return strlen($b) <=> strlen($a);
    });


    foreach($matches[1] as $match) {
        $expression = str_replace(":" . $match, $variables[$match] ?? 0, $expression);
    }

    return eval("return $expression;");
}

//We are calling a procedure
function runProcedure(string $name, float $value, array $variables) {
    global $procedures;

    [$param, $procedure] = $procedures[$name];
    $variables[$param] = $value;

    parse($procedure, $variables);
}

function parse(string $input, array &$variables) {
    global $logo, $procedures;

    $input = trim($input);
    if(empty($input)) return;

    $command = "";
    $count = 0;

    //Make sure the input ends with ;
    if($input[-1] != ";") $input .= ";";

    foreach(str_split($input) as $index => $c) {
        switch($c) {
            case "[": ++$count; break;
            case "]": --$count; break;
            case ";": 
                if($count == 0) {
                    $command = trim($command);
                    $cmd = substr($command, 0, 2);

                    if(strcasecmp($cmd, "RT") == 0)     $logo->changeAngle(getExpressionValue(substr($command, 3), $variables) * -1); //Turning right
                    elseif(strcasecmp($cmd, "LT") == 0) $logo->changeAngle(getExpressionValue(substr($command, 3), $variables)); //Turning left
                    elseif(strcasecmp($cmd, "SE") == 0) $logo->setSymbols(substr($command, 6)); //Changes the symbols printed
                    elseif(strcasecmp($cmd, "FD") == 0) $logo->move(getExpressionValue(substr($command, 3), $variables)); //Turtle is moving
                    elseif(strcasecmp($cmd, "CS") == 0) $logo->setBackground(substr($command, 3)); //Changes the background
                    elseif(strcasecmp($cmd, "PU") == 0) $logo->setPen(0); //PENUP
                    elseif(strcasecmp($cmd, "PD") == 0) $logo->setPen(1); //PENDOWN
                    //Assign a value to a variable
                    elseif(strcasecmp($cmd, "MK") == 0) {
                        [$name, $expression] = explode(" ", substr($command, 4));

                        $variables[$name] = getExpressionValue($expression, $variables);
                    } //Repeat a command
                    elseif(strcasecmp($cmd, "RP") == 0) {
                        preg_match("/^RP ([^\[]+)\s?\[(.*)\]$/i", $command, $matches);

                        $repeat = getExpressionValue($matches[1], $variables);

                        for($i = 0; $i < $repeat; ++$i) parse($matches[2], $variables);
                    } //Check a condition
                    elseif(strcasecmp($cmd, "IF") == 0) {
                        preg_match("/(.*) ([<=>]+) ([^\[]*) \[(.*)\]/", substr($command, 3), $matches);

                        //To evalutate equal we need 2 equals
                        if($matches[2] == "=") $matches[2] = "==";

                        //The expression to evaluate
                        $check = getExpressionValue($matches[1], $variables) . $matches[2] . getExpressionValue($matches[3], $variables);

                        if(eval("return (" . $check . ") ? 1 : 0;")) {
                            if(strcasecmp($matches[4], "stop") == 0) return; //We want to stop here
                            else parse($matches[4], $variables);
                        }
                    } //We are calling a procedure
                    else {
                        [$name, $expression] = explode(" ", $command);

                        //Something is wrong, we don't know that procedure
                        if(!isset($procedures[$name])) {
                            error_log("Undefined command: " . $command);
                            exit();
                        }

                        runProcedure($name, getExpressionValue($expression, $variables), $variables);
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
$command = "";
$variables = [];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $input = trim(fgets(STDIN));

    if($input[-1] != ";" && $input[-1] != "[") $input .= ";"; //Make sure it ends with ";"

    $command .= $input;
}

$procedures = [];

//Extract all the procedures
preg_match_all("/TO .*END;/iU", $command, $procedureMatches);

foreach($procedureMatches[0] as $procedure) {
    preg_match("/^([a-zA-Z0-9_]+) :([a-zA-Z0-9_]+);(.*)$/", substr($procedure, 3, -4), $matches);

    $procedures[$matches[1]] = [$matches[2], $matches[3]];

    $command = str_replace($procedure, "", $command); //Remove the procedure from the command
}

parse($command, $variables);
$logo->draw();
