# Puzzle
**Frequency-Based Decryption** https://www.codingame.com/training/medium/frequency-based-decryption

Goal
Information on the shift cipher : https://en.wikipedia.org/wiki/Caesar_cipher

Alice has been working in a secret intelligence bureau for several years.  
She's an expert in cryptography and often tasked with decoding intercepted messages.

One day, Alice receives a strange message on her desk. It's a string of characters encoded with a shift cipher, but no key has been provided to decode it.  
Alice knows she needs to decode the message quickly to uncover the enemy's plans.

Fortunately, Alice has a reliable method for decoding messages without a key.  
She uses frequency analysis of letters to determine the shift used in the encoding process.

However, Alice knows that the shift is only applied to alphabetical characters.   
Non-alphabetical characters, such as numbers and symbols, are not affected by the shift.

By comparing the frequency of letters in the encoded message with those in the English language, Alice eventually finds the shift used in the encoding process.

In addition, Alice wants to preserve the characteristics of the original text, including capitalization.   
This means the program must maintain the case of the original text when generating the decoded message in plaintext.

Now, your task is to help Alice by writing a program that takes the encoded string as input, uses letter frequency analysis to decode the message by applying the shift only to alphabetical characters, and generates the decoded message in plaintext while preserving the case of the original text.

Use this frequency list:
```
A: 8.08%	N: 7.38 %
B: 1.67%	O: 7.47 %
C: 3.18%	P: 1.91 %
D: 3.99%	Q: 0.09 %
E: 12.56%	R: 6.42 %
F: 2.17%	S: 6.59 %
G: 1.80%	T: 9.15 %
H: 5.27%	U: 2.79 %
I: 7.24%	V: 1.00 %
J: 0.14%	W: 1.89 %
K: 0.63%	X: 0.21 %
L: 4.04%	Y: 1.65 %
M: 2.60%	Z: 0.07 %
```

# Input
* Line 1 : Message encoded by shift

# Output
* Line 1 : The decoded string of characters.

# Constraints
* 67 ≤ Message length < 1000
