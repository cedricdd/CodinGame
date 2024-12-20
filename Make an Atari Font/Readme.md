# Puzzle
**Make an Atari Font** https://www.codingame.com/training/easy/make-an-atari-font

# Goal
There are Atari-style fonts, that replicate the very simple and stylized font used in classic Atari video games from the 1980s.   
For example, on https://opengameart.org/content/8x8-ascii-bitmap-font-with-c-source
```
   ██    ███████   ██    ████     █████  █████     ███   █    █  ███████
   ██       █      ██    █   █      █    █        █   █  ██   █     █
  █  █      █     █  █   ████       █    ████     █   █  █ █  █     █
  ████      █     ████   █ █        █    █        █   █  █  █ █     █ 
 █    █     █    █    █  █  █       █    █        █   █  █   ██     █
 █    █     █    █    █  █   █    █████  █         ███   █    █     █
```

Your task is to re-create this using the technique of 2-D array.  
So you get the Hex-Values for all 26 uppercase letters (off the zip file from the above URL, or from below) and translate them into 8x8 bit maps. (See hint below if needed.)  

In the Test-cases for this puzzle, you will write aWord in Atari font.

For convenience, here is each Hex Value followed by the letter it represents:
```
0x1818243C42420000, A, 0x7844784444780000, B, 0x3844808044380000, C, 0x7844444444780000, D, 0x7C407840407C0000, E, 0x7C40784040400000, F, 0x3844809C44380000, G, 0x42427E4242420000, H, 0x3E080808083E0000, I, 0x1C04040444380000, J, 0x4448507048440000, K, 0x40404040407E0000, L, 0x4163554941410000, M, 0x4262524A46420000, N, 0x1C222222221C0000, O, 0x7844784040400000, P, 0x1C222222221C0200, Q, 0x7844785048440000, R, 0x1C22100C221C0000, S, 0x7F08080808080000, T, 0x42424242423C0000, U, 0x8142422424180000, V, 0x4141495563410000, W, 0x4224181824420000, X, 0x4122140808080000, Y, 0x7E040810207E0000, Z
```

Hint: For each letter, you need to convert the Hex Value into a 64 bit-long Binary Value, and then split that Binary Value into 8 different lines.

Suggestion: Due to Codingame limitations, you will not be able to fully replicate this here. So once you solve this puzzle here, copy your code into your own IDE, and substitute in █ instead of X for a full Atari-style experience.

# Input
* Line 1: a string aWord

# Output
* Up to 8 lines that show aWord in Atari font
* Use blank spaces and the character X only.
* Any blank spaces at the end on a line should not be printed.
* Do not print any blank lines.

# Constraints
* aWord is just uppercase letters (no spaces or lowercase letters or numbers or symbols)
