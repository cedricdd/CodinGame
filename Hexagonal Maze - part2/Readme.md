# Puzzle
**Hexagonal Maze - part2** https://www.codingame.com/training/medium/hexagonal-maze---part2

# Goal
You are in a maze, made of hexagonal cells.  
The following grid :
```
4 4
ABCD
EFGH
IJKL
MNOP
```

has to be understood like this :
```
A B C D  (line 0)
 E F G H (line 1)
I J K L  (line 2)
 M N O P (line 3)
```

This means each cell has 6 neighbours : for example, cell F is surrounded by B, C, E, G, J, K.  
Even lines are left-aligned, odd lines are right-aligned.  
You don't have to deal with borders : the grid isn't periodic and there are only walls on the borders.  

The grid contains following symbols:  
* \# : wall
* . : free space
* S : start
* E : end
* _ : sliding floor
* Uppercase letters A, B, C, D : Closed doors
* Lowercase letters a, b, c, d : Keys which open doors

What is a sliding floor ? when you walk on a sliding floor, you just walk straight in the same direction until you are on a free space or in front of a wall.  
You take a key by walking on the cell (no more action). The key is like a free space (not sliding).  
Closed doors are like a wall if you didn't take the key, and like a free space (not sliding) if you took key. A key only open the door with corresponding letter (a for A etc...).   
There may be several doors A for one key a, in this case the key open all the doors with corresponding letter.  

In this puzzle, you have to output the directions used in order to go from the start to the end on the shortest path.  
There are 6 directions, combining Left, Right, Up and Down. These 6 directions are: UL, UR, L, R, DL, DR.  
U and D aren't directions, because of the hexagonal grid.  

You don't have to output directions if you are sliding (see the example).  
There is always a solution.  
There may be more than one path, but only one shortest path.  
The "shortest" path is counted by the number of directions given, not by the number of cells.   
Sliding on 10 consecutive cells is shorter than walking on 3 free spaces.  

# Input
* First line: two integers w and h, width and height of the grid.
* h following lines: the grid.

# Output
* Space separated directions to follow, within UL, UR, L, R, DL, DR

# Constraints
* 4 ≤ w, h ≤ 40
