# Puzzle
**Fill the square!** https://www.codingame.com/training/expert/fill-the-square

# Goal
James Bond needs to infiltrate the SPECTRE headquarters. The door lock looks like a square of N×N LEDs.  
Some of those LEDs are lit, and each LED’s state can be changed by touching it.

Unfortunately, when you touch an LED, not only does its state change, but the states of its horizontal and vertical neighbors change as well.

So for an input of
```
...
.*.
...
```

If Bond were to press
```
...
.X.
...
```

Then the next state would be
```
.*.
*.*
.*.
```

Bond’s only option is to light all the LEDs to unlock the door…

You are Q, and 007 contacts you to request your help.   
Try to find a way to quickly solve the puzzle (with the minimum number of touches) and get your agent into the house!

# Input
* Line 1: One integer N, the size of the square.
* Next N lines: A string containing N characters representing LEDs (. for not lit LEDs, * for lit LEDs).

# Output
* Exactly N lines: N characters representing the LEDs of this line to touch to solve the puzzle with the minimum number of touches (. for no touch, X for touch).

# Constraints
* 3 ≤ N ≤ 15
* There will always be one and only one solution.
