# Puzzle
**Mining mice** https://www.codingame.com/contribute/view/94296b19e666875100fc89db167f8dff85c24

# Goal
A scientist is studying how a certain species of mice dig holes in the ground.

He builds a cubical tank with dimensions 25 x 25 x 25 (dm³) and puts inside it a 3-dimensional metal grid. The grid delineates the edges of all 1 x 1 x 1 (dm³) small cubes inside the tank. The remaining empty space is filled with dense soil.

The scientist places one mouse at a time on the center square of the tank's top-face.  
Mice can move in any of these directions:
- U : up;
- D : down;
- F : front of the tank;
- B : back of the tank;
- R : right of the tank;
- L : left of the tank;

Every move, the mouse moves to the adjacent 1 x 1 x 1 (dm³) small cube in the given direction, if it is filled with soil the mouse digs removing all the soil in the small cube. Mice never fall and can always move in the desired direction because of the metal grid. It is guaranteed that a mouse which is on the top-face of the tank doesn't go further up and that it never goes outside the other boundaries of the tank.

You are given the n number of mice and for every mouse a string moves representing the sequence of moves they make in the tank until they are removed. Your task is to calculate the volume in dm³ of the remaining soil in the tank at the end of the study.

# Input
* Line 1: an integer n representing the number of mice
* Next n lines: a string moves representing the sequence of moves in the tank of the single mouse

# Output
* An integer volume representing the volume in dm³ of the remaining soil in the tank

# Constraints
* 1 ≤ n ≤ 100
* 10 ≤ length of moves ≤ 50
