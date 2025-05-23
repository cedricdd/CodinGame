# Puzzle 
**1D Bush Fire** https://www.codingame.com/training/easy/1d-bush-fire

# Goal
A strip of bushland is on fire. An aerial firefighter is dispatched to the site to put out fire using water drops.

The bushland has an area of 1 x L unit length and each water drop is effective to put out fire in 3 consecutive unit cells.

For example, if a water drop is targeted at cell 4, by splash effect it will put out fire in cell 3, 4 and 5 at the same time.

```
 _ _ _ _ _ _ _ _
|_|_|f|f|f|_|_|_
 1 2 3 4 5 6 7
```

If the water drop is targeted at cell 1, fire in cell 1 and 2 will be put out.

Given the location of fire on the strip, you have to command the firefighter to put out all fire with the least number of water drops.

At this moment wind speed is very slow. You can assume the fire does not spread during your operation.

Move fast, Commander!

# Input
There are multiple tests in each testcase.

* Line 1: N, the number of tests to follow.
* The following N lines: each line is a string showing the status of each cell in a strip. The length of the line is the length of the strip.
  
Cells on fire are represented by 'f'. Cells without fire are represented by dots.

# Output
* Write N lines - for each line of input, write a number, the minimum number of water drops needed to put out all fire.

# Constraints
* 1 ≤ N ≤ 100
