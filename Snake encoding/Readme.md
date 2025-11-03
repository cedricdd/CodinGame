# Puzzle
**Snake encoding** https://www.codingame.com/training/medium/snake-encoding

# Goal
You must encode a N sized square of text X times.  
It is provided as follows, the example stands for a three-letter sided square: 
```
ABC
DEF
GHI
```

The encoding pattern begins at the bottom left corner of the square and goes upwards, replacing the current letter with the one below.  
In this example, the D, which is above the G, is replaced with G and the A, which is above the D, is replaced with D.  
Once the top of the square is reached, the pattern switches to the next column and proceeds downwards.  
Similarly, when the bottom of the square is reached, the next column is engaged and the pattern proceeds upwards.  
When switching columns, the current letter is replaced with the previous one on the left.  
For example, when reaching the top of the first column at A and switching to the second one, B is replaced with A, then the pattern goes downwards.  
When the top right corner of the square has been reached, the current letter is replaced with the one at the bottom left corner in order to complete the sequence.  
A full example demonstrating one round of the encoding pattern is provided below.  
```
ABC → DAF
DEF → GBI
GHI → CEH
```

The directions of the letters are these ones:
```
→↓X
↑↓↑
↑→↑
```
X means that the letter replaces the first one in the list (ie the bottom left one).

With a four-letter sided square:
```
→↓→↓
↑↓↑↓
↑↓↑↓
↑→↑X
```

# Input
* Line 1: N, the size of the square
* Line 2: X, the number of times you must encode
* Next N lines: A line of the text to encode

# Output
* N lines of the encoded text

# Constraints
* 1 <= N <= 20
* 1 <= X
* The input text is composed of ASCII characters
