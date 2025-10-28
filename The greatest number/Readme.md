# Puzzle
**The greatest number** https://www.codingame.com/training/hard/the-greatest-number

# Goal
You must print the greatest number using all the characters in the input, including the ten digits 0 to 9, the minus sign - and the decimal dot ..

Beware:  
* The dot alone must not end a number, at least a digit is needed. For example, 98742. is refused, write 9874.2 instead.
* Trailing and leading zeros must be removed. Write -4 instead of -4.0000 and -5.65 instead of-5.6500.

# Input
* Line 1 : The number N of chars
* Line 2: N chars on a single line separated with spaces

# Output
* The greatest number possible using all the input chars (but maybe without some zeros).

# Constraints
* 1 ≤ N ≤ 10
