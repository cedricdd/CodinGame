# Puzzle
**Maze for the champions** https://www.codingame.com/training/medium/maze-for-the-champions

# Goal
Your objective is to send the fastest champion to solve the maze. The champions have different capabilities and speed.
- The WARRIOR has no special capability but he is the fastest and he can cross a cell in 2 seconds!
- The DWARF can break walls if the wall thickness is only 1 cell. He needs 3 seconds to cross a cell.
- The ELF can make diagonal moves. Because he can make a lot of different moves, he must think twice before moving and it will cost 4 seconds to decide which move to make. 
When both give same result, prioritize straight moves as opposed to diagonal moves.
- The MAGE can fly straight forward as many cells as he wants without crossing any walls. 
Because of his long wizard robe, he moves very slowly and each cell marked will cost 5 seconds.

*Rules:*  
- Entry is given by an arrow (<, >, v, ^) that points inside the maze.
- Exit is given by an arrow (<, >, v, ^) that points outside the maze.
- Empty cells are shown with .
- Walls are shown with #
- The borders of the maze can't be broken by the dwarf.
- First step and last step are mandatory and can't be changed, even for the mage who needs to land on the end point.

Some Examples:

With WARRIOR:
```
Input      Output
#######    #######
#.....#    #.....#
>.....>    >>>>>>>
#.....#    #.....#
#######    #######
score: 14 (7 steps x 2 seconds)
```

With DWARF:
```
Input      Output
#######    #######
#...#.#    #...#.#
>.#.#.>    >>>>>>>
#.#...#    #.#...#
#######    #######
score: 21 (7 steps x 3 seconds)
```

With ELF:
```
Input      Output
#######    #######
#.....>    #...>>>
#.#.###    #.#o###
>..#..#    >>o#..#
#######    #######
score: 28 (7 steps x 4 seconds)
```

With MAGE:
```
Input      Output
#######    #######
#.....>    #....>>
#####.#    #####.#
>.....#    >....^#
#######    #######
score: 20 (4 x 5 seconds)
```

# Input
* Line 1: An integer W for the width of the maze
* Line 2: An integer H for the height of the maze
* Next H lines: Details for the maze

# Output
* Line 1: The champion and his score, separated with a space
* Next H lines: The complete maze with the path travelled by the champion. 
* The path is represented using the arrows denoting the directions (<, >, v, ^) except for the elf's diagonal moves which are denoted with o.

# Constraints
* All champions can complete all the mazes.
* There is always only one champion (no draw between two champions)
* 0 < W < 25
* 0 < H < 25
