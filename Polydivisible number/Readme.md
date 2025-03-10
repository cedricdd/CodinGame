# Puzzle
**Polydivisible number** https://www.codingame.com/training/medium/polydivisible-number

# Goal
A polydivisible number (or magic number) is a number with digits abcde... that has the following properties:  
- Its first digit a is not 0.
- The number formed by its first two digits ab is a multiple of 2.
- The number formed by its first three digits abc is a multiple of 3.
- The number formed by its first four digits abcd is a multiple of 4.
- etc...

For example, 567 is polydivisible because:
- 5 is divisible by 1
- 56 is divisible by 2
- 567 is divisible by 3

Your program will have to determine in which bases the input number may be, knowing that it is polydivisible in base 10

# Input
* One line containing the number consisting of pairs of numbers separated by spaces

01 02 03 => 123 in base 10  
01 02 03 => 123 in base 16 => 291 in base 10  
01 10 02 => 1A2 in base 16 => 418 in base 10  

# Output
* The values ​​of the bases by numeric order (one value <=> one line)

# Constraints
* 2 ≤ base ≤36
* number of digits < 18
