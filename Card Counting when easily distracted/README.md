# Puzzle
**Card Counting when easily distracted** https://www.codingame.com/training/easy/card-counting-when-easily-distracted

# Goal
In this simplified version of "Card Counting", you are playing Blackjack at a casino table, that uses only one standard deck (52) of cards.  
Fortunately, you have an amazing memory and incredible math skills.  
Unfortunately, you are easily distracted and there's a lot going on.  

Your streamOfConsciousness is what you observe intermingled with your thoughts.  
Each chunk of that (separated by a period.) might be a string of cards or something else.  
(It is a string of cards if it consists solely of cards; see abbreviations used below.)  

With your knowledge of all the observed cards, calculate the percentageChance (rounded to nearest whole number) that the value of the next card will be less than the bustThreshold.  
(The bustThreshold is what would make your hand "go-bust"/lose by going over 21; it isn't anything you need to calculate; it is provided to you.)

Abbreviations used, and values:  
* K = King
* Q = Queen
* J = Jack
* T = Ten  
(all the above have a value of 10)
* A = Ace (has a value of 1)
* the Number cards (2 through 9, inclusive) each has its own value

*Examples:*  
* JT7A44 means: a Jack, a Ten, a 7, an Ace, and two 4s
* JAKE might be your buddy, but it's not a series of cards, since "E" isn't a valid abbreviation
* AT&T might be your cell-service provider, but it's not a series of cards, since "&" isn't a valid abbreviation
* T1 might be a data/telecom line, but it's not a series of cards, since "1" isn't a valid abbreviation

# Input
* Line 1: a string streamOfConsciousness
* Line 2: an integer bustThreshold

# Output
* Line 1: an integer percentageChance%

# Constraints
* 2 ≤ bustThreshold ≤ 10
