# Puzzle
**Draw Monster** https://www.codingame.com/contribute/view/101292bf5a4ccf9d42f7be1217d0386f057493

# Goal
To play "Draw Monster", roll dice or flip coins to determine which part of a monster to draw. Some parts must be drawn before others. The first to finish drawing the whole monster wins. Determine who wins each game and in which round.

*Notes:*  
* If an eye requires a head, then a two-headed monster requires that players draw both heads before drawing any eyes.
* If rolling 1 or 6 produces a head, it is NOT required to roll both; either one is sufficient. A monster with two heads may be achieved by rolling two 1s, two 6s, or one of each.
* If two or more players complete the monster on the same turn, print a winning line for each, in the same order as the players are listed in the input.

In the example input:  

Round 1:  
Curly rolls a 1 and draws a body, Moe rolls a 2 but can't draw a head without a body, and Larry rolls a 6 but can't draw a tail without a body.

Round 2:  
Curly rolls a 2 and draws a head, Moe rolls a 1 and draws a body, and Larry rolls a 5 but can't draw a horn without a head.

# Input
* Line 1: An integer N  
* Next N lines: A JSON document.  

The "monster" object contains:   
- A "rolls" array. A player who rolls "roll" may draw "part".  
- A "requirements" array. Complete a monster by drawing "qty" number of each "part". If a "requires" array is present, then this part cannot be drawn until completing all the required parts.  

The "play" object contains:  
- The "players" array showing the players' names.  
- The "game" array - each item is the players' roll for that round, in the same order as the "players" array.  

# Output
* 1 or more lines: Player wins in round roundNumber.
