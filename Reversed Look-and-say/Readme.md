# Puzzle
**Reversed Look-and-say** https://www.codingame.com/training/medium/reversed-look-and-say

# Goal
Given an element of the Look-and-say series, you must walk the series in the reverse direction until you find the first valid element of the series.

The Look-and-say series transforms a given number by changing a "spoken" interpretation of that number into a numerical format. 
The spoken interpretation of a number takes groups of digits and states the count of repeated digits in each group.
```
13112221 =>
    1  3  11  222  1 =>
        "One 1, one 3, two 1s, three 2s, one 1" =>
            11  13  21  32  11 =>
                1113213211
```

Given the above example of the Look-and-say series, if you were given "1113213211" as an input, the first step in walking the series in reverse would yield "13112221".  
Be careful after each iteration because the process is not always reversible...


For example:
```
1211 => 
    1 x "2" + 1 x "1" = 21 => 
        2 x "1" = 11 => 
            1 x "1" = 1. This is the last possible step

41 => 
    4 x "1" = 1111 => 
        1 x "1" + 1 x "1" = 11. This step is not reversible!
```
The solution is 1111

You can find detailed information of this sequence in https://en.wikipedia.org/wiki/Look-and-say_sequence.

# Input
* Line 1: An integer n for the starting element of the series.

# Output
* Line 1 : The very first valid element of the look-and-say series.

# Constraints
* Log(n) < 100
