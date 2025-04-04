# Puzzle
**Merlin's Magic Square** https://www.codingame.com/training/medium/merlins-magic-square

# Goal
Background and Symbols:  
Merlin was a hand-help electronic gaming-device from 1978. It played multiple games with the kids back then, including "Magic Square"

We will refer to each location (aka button) within Merlin's Magic Square using this numbering system, which is the same as the instructions from the original game. (See banner image)  
```
1 2 3
4 5 6
7 8 9

asterisk * = lit
tilde ~ = unlit (not lit)
```

Situation:  
You and your friend Lizzo are given a starting "Merlin's Magic Square", which consists of:  
3 rows of 3 characters (characters are separated by a space), such as....  
```
~ * ~

~ ~ ~

~ * ~
```
And y'all want to solve it by changing it into The Solved State, which is:
```
* * *

* ~ *

* * *
```

Your Task:  
Lizzo tells you the buttons she has pressed, such as 433 (meaning: first she pressed 4, then 3, then 3).  
Only one more button needs to be pressed to solve it; what button is that?  


The Rules of Merlin's Magic Square:  
* When you press a corner button (1, 3, 7 or 9), it reverses the 4 buttons in the 2x2 corner square it's in
* When you press a side button (2, 4, 6 or 8), it reverses the 3 buttons in that border row
* When you press the middle button (5), it reverses the 5 buttons in the middle "+" shape
* ("Reverse" means that if it's lit, it becomes unlit; if it's unlit, it becomes lit.)
* The Solved State is when all buttons are lit except for the middle one (5) ; this is shown above in blue

See someone else play it, or play it yourself to understand better:  
* 1-minute long example of a person playing this: https://youtu.be/M2pSiuIKn6k?t=462
* Play it yourself in this simulator I made: https://openprocessing.org/sketch/1643473

# Input
* Lines 1 to 3: The starting Merlin's Magic Square, in 3 rows
* Line 4: The numbers of the buttons that Lizzo has pressed

# Output
* The number of the final button you should press to solve it

# Constraints
* Lizzo has pressed at least one button
