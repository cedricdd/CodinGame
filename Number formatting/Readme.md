# Puzzle
**Number formatting** https://www.codingame.com/training/easy/number-formatting

# Goal
Based on the specially formatted number numberstring, you need to output the number divided by two in that same special format.

The special format rules: a number is always represented as a string with length 19, which represents a float with 9 numbers before and 6 numbers after the decimal point.   
All numbers before the decimal point are comma-separated for every three digits, while all numbers after the decimal point are point-separated for every three digits. All positions not used are represented with x.

For example: the input xxx,x38,858.321.82x is 38858.32182. Divided by two this gives 19429.16091, so the output should be xxx,x19,429.160.91x.

# Input
* Line 1: the string numberstring with length 19, representing a number in special format.

# Output
* A string with length 19, which is the number from the input, divided by two, in special format.

# Constraints
* numberstring represents a number >= 0 and <= 999999999.999998
* The last character of numberstring will always either be x or an even number.
