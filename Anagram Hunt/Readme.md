# Puzzle
**Anagram Hunt** https://www.codingame.com/contribute/view/1537621fc92617df1db4cda018100dceb3c47f

# Goal
Several players each have a hand of letter tiles. Each player attempts to form a word using all the letters in their hand. Determine the winner(s).

*Game mode*  
- The game mode is either high or low.
- In high mode, the player(s) with the highest score win.
- In low mode, the player(s) with the lowest score win.

*How players choose their words*  
- Every player chooses a valid word from the dictionary.
- A word is valid for a player if it is an exact anagram of the player's hand: it must contain exactly the same letters with the same frequencies.
- If a player has multiple valid words, they choose the lexicographically smallest one.
- A player may have no valid word.

*Determining the winner(s)*  
- Ignore any player who has no valid word.
- The score of a word is the sum of the standard English Scrabble tile values of its letters, as shown in the table below.
- Among the remaining players, compare the scores of their words and determine the winning score based on the game mode.
- Every player whose word has the winning score is a winner. There may be multiple winners.
- Output the winners' names and their winning words in the same order in which the players appear in the input.

*Letter scoring*  

The standard English Scrabble tile values are:
* 1 point : a, e, i, l, n, o, r, s, t, u
* 2 points: d, g
* 3 points: b, c, m, p
* 4 points: f, h, v, w, y
* 5 points: k
* 8 points: j, x
* 10 points: q, z

# Input
* Line 1: A string mode, representing the game mode, which is either high or low.
* Line 2: An integer n for the number of players.
* Next n lines: Two space-separated strings name and hand, representing a player's name and the letter tiles in their hand.
* Next line: An integer d for the number of words in the dictionary.
* Next d lines: A string word for a word in the dictionary.

# Output
* 1 or more lines: The winners' names and their winning words, separated by a space, with one winner per line.

# Constraints
* 1 ≤ n ≤ 10
* 1 ≤ d ≤ 30
* 1 ≤ length of 'name, hand, word' ≤ 12
* names and words are unique in each case.
* name, hand and word consist of lowercase English letters only.
