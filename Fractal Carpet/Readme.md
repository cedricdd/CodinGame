# Puzzle
**Fractal Carpet** https://www.codingame.com/training/hard/fractal-carpet

# Goal
Aladdin was out celebrating last night and smashed his magic carpet into a spire.  
He managed to escape injury but he somehow managed to tear a chunk out of the fabric and can't find the missing piece.   
Unfortunately the cost of the magic thread used in the carpet is extremely expensive even for a prince so he'll have to patch the hole by providing the missing pattern.  
This wouldn't be such a big deal but due to the nature of magic the carpet has a very peculiar fractal pattern to it.  

As Aladdin inspects the whole carpet at various levels of detail this is what he would normally see:

Level 0:
```
0
```

Level 1:
```
000
0+0
000
```

Level 2:
```
000000000
0+00+00+0
000000000
000+++000
0+0+++0+0
000+++000
000000000
0+00+00+0
000000000
```

Level 3:
```
000000000000000000000000000
0+00+00+00+00+00+00+00+00+0
000000000000000000000000000
000+++000000+++000000+++000
0+0+++0+00+0+++0+00+0+++0+0
000+++000000+++000000+++000
000000000000000000000000000
0+00+00+00+00+00+00+00+00+0
000000000000000000000000000
000000000+++++++++000000000
0+00+00+0+++++++++0+00+00+0
000000000+++++++++000000000
000+++000+++++++++000+++000
0+0+++0+0+++++++++0+0+++0+0
000+++000+++++++++000+++000
000000000+++++++++000000000
0+00+00+0+++++++++0+00+00+0
000000000+++++++++000000000
000000000000000000000000000
0+00+00+00+00+00+00+00+00+0
000000000000000000000000000
000+++000000+++000000+++000
0+0+++0+00+0+++0+00+0+++0+0
000+++000000+++000000+++000
000000000000000000000000000
0+00+00+00+00+00+00+00+00+0
000000000000000000000000000
```

etc.

The seamstress will give you the level of detail that she needs and the top left and bottom right coordinates of the piece she needs the pattern for.

# Input
* L an integer, the number of levels
* X1 Y1 X2 Y2 , the top left and bottom right coordinates of the patch that is needed with the top left of the carpet being coordinates 0,0

# Output
* N lines of M characters consisting of either '0' or '+' that represent the 2 thread colors of the carpet

# Constraints
* 0 <= L<40
* 0 <= X1 < X2 < 9*10^18
* 0 <= Y1 < Y2 < 9*10^18
