# Puzzle
**Extended Hamming Codes** https://www.codingame.com/training/easy/extended-hamming-codes

# Goal
Hamming Codes are a way of validating and fixing blocks of binary data using parity bits. Each block is 2^N bits long.   
Here, we are only interested in the case where N = 4 (i.e. 16 bit blocks)

Consider the following, generic, block of data, abcdefghijklmnop, which can be rewritten as:
```
a b c d
e f g h
i j k l
m n o p
```

* Bit a is a global parity bit. A valid message has an even number of 1's
* Bit b is a parity bit for the bits [d, f, h, j, l, n, p] (odd columns), meaning that the subset bdfhjlnp has an even number of 1's.
* Bit c is a parity check on bits [d, g, h, k, l, o, p] (last two columns), meaning that the subset cdghklop has an even number of 1's.
* Bit e is a parity check on bits [f, g, h, m, n, o, p] (odd lines), meaning that the subset efghmnop has an even number of 1's.
* Bit i is a parity check on bits [j, k, l, m, n, o, p] (last two lines), meaning that the subset ijklmnop has an even number of 1's.

Given a message encoded with this error-checking algorithm, it's possible to locate any 1 faulty bit and correct it, and locate if there are 2 faulty bits (but not correct them).

For instance, if bdfhjlnp is odd, cdghklop is even, efghmnop is even and ijklmnop is odd, then the bit j needs to be flipped.   
Furthermore, bit a can be used to detect if there are 2 errors in the block. If bit j needs to be flipped, but the whole message is even, then there are two errors.

You are given a string in binary of length 16. Your goal is to check whether this string has an error, and if so correct it.  
If the string has only one error, or is valid, print out the corrected string. Print out 'TWO ERRORS' if the string has two errors.

# Input
* Line 1: A string of 16 binary digits, representing a message block protected with the Hamming ECC scheme.

# Output
* If the message has no errors: print out the original message.
* If it has 1 error: print out the corrected message.
* If it has 2 errors: print out 'TWO ERRORS'.

# Constraints
* At most 2 errors in the message.
