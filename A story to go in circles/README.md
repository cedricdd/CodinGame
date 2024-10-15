# Puzzle
**A story to go in circles** https://www.codingame.com/training/medium/a-story-to-go-in-circles

# Goal
For many years, means have been in place to assess the IQ of many people. Although not everyone agrees with the notion of intelligence, it is ironically quantifiable. This evaluation is carried out in particular through various tests. Today, you are one of those people who takes one of these tests, but being far too long and boring, you decide to create a program that can do it for you.

For that you must know the principle of this test:  
- You have a grid of letters, each letter indicates the number of trips to be made according to its place in the alphabet (A=1, B=2, C=3...) So if you are on "b" for example, you move 2 letters if you are on "e" you move 5 letters...
- You have to move from left to right and up to down.
- When you are at the end of the line, you return to the beginning of the next line.
- If you at the end of the last line then you go back to the beginning of the first line
- You start from the letter in the top left corner of the grid. This departure counts as a movement.
- When you make a trip you go directly from one letter to another without worrying about the letters that separate them.
- When you encounter a "#" you must rotate the grid 90° clockwise.
- When you encounter an "@" you must rotate the grid by 90° counter-clockwise.
- Rotation does not count as a movement, this means that when you come across "#" or "@" the number of movements is the same before and after the rotation.
- After the rotation, you are at the same coordinates as the "transformer ("#", "@")" before the rotation. (Assuming that the origin of the mark does not rotate, so your coordinates are unchanged but the symbol you were on will necessarily be changed) the grid rotates, not you!

The purpose is to give the letter or symbol on which you are at the end of ii moves

**Example: ii=7** 
```
abcd                  dbda
dcba                  aacb
ba#d                  b#bc
dabc                  cdad
```

So in the first movement we will be on "a", in the second on "b", in the third on "d", in the fourth on "a", in the fifth on "b", in the sixth on "#" which makes the grid rotates so we are on "b" then in the last movement we are on "c".

# Input
* The first line: the number ii of displacements to be made on the grid
* The second line: Number nb of lines and columns
* The nb lines: character string representing each line of the grid.

# Output
* The letter on which we are after ii displacements

# Constraints
* The shape of the grid is always a square
* Number of lines and columns nb<10
* ii<10**12
