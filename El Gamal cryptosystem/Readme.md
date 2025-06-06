# Puzzle
**El Gamal cryptosystem** https://www.codingame.com/contribute/view/628319335f4edaea8e96f718e8b9d08281a

# Goal
You have to cypher and decypher text with the El Gamal cryptosystem.

We will convert the letters from/to integers as follows: 1 to 26 are the 26 letters from A to Z, 27 is the space and 28 is the dot.  
For example, “HELLO.” will be converted to (8, 5, 12, 12, 15, 28).  
Thus, we will work modulo 29. We won’t use 0, just forget 0.  
Choose e and p from the numbers between 1 and 28.  
Calculate (p ^ e) mod 29. The public key is the couple p and p ^ e, the private key is e.  
To encrypt, for each letter t, choose a number k between 1 and 28. The ciphertext is the couple (c1, c2) where c1 = (p ^ k) mod 29 and c2 = (t * p ^ (ek)) mod 29.  
To decrypt, each letter t is calculated by (c1 ^ −e * c2) mod 29 (you need to inverse a number mod 29).  

Choice of e, p and k:  
* e: Given.
* p: Given.
* k: In the first 2 cases, k will be 5.

In the last 2 cases, k will be calculated using a linear congruential generator (LCG) for which a, b and the modulus m will be given. If x0 is the previous number in the LCG, the next one x1 will be a * x0 + b mod m. k will be calculated as x mod 28 + 1.

# Input
* Line 1: e p
* Line 2: a b m x0 (you can safely ignore this input line for the first 2 cases)
* Line 3: The text to cypher
* Line 4: The list of couples to decypher, numbers separated with spaces

# Output
* Line 1: The list of couples of decyphered text, numbers separated with spaces
* Line 2: The cyphered text

# Constraints
* m < 2 ^ 31 − 1
* The encrypted texts and decrypted texts contain the letters A to Z, spaces, and dots only.
