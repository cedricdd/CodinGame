# Puzzle
**That is a lot of Bingo Cards** https://www.codingame.com/contribute/view/592506957c5b18d580837279af645b3c92074

# Goal

Bingo Cards are used in the game of Bingo:
* A Card consists of the header "BINGO" and a 5x5 square of 24 numbers and 1 "free space"
* (The square is 5x5 because "BINGO" is 5 letters long)
* There are 75 possible numbers that can go on a Card:
* Each number is only allowed in a certain column; For example, numbers 1-15 can only go in the first column, numbers 16-30 can only go in the second column, etc
* There are no duplicate numbers on a Card

There are a gigantic number of unique Cards possible: about 552 Septillion (552,446,474,061,128,648,601,600,000 to be exact)

See discussion here: https://math.stackexchange.com/questions/1451218/how-many-bingo-card-combinations-are-there

But what if there were alternative Bingo Card styles, such as:
* different headers, therefore different square sizes
* different free space(s), at various locations on the Card
* different number of Balls

*Your task:*  
You will see a variation.  
On the Bingo Card shown: fr indicates a "free space" and a dot (.) indicates where the numbers can go.  

In this given variation, how many unique Cards are possible?  
NOTE: You won't be able to output the actual calculated total because it is likely just too large.  
Instead output the equation needed to calculate the total.  

Output format:  
The equation (that will produce the total) should be shown in this simplified format: b1^n1 * b2^n2 * b3^n3 etc

Where the bs are in descending order (If an n is 1, don't print ^1 since that is not needed)

For example:
```
8 * 9 * 8 * 7 * 9 * 8
```
should print out as
```
9^2 * 8^3 * 7
```

# Input
* Line 1: An integer numOfBalls the number of Balls
* Line 2: An integer heightOfBingoCard height of Bingo Card
* Next heightOfBingoCard Lines: Strings, each line of the Bingo Card, including the header

# Output
* A string equation as described in the statement
* NOTE: There is a space on both sides of each *

# Constraints
* numOfBalls is a multiple of header length
* numOfBalls is more than (header length) x (header length)
* 2 < (header length) < 10
