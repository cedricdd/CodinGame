# Puzzle
**High Score Pinball Initials** https://www.codingame.com/contribute/view/721532837c92ad4ccbe1683eacbce40ec8e60

# Goal
Do you remember how to enter your initials when you have a high-score in pinball?
```
   +-------------------+
   |    HIGH SCORES    |
   +---+---------+-----+
   | 1 | 162 870 | ABG |
   | 2 |  95 270 | HAJ |
   | 3 |  91 540 | BOO |
   | 4 |  89 710 | C D |
   | 5 |  86 970 | MAR |
   | 6 |  85 480 | KOK |
   | 7 |  83 530 | R Y |
   | 8 |  75 590 | C D |
   | 9 |  68 410 | BON |
   +---+---------+-----+
```
There are only 3 buttons on a pinball machine to input your initials Left - Right - Player.

With the Left orRight button you can navigate through a list of characters which are displayed on the LCD screen from A to Z, space and <.  
ABCDEFGHIJKLMNOPQRSTUVWXYZ < (only 28 choices)  
If you press R when you have reached < you move to A  
If you press L when you have reached A you move to <  

At the beginning the character A is highlighted.  
If you press the Player button then the highlighted character is chosen.  

You can delete the last character if you move to < and press button P (except if it's the 3rd character because on a pinball machine you can never amend the last character).

Once all 3 characters have been chosen, the initials are finalised and any further button presses are ignored.

If P is pressed when character is < and your initials are empty then nothing happens.

*Input sequence:*  
A string sequence can contain the letter P or the letter R or L followed by a positive integer to indicate how many characters to move.

*Demo:*  
Let us consider the following sequence : PR2PL1P

The first character A is highlighted  
ABCDEFGHIJKLMNOPQRSTUVWXYZ <  
You press the button P then the character A is selected.  
Your initals are : A  

You press the Right button twice (R2) then the character C is highlighted.  
ABCDEFGHIJKLMNOPQRSTUVWXYZ <  
You press the button P then the character C is selected.  
Your initals are : AC  

You press the Left button once (L1) then the character B is highlighted.  
ABCDEFGHIJKLMNOPQRSTUVWXYZ <  
You press the button P then the character B is selected.  
Your initals are : ACB  

At the end of this sequence your initials are ACB and the pinball machine shows the High-Score table.

# Input
* sequence : a string with all the buttons pressed by the player

# Output
* initials : The player's High-Score initials (3 letters)

# Constraints
* Left and Right numbers are between 1 and 99
* All sequences are valid and produce 3-characters initials (including a space character)
