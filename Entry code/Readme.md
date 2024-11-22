# Puzzle
**Entry code** https://www.codingame.com/training/medium/entry-code

# Goal
You're going back home late and unfortunately, you forgot your entry code. So you decide to try all the possibilities.   
It is not the smartest choice but your neighbors are sleeping...

The challenge is to find one of the shortest sequences of digits that contains all those possibilities.

There are x digits, from 0 to x-1, available for your entry code, and the code is composed of n of them.

For instance, there are eight possible codes for x = 2 and n = 3 : "000", "001", "010", "011", "100", "101", "110", and "111".   
And you can try all of them with the sequence "0001011100".

As there are multiple sequences of the same length that are solutions to this problem, you need to find the sequence describing the smallest possible number.  
For the previous example, the expected answer is not "0010111000" because 0010111000 > 0001011100.

# Input
* Line 1: The number x describing the available digits of the pad.
* Line 2: The length n of your entry code.

# Output
* Line 1: The sequence to try all the codes.

# Constraints
* 1 ≤ x ≤10
* 1 ≤ n <10
* x^n < 1000
