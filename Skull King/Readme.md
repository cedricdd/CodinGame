# Puzzle
**Skull King** https://www.codingame.com/contribute/view/1373943575bc19edb19aeb58e19101776e50bd

# Goal
You are given the data of a modified version of the card game Skull King. Your goal is to compute each player's score after x games.

Play order
* Players play in order, wrapping around as needed.
* At the beginning, the first player is the starting player.

Rounds  
Each game consists of a number of rounds equal to the game number:
* Game 1 → 1 round
* Game 2 → 2 rounds
* …
* Game x → x rounds

In each round:
* Starting from the starting player, every player draws the next card from the deck and plays it immediately.
* Determine the winner of the round. They gain 1 point.
* All drawn cards are returned to the back of the deck in the same order as they were drawn.
* The winner becomes the starting player of the next round. If a round has no winner, the starting player does not change.

Deck  
The deck contains 71 cards:
* 1 Skull King: S
* 2 Mermaids: M
* 5 Pirates: P
* 5 Flags: F
* 1 Whale: W
* 1 Squid: Sq
* 14 Blacks: B1 to B14
* 14 Yellows: Y1 to Y14
* 14 Purples: P1 to P14
* 14 Greens: G1 to G14

Determining the winner  

The following rules are applied in order:
1. If any player plays Squid, the round has no winner.
2. If at least one Pirate, at least one Mermaid and the Skull King are all played, the first Mermaid played wins.
3. If the Whale is played,
  * If at least one number card (Black, Yellow, Purple, Green) is played, the card with the highest numeric value wins.
  * If multiple number cards share the same highest value, the first played wins.
  * If no number cards are played, the starting player wins.
5. If none of the above rules apply, determine the winner by pairwise elimination:
  * The starting player's card becomes the initial current best.
  * Then, in play order, each subsequent (challenger) card is compared against the current best using the comparison rules below.
  * If the challenger card beats the current best, it becomes the new current best. Otherwise, the current best remains.
  * After all comparisons, the final current best is the winner.

👉 Comparison rules for rule 4
* Skull King beats everything except Mermaid.
* Pirate beats everything except Skull King.
* Mermaid beats everything except Pirate.
* Flag loses to all non-Flags.
* If two cards are equal, the card played earlier wins.
* Black beats all other colors (Yellow, Purple, Green).
* Between number cards of the same color, the higher numeric value wins.
* Between non-Black number cards of different colors, the color played earlier wins.

Example  
There are 2 players and 3 games, and the initial deck is:  
G4 P Y11 Sq P8 P9 M S G10 B9 W Y5 P5 F G8 Y9 B8 G12 P Y12 Y2 P1 Y6 G6 G11 F B10 G3 P Y4 B12 F P3 G7 G9 P6 F G5 P F M P4 G13 P10 P14 Y1 P2 P13 B13 Y14 P B11 Y8 Y13 Y7 Y10 B5 G1 B7 P7 B14 B2 Y3 G14 B1 P12 B3 P11 B6 B4 G2  
(In the description below, "wins" means wins the round, gets 1 point and becomes/remains the starting player.)  
Game 1 Round 1  
Player 1 plays G4.  
Player 2 plays P.  
P beats G4. Player 2 wins.  
Game 2 Round 1  
Player 2 plays Y11.  
Player 1 plays Sq.  
Sq is played. The round has no winner. Player 2 remains the starting player.  
Game 2 Round 2  
Player 2 plays P8.  
Player 1 plays P9.  
P9 beats P8. Player 1 wins.  
Game 3 Round 1  
Player 1 plays M.  
Player 2 plays S.  
M beats S. Player 1 wins.  
Game 3 Round 2  
Player 1 plays G10.  
Player 2 plays B9.  
B9 beats G10. Player 2 wins.  
Game 3 Round 3  
Player 2 plays W.  
Player 1 plays Y5.  
W is played. Y5 is the winning card. Player 1 wins. The game ends.  
Final score:  
Player 1 gets 3 points. Player 2 gets 2 points.  

# Input
* Line 1 : A string for the deck of 71 cards, separated by a space.
* Line 2 : An integer nbPlayers for the number of players.
* Line 3 : An integer nbGames for the number of games.

# Output
* N lines : The score of each player.

# Constraints
* 2 <= nbPlayers <= 7
* 1 <= nbGames <= 10
