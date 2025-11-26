# Puzzle
**Chocolate Bar Cut** https://www.codingame.com/training/easy/chocolate-bar-cut

# Goal
You have a rectangular chocolate bar divided into X × Y square pieces.  
You make one straight cut from the top-left corner to the bottom-right corner of the bar.  

A piece of chocolate is counted if the cut actually passes through its interior.  
If the cut only slices a piece exactly at a corner, it does not count  

Your task is to compute how many chocolate pieces are cut.

For example, when cutting a 4×4 chocolate bar, these 4 squares are cut:
```
1 . . .
. 2 . .
. . 3 .
. . . 4
```

With a 4×5 chocolate bar, the cut passes through 8 squares:
```
1 2 . . .
. 3 4 . .
. . 5 6 .
. . . 7 8
```

And cutting a 2×5 chocolate bar results in 6 cut squares:
```
1 2 3 . .
. . 4 5 6
```

For a visual illustration of a diagonal crossing squares in a grid, you may refer to: https://i.sstatic.net/4eMfq.gif.

# Input
* Line 1: An integer N for the number of chocolate bars.
* Next N lines: Two space-separated integers X and Y for the dimensions of the chocolate bar.

# Output
* N lines: One integer per line: the number of squares sliced by the cut.

# Constraints
* 1 ≤ N ≤ 50
* 0 < X,Y < 10^12
