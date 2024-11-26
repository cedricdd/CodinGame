# Puzzle
**Flip The Sign** https://www.codingame.com/training/easy/flip-the-sign

# Goal
You're in the middle of a chase after the famous thief "James".  
You hear a slamming of a door and realize he has passed through the door to your left.  
You run to the door and find a keyboard next to the door that has only two options: true or false.  
You notice a bomb on your right and find that you have exactly two minutes to enter the correct answer without exploding, you have only one attempt.  
You look for clues and you find a sheet of paper with numbers arranged in the form of a grid and letters arranged in the form of a grid and a sign of plus and a sign of minus next to it.  
In that moment you realize what you need to do.

You get 2 grids with the same height and width, one is filled with integers (non-zero) and the other one contains the characters 'X' and '0'.   
After taking all the integers from the first grid that correspond to an X in the second grid, sequentially row by row and left to right, output true if those integers alternate sign at each step, otherwise output false.

Example 1:
```
height = 5, width = 4

 12 -1   4   -21
 3   8   99   4
 96 -92  1   -31
 18 -69 -15   26
 23  7  -77  -73


X X X X
0 0 0 0
0 0 0 0
0 0 0 0
0 0 0 0
```

Going row by row and left to right, following the 'X' marks we get this sequence of integers: 12, -1, 4, -21.

We can see that each number has a sign opposite from the previous one:  
-1 is negative and the previous one, 12, is positive.  
4 is positive and the previous one, -1, is negative.  
-21 is negative and the previous one, 4, is positive.  
Thus this sequence alternates sign at each step and the output is true.  

Example 2:
```
height = 3, width = 5

  36   324   -140   33    37
  115 -289   -225  -372   6
 -302  198   -403  -202   48


X X X X X
0 X X X 0
0 0 X 0 0
```

Going row by row and left to right, following the 'X' marks we get this sequence of integers: 36, 324, -140, 33, 37, -289, -225, -372, -403.

We can see that not each number has a sign opposite from the previous one:  
324 is positive and the previous one, 36, is also positive.  
Thus this sequence does not alternate sign at each step and the output is false.  

Note: the examples aligned for ease of understanding.  
In real case there is just one space between each integer.

# Input
* Line 1: two space-separated integers : height and width
* Next height lines: a line of spaced integers (non-zero). (length of line: width)
* Next height lines: a line of spaced characters ('X' or '0'). (length of line: width)

# Output
* true or false.

# Constraints
* 2 ≤ height ≤ 60
* 2 ≤ width ≤ 90
* There is no zero in the first grid.
