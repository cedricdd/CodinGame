# Puzzle
**Straddling Checkerboard Cryptography** https://www.codingame.com/training/medium/straddling-checkerboard-cryptography

# Goal
A straddling checkerboard is a device for converting an alphabetic plaintext into digits. Our checkerboard will look like this :
```
  	0  1  2  3  4  5  6  7  8  9
 0	E  T     A  O  N     R  I  S
 2 	B  C  D  F  G  H  J  K  L  M
 6 	P  Q  /  U  V  W  X  Y  Z  . 
```

Filling the checkerboard

The first line is filled using a passphrase that contains 2 spaces.   
We remove letters already used from alphabet to fill the second and the third lines with "/" and "." inserted in.  

Each board cell has a value, whose tens digits is given by the row it's on, and whose units digits is given by the column.   
First row is always 0; the empty cells in the first row give the values for the second and third lines (2 and 6 here).

Using the checkerboard  

When encrypting, unsupported characters need to be removed from input message  
The valid characters are letters, digits and the period '.'  
The digits have to be prefixed by the character "/".  

It is now easy to use the grid to encrypt a word:  
- Column value is the units digit
- Row value is the tenths digit

By example:  
I am 1 brut => IAM/1BRUT => 8 3 29 62 1 20 7 63 1 => 8329621207631  
The digit is represented by "/" and its value

Decrypting is easy too:  
8 => I  
3 => A  
2 => empty so we take 20 and add next value = 29 => M  
6 => 62 => "/" so we take next value => 1  
...  

Let's make it harder to crack

To complicate the cracking of the code, let's take a key number : 0432 and use it to modify by addition and modulo 10 the code:
```
  8 3 2 9 6 2 1 2 0 7 6 3 1
+ 0 4 3 2 0 4 3 2 0 4 3 2 0
-------------------------------
  8 7 5 1 6 6 4 4 0 1 9 5 1
```

To construct the number to add , concatenate the key number as many times as necessary. If it is too long, remove the excess numbers at the end (if the code is 059731, the number will be 043204)

Last step

The last thing to do is using the checkerboard to convert to characters (letters, slash or period, no digits):
```
8751664401951 => IRNTXOOETSNT
```

What do we need

So in fact, all you need to encrypt/decrypt is:
- a header number containing the 10 digits (0 to 9), for the checkerboard header
- a passphrase with 8 letters and 2 spaces
- the positions of "/" and "."
- the key number for add/modulo
- the message

# Input
* Line 1 action to do : 1 to encrypt, 0 to decrypt
* Line 2 header numbers
* Line 3 passphrase
* Line 4 posslash and posdot : positions in remaining letters list where we insert "/" and "." (indexed at 0)
* Line 5 key number
* Line 6 message

# Output
* Message after encrypting or decrypting
