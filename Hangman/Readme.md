# Puzzle
**Hangman** https://www.codingame.com/training/hard/hangman

# Goal
Hangman is a paper and pencil guessing game for two or more players. One player thinks of a word, phrase or sentence and the other tries to guess it by suggesting letters, within a certain number of guesses.

You are the moderator. Given an entry word or sentence, check the input letters in order. If the entry is completed, the game is won: display the resulting hangman and the final entry. The player is allowed 5 mistakes, corresponding to hangman's head, body, left arm, right arm, left leg. At the 6th mistake, the right leg is drawn and the game is over. If a letter is repeated more than once, the repeating occurrences are always considered as an error, even if the first time was correct.

A hangman will look like this after 0 to 6 errors. There should be no whitespace at the end of lines.
```
+--+   +--+   +--+   +--+   +--+   +--+   +--+
|      |  o   |  o   |  o   |  o   |  o   |  o
|      |      |  |   | /|   | /|\  | /|\  | /|\
|\     |\     |\     |\     |\     |\/    |\/ \
```

# Input
* Line 1 : a string entry to be guessed.
* Line 2 : a list of lowercase letters, separated by whitespace.

# Output
* First 4 lines : a depiction of the hangman in ASCII.
* 5th line : the entry as guessed by the player. In case of loss, missing characters will be replaced by an underscore _.

# Constraints
* 2 ≤ len(entry) ≤ 100
* 1 ≤ len(list of chars) ≤ 26
