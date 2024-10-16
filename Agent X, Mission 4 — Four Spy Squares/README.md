# Puzzle 
**Agent X, Mission 4 — Four Spy Squares** https://www.codingame.com/contribute/view/8690408fd3f55b6a69b23ccbc9c97a10883c4

# Goal
[Agent Y]  
I've arrived near the border of Death Island.  
[Base]  
Roger, be discreet and don't get captured.  
(Some hours later)  
[Agent Y]  
I've intercepted an enemy pigeon, it has an encrypted message on its leg.  
[Base]  
And can we decrypt it?  
[Agent Y]  
I think so, it's encrypted using the 4-square method. But they forgot to remove another ciphertext with the corresponding plaintext, decrypted using the same key.  
[Base]  
Ok, send us the data.  

How to use the Four square cipher :

First make 4 5×5 grid containing the alphabet without Q because Q isn't much use in English. If you found a Q just treat it as a non-letter character (see below). Then replace the top right square and the bottom left square with the keys written in upper case.
```
a b c d e   E X A M P
f g h i j   L B C D F
k l m n o   G H I J K
p r s t u   N O R S T
v w x y z   U V W Y Z
 
K E Y W O   a b c d e
R D A B C   f g h i j
F G H I J   k l m n o
L M N P S   p r s t u
T U V X Z   v w x y z
```

Next, the word to be coded must be separated into a series of two letters, e.g. HELLO WORLD is transformed into HE LL OW OR LD. The non-letter characters (Q, spaces, punctuations, etc) in the original message will be placed at the correct positions in the encrypted message later.

Use each two-letter pair (e.g. HE) to form a rectangle in the grids. The first letter (H) in lowercase should be found in the top left grid. The second letter (E) in lowercase should be found in the bottom right grid. They form the top left and bottom right corners of the rectangle. Draw horizontal and vertical lines from those corners to form the rectangle.

To find the substitutions of the two characters, look at the top right and bottom left corners of the rectangle formed. The top right letter (F) becomes the first letter, and the bottom left letter (Y) becomes the second letter.
```
a b c d e   E X A M P
f g h---------------F
k l | n o   G H I J |
p r | t u   N O R S |
v w | y z   U V W Y |
    |               |
K E Y---------------e
R D A B C   f g h i j
F G H I J   k l m n o
L M N P S   p r s t u
T U V X Z   v w x y z
```

When we finish encoding the whole thing we get :  
```
HE LL OW OR LD -> FY HG HZ HS JE
```
Now we put back the non-letter characters in the message and we get : FYHGH ZHSJE

If a letter is alone just write it for example HEA will be encoded as FYA. A is kept unchaged. Also the case should be conserved if we have Hea we gecot Fya.

Your goal is to decrypt a message and determine as much of the key (grids) as possible. To help you with the task, you are given a ciphertext and its plaintext, decrypted using the same key, and also N words that the message contains.

You can see more at: https://en.wikipedia.org/wiki/Four-square_cipher

# Input
* Line 1 ciphertext: An encrypted message
* Line 2 plaintext: ciphertext decrypted
* Line 3 message: Message encrypted using the same key
* Line 4 N: Number of words known to be in the message
* Next N Lines word: A word in the message

# Output
* Line 1 decrypted message : The decrypted message
* Next 11 Lines The key (grids) used to encrypt the messages:
  * The top left and bottom right grids are in lower case.
  * The top right and bottom left grids are in upper case.
  * An unknown letter is replaced by a . character.
  * All letters inside a grid are separated by a space.
  * The left and the right grids are separated by 3 spaces.
  * The top and the bottom grids are separated by a blank line.

# Constraints
* All word are different.
* With the given input you can always deduce 1 and only 1 solution
