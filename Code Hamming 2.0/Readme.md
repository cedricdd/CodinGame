# Puzzle
**Code Hamming 2.0** https://www.codingame.com/contribute/view/896430793bfb9edd4e915a35b3ef53a7ae78a

# Goal
Given a string n containing 7 bits equivalent to the hamming code of a hexadecimal integer. Your goal is to convert this code to its hexadecimal equivalent.

A Hamming code is a linear correction code. It allows the detection and automatic correction of an error.

The Hamming code of x (in hexadecimal) is obtained as follows:
* x=abcd in base 2 such that a,b,c and d are the 4 bits corresponding to the binary writing of x.
* The Hamming code of x is H=efagbcd. e,f,g are obtained as follows: The number of "1" in each of eabd , facd and gbcd must be even.

Note: An integer can have several forms of writing in hamming code (if there are errors to correct)

# Input
* A string n (Hamming Code)

# Output
* The hexadecimal equivalent of n

# Constraints
* n have exactly 7 bits
