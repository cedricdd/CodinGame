# Puzzle
**Happy Numbers** https://www.codingame.com/training/easy/happy-numbers

# Goal
A happy number is defined by the following process:  
Starting with any positive integer, replace the number by the sum of the squares of its digits in base-ten, and repeat the process until the number either equals 1 (where it will stay), or it loops endlessly in a cycle that does not include 1.   
Those numbers for which this process ends in 1 are happy numbers, while those that do not end in 1 are unhappy numbers.

Given a list of numbers, classify each of them as happy or unhappy.

# Input
* Line 1: An integer N for the number of numbers to test.
* Following N Lines: Each line has a positive integer you should test whether it is happy or not.
* Be aware that some input numbers are really BIG, much bigger than your Integer type can handle. Find a way to overcome it.

# Output
* Output N lines.
* Following the same order as inputs, each line starts with a given number from the list, a space, and then an ascii art :) or :( to indicate this number is happy or unhappy.

# Constraints
* 1 ≤ N ≤ 100
* 0 < each number ≤ 10^26
