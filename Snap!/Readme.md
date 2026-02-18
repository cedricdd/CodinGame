# Puzzle
**Snap!** https://www.codingame.com/training/easy/snap

# Goal
Snap is a turn-based card game where players place cards into a central pile and claim the pile when two consecutive cards share the same rank. Your task is to simulate the game and determine who the winner is and how many cards they have at the end.

Cards:
A card is a standard card from a 52-card deck, provided in the form RankSuit. The Rank represents the face value of the card and is one of: an integer in the range 2–10, J, Q, K or A. The Suit represents the card’s category and can be S, H, D, or C. Suits have the following precedence: S > H > D > C. Decks are held by players with the cards facing DOWN.

Turn-Based:  
The game begins with Player 1 placing the top card of their deck onto the central pile facing UP. Player 2 then places their top card on TOP of the pile also facing UP. Players continue alternating turns in this manner until either a Snap occurs or a player has no cards left.

Snap!  
A Snap occurs when the rank of the most recently placed card matches the rank of the card directly below it (e.g. A matches A, 6 matches 6, Q matches Q).

Before the start of the next turn, the player who played the card with the HIGHER suit precedence MUST call Snap. Once Snap is called, that player takes the entire central pile and places those cards facing DOWN on the BOTTOM of their deck. That SAME player will also take the next turn and the turn order continues as described above.

Example:  
Player 1's and player 2's deck top to bottom: 5S 6D 10D 5D JC and 3H 7S 5C KH 9S  
Play continues until a snap occurs. The central pile when a snap occurs, face-up from top to bottom: 5D 5C 10D 7S 6D 3H 5S  
Player 1's and player 2's deck top to bottom after the central pile is claimed: JC 5S 3H 6D 7S 10D 5C 5D and KH 9S  

Winning Condition:  
The game ends when a player has zero cards remaining in their deck at the start of a turn. The other player, who still has cards, is declared the winner.  

# Input
* Line 1: Integer m representing the number of cards in player 1's deck.
* Next m Lines: String representing a card in player 1's deck from top to bottom.
* Next Line: Integer n representing the number of cards in player 2's deck.
* Next n Lines: String representing a card in player 2's deck from top to bottom.

# Output
* Line 1: String indicating the winning player, in the form: Winner: Player 1/Player 2
* Line 2: The number of cards left in the winning player's deck.

# Constraints
* 0 ≤ m, n, m + n ≤ 52
* Each card is unique and will appear only once across both players’ decks.
* It is guaranteed that the game will always terminate with a single winner.
