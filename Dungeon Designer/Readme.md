# Puzzle
**Dungeon Designer** https://www.codingame.com/training/expert/dungeon-designer

# Goal
The adventurers have raided the dungeon. They've destroyed almost everything with multiple fireballs: doors, traps and monsters. And they've stolen the treasure! Their levels were probably too high.  
Luckily, at the last moment the Dungeon Master invoked gigantic cavern trolls that slew those pesky adventurers in order to secure the stolen gold. But in the battle, the rest of the dungeon has collapsed.

The Dungeon Master asks you, his trusted servant, to redesign the dungeon. He wants to better hide the treasure, so there is more time to react the next time the dungeon is raided.

The dungeon has a rectangular shape, W cells wide by H cells high, with the adventurers' entrance in the north west corner, so it's a good fit to create a labyrinth in.

You find a relatively simple algorithm : in each cell except the eastern and southern ones, the building slaves will toss a coin. If “heads” they will build a wall to the east; if “tails” they will build a wall to the south.

This creates a simple maze, with long corridors in the south and east since no wall is built from x=W-1 or y=H-1. The monsters barracks being on the south east corner, this makes for a perfect confrontation stage.

After designing this labyrinth, you need to find the location furthest away from the adventurers' entrance : that's where the treasure T will be hidden. Then you need to mark with an X the spot where the garrisoned monsters can easily intercept any adventurer : the point of the entrance-treasure path closest to the barracks. If the closest point is already the treasure's location, place only a T.

Your Master will be proud of you.

Note 1: You are asked to draw the maze formed from a W‍×‍H cell grid. Each cell of the grid may have a wall # to the north, east, west or south, which leads to a (2×H+1)‍×‍(2×W+1) map:
```
Grid 2×2  Map 5×5
           #.###
   .T      #.#T#
   .X      #.#.#
           #..X#
           ###.#
```

Note 2: For the reproducibility of the map across languages, you are given two primes P and Q, and a seed R, and you will generate pseudo-random numbers using the Blum Blum Shub algorithm (its name goes well with the theme… more information here: https://en.wikipedia.org/wiki/Blum_Blum_Shub )
Tossing a coin in (x,y) (where (0,0) is the top left corner): compute ```(R^(2^(x+y×W+1) mod lcm(P-1,Q-1)) mod P×Q)```.  
If odd (“heads”) build a wall to the east; if even (“tails”) build a wall to the south.

Note 3: Take care that the expression given above for Blum Blum Shub, taken literally, involves numbers greater than can fit in 64 bits. You are invited to optimize it. :-)

# Input
* Line 1: Size of the labyrinth W and H as integers
* Line 2: Random number generator arguments P, Q and R

# Output
* 2×H+1 lines: The labyrinth map, with . for empty passage, # for a wall, T for the treasure, and X for the monster's intersection with the adventurers' way back.
* There is wall all around the maze, except for an empty passage . on the north of cell 0,0, and to the south of cell W-1, H-1.

# Constraints
* 0 < H, W ≤ 40
* 1000 < P, Q ≤ 3000
* 0 < R ≤ 100000
* There is only one position where the treasure is furthest away from the entrance.
* The treasure is forbidden from being in the entrance or in the passage to the monsters' barracks.
