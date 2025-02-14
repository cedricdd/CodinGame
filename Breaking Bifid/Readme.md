# Puzzle
**Breaking Bifid** https://www.codingame.com/training/hard/breaking-bifid

# Goal
Bifid is one of the classic hand ciphers, invented around 1900 by amateur cryptographer Felix Delastelle. In this puzzle you are given a plaintext and its Bifid-encrypted ciphertext. The encryption key is not given. You have to use the combination of these two texts to decrypt a second ciphertext that was encrypted using the same key.

Bifid uses a Polybius square as a key. This is a 5 by 5 square containing 25 letters of the alphabet (the J is merged with I), in an arbitrary order. For example:
```
B G W K Z
Q P N D S
I O A X E
F C L U M
T H Y V R
```

To encrypt a plaintext, we start by removing spaces and replacing each J by an I. Underneath each letter in the resulting text we write the coordinates (row and column) of that letter in the Polybius square:
```
F L E E A T O N C E
4 4 3 3 3 5 3 2 4 3
1 3 5 5 3 1 2 3 2 5
```

The two lines of numbers are written after each other:
```
4 4 3 3 3 5 3 2 4 3 1 3 5 5 3 1 2 3 2 5
```

The numbers are then grouped in pairs, and the pairs are used as coordinates into the Polybius square (the first number being the row, and second being the column), to find the letters of the ciphertext:
```
44 33 35 32 43 13 55 31 23 25
U  A  E  O  L  W  R  I  N  S
```

(see also https://en.wikipedia.org/wiki/Bifid_cipher)

# Input
* Line 1: A string plainText1
* Line 2: A string cipherText1. This is plainText1 encrypted with Bifid using a hidden key.
* Line 3: A string cipherText2. This is the result of encrypting an unknown plainText2 with Bifid using the same hidden key.

# Output
* A single line: A string containing plainText2. Spaces should be omitted.

# Constraints
* Length of the plaintexts ≤ 200
