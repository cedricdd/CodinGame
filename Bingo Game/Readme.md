# Puzzle
**Bingo Game** https://www.codingame.com/contribute/view/582276c65201f22e903e4ff1e2a8f91e1ba61

# Goal
This puzzle simulates a friendly Bingo Game

You'll see each player's Bingo Card  
And all the balls, in the order drawn  

*Your Task:*  
Your task is to state the winner  
(If there's a tie, state all winners)

Then (if there is one clear winner), show:  
(1) Their Card at the beginning  
(2) Their Card just before they "Bingo'd"  
(3) The ball that gave them a Bingo  
(4) Their Card right after they Bingo'd  

*Notations:*  
\* to the right of a number, represents a daub (meaning that number was called, and therefore the player marked it with a dauber)  
[ ] around a number represents that it's part of the line (row or column or diagonal) that caused the Bingo.  
[ ] supersedes *  

*Notes/Details:*  
* This is standard Bingo: win by covering five spaces in a row — vertical, horizontal or diagonal
* All Cards have a "free" spot in the middle (as is standard in Bingo) denoted by FR; it's never daubed by a player but of course it can be part of a "Bingo"
* All numbers on a Card take up two spaces (right-aligned). For example "7" is really " 7" (starts with a space)
* The dividing lines in the output are the same as in the input
* The "BINGO"-header lines in the output are the same as in the input
* There are 5 spaces between each letter in the "BINGO"-header; the rest of the Card should align, based on that
* Each player has only 1 Card
* Trim off any blanks to the right
* Sometimes two (or more) Bingos will happen on a Card from a single ball. For example, a ball finishes up a column and it also finishes up a row. In the final state, show all Bingos

# Input
* Line 1: An integer, numPlayers for the number of Bingo Cards

Next numPlayers * 8 lines:
* Line 1: A string, indicating who the Card belongs to, in the format of playerName's Bingo Card
* Line 2: A string, the standard header of a Bingo Card showing the letters BINGO
* Line 3-7: Strings, representing that player's Card, showing the "FR" spot and the 24 numbers of the Card, separated by some number of spaces
* Line 8: A string, the standard dividing line

* Next Line: A string, allBalls in the order called (separated by a space). Each is referred to by its full name including the letter, such as B7 or G56

# Output
* Line 1: The winner(s) in the format of either
  
playerName WINS! with everything in caps
or
Tie between these players: each playerName (separated by a space), in the same order as the input

*If there is a single winner:*  
* Next Line: Standard dividing line
* Next Line: The word Initially:
* Next 6 Lines: The winner's Card (including "BINGO"-header) in its initial state

* Next Line: Standard dividing line
* Next Line: The phrase Just before the Bingo:
* Next 6 Lines: The winner's Card (including "BINGO"-header) just before the Bingo

* Next Line: Standard dividing line
* Next Line: The Ball that makes playerName Bingo: that Ball

* Next Line: Standard dividing line
* Next Line: The phrase Final State:
* Next 6 Lines: The winner's Card (including "BINGO"-header) after the Bingo was achieved

# Constraints
* You are provided all 75 balls even though calling will stop once a winner is declared
* numPlayers ≥ 2
