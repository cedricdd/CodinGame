# Puzzle
**Pipes** https://www.codingame.com/contribute/view/770704f6a7a41813573d2a8249165ea48f065

# Goal
You must solve the classic Pipes puzzle.

Disaster!

The entire town's water infrastructure is severely damaged and needs repair. That's fine, you have skilled workers at hand, but due to flooding, all records of how the water is piped throughout the town has been lost, except one document which describes what kind of piping was installed for each block.

For example, you know that a given block was fed by a piping system that turns at a right-angle, and another is supplied with water and goes nowhere else.   
You do not know, however, in which orientation the pipe system was installed for any blocks.

You also know that the pipe system will never form a loop, and that it is entirely self-contained – the supply is within the town's borders, so no pipes need to leave the town.   
Finally, you know that pipes only ever connect to adjacent blocks on the cardinal directions (North, East, South, West) – not diagonally.

There is only way the pipes in each block can be oriented to solve these problems.

Good luck!

# Input
* Line 1: An integer n for the width and height of the town.
* Next n lines: n comma-separated block descriptors. 
* 1 indicates the block only connects along one edge. 
* 2 indicates the block connects at two adjacent edges. 
* 3 indicates the block connects at three edges. 
* | indicates the block connects at two opposing edges.

# Output
* 3n lines: a graphical depiction of the town's water supply system.

Each block is represented as a 3x3 square of characters. Pipes heading North/South should be indicated with the vertical bar | symbol.   
Pipes heading East/West should be indicated with the dash - symbol. Where no pipe is present, output a space character.

The centre of each block should represent the kind of junction between pipes. For a block with only one outgoing pipe, use o to represent a terminal.  
For a block with a straight pipe, use either | or - accordingly. For a block with two or three adjacent pipes, use +.  

For example, a block with pipes heading North, East and South (but not West) would be rendered as:
```
 | 
 +-
 | 
```
Note: you must output all spaces - do not trim.

# Constraints
* 3 ≤ n ≤ 9
