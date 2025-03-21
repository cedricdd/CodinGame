# Puzzle
**Playfair Cipher** https://www.codingame.com/training/medium/playfair-cipher

# Goal
Edith and Norman have decided to encrypt all of their messages through 'Playfair cipher'.   
While Norman can encrypt and decrypt on his own, Edith asks for your help with the process. Now you and Edith are both on your desk figuring it out.  

This encryption method requires the use of a key table - a grid of 25 alphabets in a 5 × 5 square.  

```
Example:
A B C D E
F G H I K
L M N O P
Q R S T U
V W X Y Z
```

In Playfair cipher the message is split into digraphs, pairs of two letters, and then encrypted by following these rules in order:

1) If the letters appear on the same row of your table, replace them with the letters to their immediate right respectively. 
(Also applies for the cases with same letters)

```
Example:
A B C D E
F G H I K
L M N O P
Q R S T U
V W X Y Z

Message: MO
Output:  NP
```

2) If the letters appear on the same column of your table, replace them with the letters immediately below respectively.

```
Example:
A B C D E
F G H I K
L M N O P
Q R S T U
V W X Y Z

Message: GR
Output:  MW
```

Note: In cases where letters are at the edges, replace the value of the key whose isn't present, with the key that is at the start of the row/column (according to the rules given).

```
Example:
A B C D E
F G H I K
L M N O P
Q R S T U
V W X Y Z

Message: CE BW
Output:  DA GB
```

3) If neither of the preceding two rules is true, form an imaginary rectangle with the two letters as edge points.   
Then, replace them with the letters on the same row respectively but at the other pair of corners of the rectangle.   
The order is important – the first letter of the encrypted pair is the one that lies on the same row as the first letter of the plaintext pair.  

```
Example:
A B C D E
F G H I K
L M N O P
Q R S T U
V W X Y Z

Message: GT
Output:  IR
```

In addition, Norman has also created some additional rules to increase credibility:  
- If the letters in the message are in lower case, they are supposed to be changed to their respective upper case.
- If all the letters cannot be kept in pairs, the message is a dud.
- Any characters that are not present in the key table are ignored from the message.

For decryption, you simply do the process in reverse.

If you wish to understand it further, here is a link: https://en.wikipedia.org/wiki/Playfair_cipher

# Input
* Line 1 - 5: The 5 rows of the key table where letters are space-separated.
* Line 6: The action to be preformed, ENCRYPT or DECRYPT.
* Line 7: N, the number of messages to read.
* The following N lines: Each line contains a message.

# Output
* N lines: Each message after decryption or encryption. In the case where the message is a dud, print out DUD as output.

# Constraints
* 0 < N < 50
* 0 < size of each message < 200
