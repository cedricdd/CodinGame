# Puuzle
**Christmas Tree** https://www.codingame.com/training/medium/christmas-tree

# Goal
"Extreme tree.." testcases might be harder to solve, if language of your choice out of the box do not support numbers bigger than 9223372036854775807. At the moment of writing it I know it's possible to solve it in JVM languages and Python.

Having n stars build a Christmas Tree.  
All stars have to be used.  
Top of the tree begins with 1 star.  
Each row is greater than previous by i stars.  
On the bottom of the tree there is at least 1 star which creates root.  
You need to add as many stars as possible to the top layers, only remaining ones could be used for root.  
You need to find minimum height h of Christmas Tree created with these conditions.  

*Example:*  
```
n = 38
i = 2

     *
    ***
   *****
  *******
 *********
***********
     *
     *
```

*Answer:*  
```
h = 8
```

# Input
* Line 1: A long n available stars to build the Christmas Tree.
* Line 1: A long i stars added to next branch comparing to previous one.

# Output
* h height of the Christmas Tree

# Constraints
* 1 <= i < n < 2^63
