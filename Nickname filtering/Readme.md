# Puzzle
**Nickname filtering** https://www.codingame.com/contribute/view/5832652f1a152c2fe38e96f41c636aeab13e2

# Goal
You have been hired to moderate a chat and your first assignment is to filter a list of nicknames.

The company gives you a list of banned words, a list of common letter substitutions, and a huge list of nicknames.

The letter substitutions are given in a space separated string, and you should treat all the letters in that list as being equal. For example if a = @, and the word banana is banned, so are the words b@nana, b@n@n@, banan@ etc.

A nickname is bannable if it contains any banned word.

Count how many nicknames were banned after the filtering.

# Input
* Line 1 : A space separated string containing three integers n_bans for the number of banned words, n_substitutions for the number of substitutions, n_nicknames for the number of nicknames.
* Next n_bans lines: A string banned_word.
* Next n_substitutions lines: A space separated string substitution.
* Next n_nicknames lines: A string nickname.

# Output
* The amount of banned words.

# Constraints
* The ascii value of every character is between 33 and 125 included (so no spaces).
* n_bans <= 100
* maximum length of a banned_word < 10
* n_substitutions < 25
* maximum size of a substitution rule < 5 (at most 4 letters are being equalized per line)
* equalized letters do not overlap between rules. That is you won't have:
    * a @ A t
    * t T 5 6
* n_nicknames <= 1000
* nickname_size < 50
