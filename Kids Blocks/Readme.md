# Puzzle
**Kids Blocks** https://www.codingame.com/training/medium/kids-blocks

# Goal
The blocks pieces can be categorized into exactly THREE SUBSETS based on their widths:
- One inch pieces.
- Two inches pieces.
- and Three inches pieces.
All have the same height (One inch).


The problem is to determine if it is feasible to build a perfect rectangular wall (or square), with below conditions:
- Must use all pieces.
- The wall height must be two inches or more (two rows of blocks pieces at minimum).

Note 1: If all available pieces were of the same size, It is considered a correct solution to stack them vertically.  
But not a solution to just queue them horizontally.

The program takes three integers as inputs which are:  
x1 , x2, and x3 --> the count of pieces in each subset respectively.

The program should print either "POSSIBLE" or "NOT POSSIBLE" to indicate if a rectangular wall is buildable based on above rules.

Note 2: The given set of pieces might produce several solutions (different possible walls with different dimensions), so you can simply consider the wall is buildable once ANY solution found.

Example:
```
Pieces:

 5 × [_"_]
 2 × [_"____"_]
 1 × [_"____"____"_]
```

Examples of wall:
```
6×2

[_"_][_"_][_"____"____"_][_"_]
[_"____"_][_"_][_"____"_][_"_]


3×4

[_"_][_"_][_"_]
[_"_][_"____"_]
[_"____"_][_"_]
[_"____"____"_]
```

# Input
* Line 1: An integer x1 for the count of one-inch pieces (can be zero).
* Line 2: An integer x2 for the count of two-inches pieces (can be zero).
* Line 3: An integer x3 for the count of three-inches pieces (can be zero).

# Output
* A single line contains one string "POSSIBLE" or "NOT POSSIBLE".

# Constraints
* 0 ≤ x1, x2, x3 ≤ 30
* The wall should make use of all these pieces.
* The wall should consist of two rows or more (not a solution to just queue all pieces in one row!)
