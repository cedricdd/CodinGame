# Puzzle
**ASCII Worms** https://www.codingame.com/training/easy/ascii-worms

# Goal
As a fun computer project for the holidays, you are given the task to draw ASCII art - worms to be specific. But you are only given their thickness, the coil length and the number of turns they make. However, you don't really want to slave away on your computer typing patterns of underscores and vertical bars, so you decide to make a program do it - it's a computer project anyways.

All worms start at the top-left and take up length lines of text (excluding the top of the worm, which is formed using underscores)

For example, if the thickness is 2, the coil length is 5, and the number of turns is 4, you should get:

```
 __ _____ _____
|  |     |     |
|  |  |  |  |  |
|  |  |  |  |  |
|  |  |  |  |  |
|_____|_____|__|
```

# Input
* Line 1: The worm thickness
* Line 2: Coil length of the worm
* Line 3: Number of turns made by the worm

# Output
* The worm made in ASCII art according to the inputs given.

# Constraints
* All the inputs are natural numbers.
* length >= 2
