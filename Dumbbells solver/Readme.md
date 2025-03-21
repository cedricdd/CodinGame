# Puzzle
**Dumbbells solver** https://www.codingame.com/training/hard/dumbbells-solver

# Goal
Dumbbells o-o should be stored in a big box.

Each dumbbell occupies three squares aligned horizontally or vertically: the boxes on both ends contain the weights, the bar is placed in the central square.  
The dumbbells can touch but not cross each other.  
Each box contains at most one weight, each weight being the end of a single dumbbell.  
The weight locations are marked at the bottom of the box. Unfortunately, some of them have been erased.  

Find the dumbbells in the grid (the number of dumbbells to put in the box is indicated above).  
All problems have a unique solution.  

Example

With this grid:  
```
....
o...
..oo
```

there are two dumbbells easy to find (1 horizontal and 1 vertical):
```
...o
o-o|
..oo
```

Now, we can find a new horizontal dumbbell:
```
...o
o-o|
o-oo
```

If there were 3 dumbbells to find, that would be the final solution...

But, if there were 4 dumbbells to find, the final solution would be:
```
o-oo
o-o|
o-oo
```

# Input
* Line 1 : Number n of dumbells.
* Line 2 : height h and width w of the grid.
* h following lines: the content of the grid of dumbells. (. or o)

# Output
* h lines : with only ., o, | or -  
o  
| for a vertical dumbell, o-o for a horizontal dumbell, . for a empty square  
o  

# Constraints
* 3 <= n <= 15
* 3 <= h, w <= 8
