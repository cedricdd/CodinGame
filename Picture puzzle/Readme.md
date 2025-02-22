# Puzzle
**Picture puzzle** https://www.codingame.com/contribute/view/7690d63b638315a0a2ed8e1d97ed85c57b64

# Goal
What if you have to solve a real puzzle? I mean, assembling pieces of picture into a single big picture.  
You are provided a set of pieces of a puzzle, in a random order and with random orientations. You have to assemble the final picture from the pieces.  

*Assembling rules:*  
Two pieces can be put together if a border of the first piece matches with a border of the second one.  
That is, the given pieces have their border "duplicated". Only then do they match. This duplicated border appears only once in the final picture.  
For example, assembling the two pieces below results in the picture on the right:  
```
####     ####     #######
#123  +  345#  =  #12345#
#abc     cde#     #abcde#
####     ####     #######
```

However, the pieces are given with random orientations (in 90 degrees steps, that is, 4 different orientations). In the example below the right border of the 1st piece matches the top border of the 2nd piece. So the 2nd piece needs to be rotated before assembling:
```
####     #c3#     #######
#123  +  #d4#  =  #12345#
#abc     #e5#     #abcde#
####     ####     #######
```

Guarantees:  
* The border of a piece which is on the border of the final picture will contain only the '#' character.
* The first piece (in the input list) is given with the correct orientation so that you can know the orientation of the whole picture.
* There is only one solution with the given rules and the given pieces.

Notes:  
* With the given assembling rules, you can determine that if the puzzle is composed of nColumns columns and nRows rows of pieces with size pieceSize, then the final picture will have pictureWidth columns and pictureHeight rows of characters, where:
  * pictureWidth = 1 + (pieceSize - 1) * nColumns
  * pictureHeight = 1 + (pieceSize - 1) * nRows
* The given constraints are designed so that you can use a brute-force solution with exponential complexity (but still not too silly :p).
* The first four test cases give the pieces without rotation. So you can first try to find a solution that doesn't take into account the rotated pieces.
* Be aware that multiple pieces might be identical. However because of the unicity of the solution, pieces cannot have same borders and different contents. 

For example, in the same puzzle, you will never have two pieces like :
```
123     123
8A4 and 8B4
765     765
```

because they could be swapped and the puzzle would have multiple solutions.

Test descriptions:
```
Name    |Pieces|Piece size|Ambiguity|Rotation|Comment
--------|------|----------|---------|--------|-------------------------------------
 Test 1 | 2x2  | 4x4      | No      | No     | Who needs an algo to solve that?
 Test 2 | 15x15| 2x2      | No      | No     | So much diversity
 Test 3 | 11x3 | 6x6      | A bit   | No     | The birth of programming languages
 Test 4 | 8x4  | 6x6      | More    | No     | Your deepest wish
 Test 5 | 2x2  | 4x4      | No      | Yes    | Who needs an algo to solve that?
 Test 6 | 15x15| 2x2      | No      | Yes    | So much diversity
 Test 7 | 11x3 | 6x6      | A bit   | Yes    | The birth of programming languages
 Test 8 | 8x4  | 6x6      | More    | Yes    | Your deepest wish
```

# Input
* Line 1: two space-separated integers: pieceSize the size of a square-shaped piece (number of characters on every border of the piece) and nPieces the total number of pieces given in the input.
* Line 2: two space-separated integers: nColumns the number of pieces in a row, nRows the number of pieces in a column in the final picture
* Line 3: two space-separated integers: pictureWidth the number of characters in a row of the final picture, pictureHeight the number of characters in a column of the final picture.
* Next nPiecesxpieceSize lines: all the pieces. each piece is pieceSize lines composed of pieceSize characters.

# Output
* pictureHeight lines of pictureWidth characters representing the final picture.

# Constraints
* 2 ≤ pieceSize ≤ 6
* 2 ≤ nColumns ≤ 15
* 2 ≤ nRows ≤ 15
* 4 ≤ nPieces ≤ 225
* 2 ≤ pictureHeight ≤ 60
* 2 ≤ pictureWidth ≤ 60
* There is only one solution with the given rules and the given pieces.
* The first piece given will always be in the correct orientation.
