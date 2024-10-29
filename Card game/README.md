# Puzzle
**Card game** https://www.codingame.com/contribute/view/49878199063d94030d0fbffa528f1bfcb6d51

# Goal
TOM and SAM decided to play a card game.

At the beginning, each player receives 26 randomly drawn cards from a regular deck of 52 cards.  
For example, the ace of clubs, the king of spades, the queen of hearts and the jack of diamonds are respectively represented like this: AC, KS, QH, JD  

Regardless of suit, cards are ranked from highest to lowest as follows:  
A, K, Q, J, 10, 9, 8, 7, 6, 5, 4, 3, 2

In each round, players turn over the top card of their deck.  
If the 2 cards are of the same value, the 2 cards are definitively removed from the game.  
If not, the player with the highest card wins the 2 cards and places his opponent's card under his deck BEFORE placing his own.  

When at least 1 of the 2 players has no more cards, the game is over and the winner is the one who still has cards in hand. If no one has a card, it's a draw.  

You have to find who is the winner (TOM, SAM or DRAW) and how many rounds there were in the game.  

# Input
* Line 1 : A string tomDeck for Tom's deck of cards sorted in playing card order, each card separated by a comma.
* Line 2 : A string samDeck for Sam's deck of cards sorted in playing card order, each card separated by a comma.

# Output
* Line 1 : A string with the winner name (TOM, SAM or DRAW) and the number of rounds in the game separated by a space
