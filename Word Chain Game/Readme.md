# Puzzle
**Word Chain Game** https://www.codingame.com/training/medium/word-chain-game

# Goal
Alice and Bob are going to play a word chain game. The two players take alternating turns, with Alice going first.

In this game, the players are given a shared word list consisting of N words. All words in the word list are distinct.

On each player's turn, the player can choose any word from the word list that satisfies the following two conditions:
- The word has not been chosen before by either player.
- Other than the first turn of the game, the first character of the chosen word must be the same as the last character of the previous word.

If a player is unable to choose a word satisfying the above conditions, that player loses and the other player wins.

Determine who wins, if both players play optimally.

# Input
* Line 1: An integer N: the number of words in the word list.
* Next N lines: A single string - a word in the word list.

# Output
* Print Alice or Bob, the winner of the game.

# Constraints
* 1 ≤ N ≤ 16
* The words in the word list are at most 12 letters long.
* The words in the word list are all distinct.
