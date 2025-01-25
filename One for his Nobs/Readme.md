# Puzzle
**One for his Nobs** https://www.codingame.com/training/medium/one-for-his-nobs

# Goal
It's two years into the apocalypse and you've been living alone in a bunker. The only soul you can talk to is an AI bot named Nobs.  
To pass the time you play games against Nobs. But he only knows how to play Solitaire and Minesweeper which you've grown tired of. You decide to teach him your favorite pre-apocalypse game, Cribbage.

Cribbage is a two-player card and board game where you make combinations to count points and get to the target before your opponent.  
See here for all the details: https://en.wikipedia.org/wiki/Cribbage and here for the rules: https://en.wikipedia.org/wiki/Rules_of_cribbage.

Using a stack of security keycards as a deck, toothpicks for pegs, and an old pizza box for a board you start to play against Nobs.  
At first, Nobs is incredibly bad at playing since he has no idea how to play and simply discards at random into the crib.  
You decide that the only way Nobs will ever be a challenge to you is if you teach him the rules for scoring hands so that he can best decide which cards to keep.  

Write the algorithm that Nobs should use to score his hand.

*Scoring:*  
* You hold 4 cards in your hand and a fifth common starter card is cut and included when scoring your hand.
* Fifteens: 2 points for every distinct group of cards whose totals adds up to 15, (A is 1, J, Q, K are 10, all others are face value). Ex: 7H + 8D = 2 points, AS + 4C + KS = 2 points
* Runs: 3 or more consecutive cards by rank, 1 point for each card. Ex: AH + 2D + 3S = 3 points, TC + JD + QS + KC = 4 points.
* Pairs: 2 points for every distinct pair of cards with identical ranks. This means that a triplet gives 6 points and a quadruplet 12 points. 
Ex: AH + AD = 2 points, AH + AD + AS = 6 points (AH + AD, AH + AS, and AD + AS), and AH + AD + AS + AC = 12 points.
* Flushes: 4 points if all 4 cards in your hand are of the same suit, 5 points if the starter card is also the same suit. Ex: AH 2H 6H TH JC = 4 points, AH 2H 6H TH JH = 5 points, AH 2C 6H TH JH = 0 points
His nobs: 1 point if you have a J in your hand with the same suit as the starter card. Ex: AH 2H JC TH 6C = 1 point
* 29 Hand: All five 5's and the J for nobs yields the highest possible hand score of 29.

```
Ex: JH 5D 5S 5C 5H:

JH + 5H = 1 point for his nobs and fifteen for 2
JH + 5S = fifteen for 2
JH + 5C = fifteen for 2
JH + 5H = fifteen for 2
5D + 5S + 5C = fifteen for 2
5D + 5S + 5H = fifteen for 2
5D + 5C + 5H = fifteen for 2
5S + 5C + 5H = fifteen for 2
5D + 5S = 2 for a pair
5D + 5C = 2 for a pair
5D + 5H = 2 for a pair
5S + 5C = 2 for a pair
5S + 5H = 2 for a pair
5C + 5H = 2 for a pair
```

Add it all up and you get 29! The chances to get a twenty-nine hand are 1 in 216580.

# Input
* Line 1: An integer N for the number of hands to score
* N Lines: 5 Space-separated values describing the cards in the hand (The first 4 cards for the player, the 5th is the starter card).
* Cards are input as a two-character string. The first character is the card's rank (A, 2, 3, 4, 5, 6, 7, 8, 9, T, J, Q, K) and the second is its suit (Hearts, Diamonds, Clubs, Spades). 
* A has a value of 1, T, J, Q, K are all 10, the rest are all face value.

# Output
* N Lines: The score for the given hand.

# Constraints
* 1 ≤ N ≤ 10
