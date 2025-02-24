# Puzzle
**Unfolding Paper** https://www.codingame.com/training/expert/unfolding-paper

# Goal
A sheet of paper is folded left-to-right then up-to-down N times.  
Then you cut out a few shapes and unfold the sheet.  

The task is to determine how many parts the sheet will break up to.

*Explanations*  
Lets look at the example. It is a sheet of two pieces. One piece is one or more connected #'s. Note that cells adjacent diagonally are not connected.
```
###
#..
#.#
```

Unfolding works as follow:  
1) Down-to-up  
```
#.#
#..
###
###
#..
#.#
```

2) Right-to-left  
```
#.##.#
..##..
######
######
..##..
#.##.#
```

3) Go to 1, repeat N-1 times.

In this case N=1, so after unfolding there will be 5 pieces (four in the corners and one in the center).

Note that there are always as many horizontal folds as vertical ones: the number N of folds is really a number of double folds, once in each direction.

# Input
* Line 1: Single integer N.
* Line 2: Two space-separated integers W and H represent width and height of the folded sheet respectively.
* Next H lines: W characters, where . is hole and # is paper.

# Output
* Line 1: An integer M – the number of parts.

# Constraints
* 1 ≤ W, H ≤ 100
* 1 ≤ N ≤ 10000
* 1 ≤ M ≤ 2³¹
