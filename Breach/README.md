# Puzzle
**Breach** https://www.codingame.com/training/expert/breach

# Goal
An anonymous game development company has hired you to break into a rival company's servers. Fortunately, your target decided to forego standard security software and instead implement a series of puzzles designed to be difficult to solve.   
You decide to use your programming skills to automate the solving of these puzzles.

From your initial probes, you have determined there are 10 different locks, grouped into 3 categories.  
- ss_f: int
- ss_m: int
- ss_n: int
- ss_asc: int
- ss_con: series, state machine, 1
- ss_colv: str
- rs_f: int
- rs_n: int
- rs_colv: str
- gs_m: str, 2

Your probes have also shown you what type of input these locks expect. They are listed in the table above.

Unfortunately, you don't know how to solve these locks. You need to figure out how to do so in order to complete this puzzle!

*Color Codes*  
Colors are represented by 2 characters: \u00AC and a char representing the color.  
There are 15 colors, along with 1 modifier:  
- GRAY: W
- WHITE: w
- RED: R
- LIGHT_RED: r
- GREEN: G
- LIGHT_GREEN: g
- BLUE: B
- LIGHT_BLUE: b
- YELLOW: y
- ORANGE: o
- PINK: P
- LIGHT_PINK: p
- VIOLET: V
- LIGHT_VIOLET: v
- CORRUPT: ?
- RESET (modifier): * - resets the color to the default (green)

Hint: Some locks require colors to be solved!

# Input
* The number of lines to read, numLines.
* Next numLines lines: a series of strings representing the raw lock.

# Output
* A single line containing the solution to the lock
