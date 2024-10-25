# Puzzle
**Boggle with Friends** https://www.codingame.com/training/medium/boggle-with-friends

# Goal
Boggle was a word board game, popular in the 1990s.  
Surely the Friends (on the TV show "Friends") played it.  

Determine who wins, and the details of the game.


*Rules and Scoring*
* A word must be over 2-letters long.
* A word is only valid in the game if it can be spelled using letters adjacent to each other on board (diagonal is fine).
* A letter on the board can be used only once per word.
* A word doesn't count if anyone else has also written it.
* If a player writes down a word more than once, all the repeated instances are ignored.
* winner is player with most points.
* For simplicity, a game is only one round (i.e., only one shake of the board).
* Full rules (if needed to clarify) are here: https://www.wikihow.com/Play-Boggle

*Scoring*  
* 3-letter words and 4-letter words are 1 point each.
* 5-letter words are 2 points each.
* 6-letter words are 3 points each.
* 7-letter words are 5 points each.
* 8-letter words and longer are 11 points each.

*Assume*  
You can assume all words on all notepads are real words, as checking that would be beyond the scope of this puzzle.
Do NOT assume that all words are valid for the Boggle Board; this is something you will need to check.

# Input
* Lines 1-4: The 4x4 Boggle Board with a space between letters for easy readability
* Line 5: numOfFriends, an Integer, the number of Friends who are playing
* Next numOfFriends Lines: a string, collectively called aFriendsNotePad, consisting of a Friend's name writes: and all the words that Friend has written down (each separated by a space)

# Output
* Line 1: winner is the winner!
* Line 2: Blank line for readability
* Line 3: ===Each Friend's Score===
* Next numOfFriends Lines: Each Friend (in order from input) and that Friend's total score (separated by a space)
* Next Line: Blank line for readability
* Next Line: ===Each Scoring Player's Scoring Words===
* Next Many Lines:
  * Each Friend (if they score any points) -- in same order as input
  * Underneath each Friend, each word they wrote that has value -- in same order as input -- preceded by that word's value (separated by a space)

# Constraints
* All words are truly real words, and are at least 3-letters long
* There will always be a clear winner (no ties)
* For simplicity, there are no "Q" or "Qu" on the Boggle Board
* All players write at least one word
* numOfFriends ≥ 2
* All letters on the Boggle Board and the words in aFriendsNotePad are in uppercase
* All Friends' names consist of one word only and are all unique
