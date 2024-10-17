# Puzzle
**ASCII Snakes** https://www.codingame.com/training/medium/ascii-snakes

# Goal
This puzzle is the second part of the ASCII series. The prequel to this puzzle is "ASCII Worms", where you have to print a worm using ASCII characters.

After a ten-minute coding montage, you successfully get the program working. You now paste the worms and submit. It worked! A "Go to Next Assignment" button appears, and you happily click on it. How bad could the next one be? This time, you have to print ASCII snakes!

Your aim is to draw an ASCII snake, given the moves it makes, in the form of U, D, L, R, which signify Up, Down, Left, Right respectively. The snake starts at the top-left.

*Example:*  
For example, if the input is "DRRDLD", then the snake would be:
```
+-+
| |
| +-----+
+-----+ |
   +--+ |
   | +--+
   | |
   +-+
```

The snake is composed of 3x2 ASCII rectangles.
```
+-+   +-+                  +-+         +-+ <- ASCII rectangle
| |   | |                  | |         | |    (3*2)
| +---+ |  is composed of
+-------+                  | +   ---   + |
                           +--   ---   --+
```

All vertical lines, horizontal lines, and intersections are represented by |, -, and + respectively. All trailing spaces should be trimmed off.

Stuck on where to start?  
Here's a little hint for you; watch this video and see if you can get the idea for the solution: https://www.youtube.com/watch?v=qAf9axsyijY

# Input
* Line 1: The message which specifies the directions of the snake

# Output
* The ASCII snake made using the given message

# Constraints
* length(message) <= 50
