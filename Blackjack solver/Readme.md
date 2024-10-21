# Puzzle
**Blackjack solver** https://www.codingame.com/training/easy/blackjack-solver

# Goal
You are playing blackjack against the bank, but they no longer know the rules! Help her find who is the winner.  
To win at Blackjack, your hand must be stronger than the banker's while not exceeding 21 (inclusive).   
If a hand exceeds 21 points, the opposing hand wins unless it also exceeds 21. In this case it is a tie.  

To calculate the value of a hand, we add the values ​​of the cards as follows:  
- From 2 to 9: each card has its own face value.
- The 10, J (Jacks), Q (Queens) and K (Kings) are worth 10.
- The A (Aces) are equivalent to 1 or 11 depending on the hand-holder's advantage. If the hand does not exceed 21, the A counts 11.
  
If, on the contrary, it exceeds it, the A counts as 1;  
Example: if the hand is A A, the hand-holder will have 12 points (11+1), because 11+11=22>21 which is not to the advantage of the owner of the hand.
- The hand called "Blackjack" is composed of an A and a card worth 10, for a total of 21, received from the start (with no other card therefore).

Entries are not listed in the order the cards were dealt (the order does not matter)  
Example: A J 2 is not a blackjack, even if there is A and J, because there is a third card.

If your hand is stronger: return Player  
If your hand is weaker or bank has blackjack and not you: return Bank  
If there is a tie: return Draw  
If you have Blackjack and the bank has none: return Blackjack!  

# Input
* Line 1 : bank_cards, bank cards (separated by a space)
* Line 2 : player_cards, the player's cards (separated by a space)

# Output
* Player, Bank, Draw, Blackjack! depending on the situation
