# Puzzle
**Code Breaker Puzzle** https://www.codingame.com/training/medium/code-breaker-puzzle

# Goal
Decode a secret message. Each message is encoded using something a little more complicated than a Caesar cipher.  
Unlike a Caesar cipher which can be expressed as (X+A)%L, where A is the cipher variable and L is the length of the alphabet, this encoding instead is expressed as ((X+A)*B)%L. A is the shift and B is the multiply.  
Your task is to discover the secret message from an alphabet, an encoded message, and a word that is guaranteed to be in the secret message.

For this puzzle, the shift and multiply is not provided but the solution involves discovering it. The shift and multiply may be different for every test case.

There is only one unique solution to each test

The first 4 test cases have B=1 and therefore can be solved using a simple Caesar cipher.

# Input
* Line 1: ALPHABET The characters in the cipher
* Line 2: MESSAGE The encrypted message
* Line 3: WORD The word that is in the message

# Output
* Line 1 Decrypted message

# Constraints
* The alphabet, message, and word are all limited to less than 200 characters
* The shift and multiply are both less than or equal to the length of the alphabet
