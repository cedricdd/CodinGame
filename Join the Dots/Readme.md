# Puzzle
**Join the Dots** https://www.codingame.com/training/medium/join-the-dots

# Goal
Have you ever played Join the Dots (or "Connect the Dots") as a kid? Well, now you get to do it again!

You will be given a rectangular board with some numbers and letters on it, you must join them in order with the appropriate ASCII characters.

Your input contains a rectangular board made only of digits, letters, and "."  
. represents an empty space.  
Digits 1 to 9 and uppercase letters A to Z represent the dots you must connect in order.  

The order is 1 -> 2 -> ... -> 8 -> 9 -> A -> B -> ... -> Y -> Z

The digits and letters will always start from 1, but may stop before Z.

You must output the board after connecting the dots, with characters replaced as follow:  
- each digit or letter in the original board must be replaced by a lowercase o;
- . characters between two consecutive digits/letters must be replaced by a line drawn with the rules explained below (remember that A comes right after 9);
- each other . character must be replaced with a space;
- spaces at the end of a line must be trimmed.

Two consecutive digits/letters are always aligned horizontally, vertically, or diagonally.  
Note that in some cases they may be in adjacent positions.

Each line that joins two dots must be entirely made of one of these characters: - | / \ + X *.

Join dots with:  
- \- if on the same row;
- | if on the same column;
- / or \ if on the same diagonal (moving of the same number of rows and columns).

Examples:
1...23.4  becomes  o---oo-o

(2 and 3 are adjacent, so nothing is drawn between them)
```
..9.               o
....              /
A..C             o  o
....   becomes    \ |
....               \|
...B                o
```

Whenever lines cross with each other, apply these substitutions:
- if a horizontal line crosses a vertical one, the character becomes +;
- if a diagonal line crosses another, the character becomes X;
- if a diagonal crosses a horizontal or vertical line, or 3 or more lines meet in a point, the character becomes *.

# Input
* Line 1: Two integers H and W for the height and width of the board.
* Next H lines: Exactly W characters on each line, which can be one of:
  - . to represent an empty space;
  - a digit 1 to 9;
  - an uppercase letter A to Z.

# Output
* H lines, each with up to W character following the rules described above.
* Each character is a either a space or one of o - | / \ + X *.

# Constraints
* 3 ≤ W,H ≤ 40
