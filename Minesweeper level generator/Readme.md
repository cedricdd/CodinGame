# Puzzle
**Minesweeper level generator** https://www.codingame.com/training/easy/minesweeper-level-generator

# Goal
You like to solve Minesweeper levels ? You will love generating them !

How to generate a level:
* A level is a width x height cells grid. Its origin is the top left corner. It contains n mines.
* The level is generated only when the player selects the first cell. The 3x3 cells square centered on this cell is always set free of mines.
* To generate a mine, X and Y grid coordinates (X first and then Y) are randomly generated until an available position is found. 
To generate X (resp. Y), use the random value modulo width (resp. height).

Controlling randomness

The random number generator used to generate the level is a pseudo random number generator (PRNG) initialized with a seed provided in the inputs.  
The PRNG works as follows:
```
R(n) = (214013 * R(n-1) + 2531011) / 65536
with R(0) = seed
R(1) is the first value to use.
```

With a seed of 31, the expected five first values produced by the PRNG are 139, 492, 1645, 5410, 17705.

You must use a single instance of PRNG for the whole generation. All calculations must be in 32-bit unsigned numbers.  
Beware that some languages (Python for instance) implicitly generate big integers without overflowing.

# Input
* A single line: width the level width, height the level height, n the number of mines for the level, x, y the coordinates of the first selected cell, seed the seed for the random number generator

# Output
* height lines: for each line, a row of cells starting from the top row. Each cell is represented by a single ASCII code without space between chars.

Cell format: 
* \# for a cell containing a mine
* \. for a cell without any mines next to it
* otherwise 1-8 for the number of neighboring cells containing mines

# Constraints
* 5 ≤ width ≤ 30
* 5 ≤ height ≤ 16
* 5 ≤ n ≤ 99
