# Puzzle
**Tetris Floor** https://www.codingame.com/contribute/view/785560e94a66b6ca0749b7537fc7097ba2a5b

# Goal
You are working for a construction company, your new task is to optimize the construction of floors by finding the cheapest way to build them.   
The owner of the only supplier of floor blocks is a big fan of the game Tetris and for this reason all the blocks they produce are shaped like the pieces of the game.   
The price of each type of block varies with time but the supplier can provide you as many blocks as you want.  

These are the blocks you can use:
```
Type 1:   Type 2:   Type 3:   Type 4:   Type 5:   Type 6:   Type 7:
####      ##        ###       ###       ###       ##         ##
          ##         #        #           #        ##       ##
```


You have thought about simply ordering only the cheapest type and breaking them down to 1x1 blocks to let you pave any kind of floor.   
However, that can be risky - a competitor who did so received a lot of complaints from customers when they saw cracks in the blocks!   
While breaking floor blocks isn't an option, rotating them is perfectly fine.  

Some parts of the floor will already be occupied, by walls, pillars, etc and don't need to be covered but everywhere else has to be, as you can't leave holes and clients wouldn't be happy with that.

In addition to finding the cheapest set of blocks to order you also need to report in how many ways the floor can be paved with this set of blocks.

For example with:  
Width & Height = 7 7  
Prices of each type of blocks = 6.49 18.69 22.89 35.07 54.23 66.87 79.26  
```
#######
#.....#
#.....#
#..#..#
#.....#
#.....#
#######
```

The result is:  
Minimum price to pave the floor = 96.10  
The number of each type of blocks to use = 4 0 0 2 0 0 0  
Number of ways to pave the floor = 6  

The 6 ways to place the blocks being:
```
#######   #######   #######   #######   #######   #######
#----|#   #----|#   #|----#   #|----#   #||+--#   #|----#
#||-+|#   #|+--|#   #||-+|#   #|+--|#   #|||||#   #|----#
#||#||#   #||#||#   #||#||#   #||#||#   #||#||#   #+-#-+#
#|+-||#   #|--+|#   #|+-||#   #|--+|#   #|||||#   #----|#
#|----#   #|----#   #----|#   #----|#   #--+||#   #----|#
#######   #######   #######   #######   #######   #######
```

The set of blocks with the cheapest price will be unique in all the tests.

# Input
* Line 1: 2 space-separated integers, W & H, the width & height of the floor.
* Line 2: 7 space-separated floats (P1 to P7), the price of each type of blocks.
* Next H lines: Characters representing the floor, . represents a space to pave & # represents a space already occupied.

# Output
* Line 1: The price to pave the floor. (float with 2 decimal places)
* Line 2: The quantity of each type of blocks needed to pave the floor, separated by a space. Q1 Q2 Q3 Q4 Q5 Q6 Q7
* Line 3: The number of ways to pave the floor with the set of blocks.

# Constraints
* 7 <= W <= 100
* 7 <= H <= 100
* 0.0 <= P1 to P7 <= 100.0
