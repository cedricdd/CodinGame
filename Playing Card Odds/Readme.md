# Puzzle
**Playing Card Odds** https://www.codingame.com/training/easy/playing-card-odds

# Goal
A standard 52-card deck consists of every combination of 13 ranks and 4 suits. Ranks are 2 through 9, T (ten), J (jack), Q (queen), K (king), and A (ace). Suits are C (clubs), D (diamonds), H (hearts), and S (spades).

A descriptive classification is a combination of ranks, suits, or both, where any of the given ranks must match, and any of the given suits must match. For instance, 8TA consists of 12 cards in total, namely the eights, tens, and aces of any suit. H represents the 13 hearts. 45C specifies only two cards, the four and five of clubs. And 7CDHS would be equivalent to just 7.

Given R descriptive classifications of cards removed from a shuffled deck, and S descriptive classifications of cards sought, find the odds of picking such a card from those remaining, stated as a rounded percentage.

*Examples*  
Consider a deck with 45C removed, leaving 50 cards. The odds of picking 7H are 1 in 50 or 2% since there is a single card that matches, namely the seven of hearts.

On the other hand, when given as separate descriptive classifications, the chances for 7 or H are 16 in 50 or 32% to pick any of 4 sevens or 13 hearts. Note that this is not 17 in 50 since the seven of hearts, which matches both ways, only shows up once.

# Input
* Line 1: Two space-separated integers R and S for the number of descriptive classifications that follow
* Next R lines: A string removed indicating cards taken out of the deck
* Next S lines: A string sought indicating cards wanted to match

# Output
* Line 1: An integer percentage immediately followed by %

# Constraints
* 0 ≤ R < 10
* 1 ≤ S < 10
