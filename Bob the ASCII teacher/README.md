# Puzzle
**Bob the ASCII teacher** https://www.codingame.com/training/easy/bob-the-ascii-teacher

# Goal
Bob wants to teach his students about ASCII ART basics. He wants to use basics shapes or even a straight line for his lesson.

You are one of Bob students and to get an A on your test, you need to write a program that will output differents shapes with a particular character.  
This particular character will be use to draw shapes' border and the inside fill with space characters.  

You will always be given three ASCII characters.  
The first one will be the border of the Line, the second one for the Rectangle and the last one for the Triangle and Reverse Triangle

The triangle base will be equal to its height (theight) , same for the reverse triangle.  
For a basic TRIANGLE you should output a triangle where the tip of its height is pointing upward. For a REVERSE_TRIANGLE, its height will be pointing down.

*Example*  

Input:  
```

15
2
12
3
{ / @
LINE RECTANGLE TRIANGLE REVERSE_TRIANGLE
```
Output:  
```
{{{{{{{{{{{{{{{

////////////
////////////

@
@@
@@@

@@@
@@
@
```

# Input
* Line 1 : lsize, an integer, the size of the straight line
* Line 2 : rheight, an integer, the height of the rectangle
* Line 3: rwidth, an integer, the width of the rectangle
* Line 4: theight, an integer, height of the triangle which also the represents the length of the base.
* Line 5: characters, space-separated characters you have to use to draw the shapes
* Line 6: shapes, space-separated shapes you need to drow, they can be : LINE , RECTANGLE , TRIANGLE, REVERSE_TRIANGLE or some other string which represents a not basic form.

Note: In some tests, you may not need all variables. For example if you only need to draw a line, you'll only need lsize

# Output
*The shapes Bob asked you to do ALL SEPARATED BY A BLANK LINE !.
* You should always print them in this order : LINE , RECTANGLE, TRIANGLE, REVERSE TRIANGLE

Note: Bob may not ask you to draw all shapes, you might want to test which one you have to draw. If you have to draw a shape which is not part of those said before, you should output: shape IS NOT A SHAPE in priority.

# Constraints
* 0 < lsize < 1e9
* 0 < rheight , rwidth < 1e9
* 0 < theight < 1e9
