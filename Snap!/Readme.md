# Puzzle
**Snap!** https://www.codingame.com/contribute/view/136734235ce966bb44a7c0feca9cc824a4c3bc

# Goal
Snap is a turn-based card game where players place cards into a central pile and claim the pile when two consecutive cards share the same rank. Your task is to simulate the game and determine who the winner is and how many cards they have at the end.

Cards:  
A card is a standard card from a 52-card deck, provided in the form RankSuit. The Rank represents the face value of the card and is one of: an integer in the range 2–10, A, J, Q, or K. The Suit indicates the card’s category and is one of: C, D, H, or S.

Turn-Based:  
The game begins with Player 1 placing the top card of their deck onto the central pile. Player 2 then places their top card on top of the pile. Players continue alternating turns in this manner until either a Snap occurs or a player has no cards left.

Snap!  
A Snap occurs when the rank of the most recently placed card matches the rank of the card directly below it (e.g. A matches A, 6 matches 6, Q matches Q).

The player who played the MATCHING card MUST call Snap. Once Snap is called, that player takes the entire central pile and places those cards on the BOTTOM of their deck. That same player will also take the next turn and the turn order continues as described above.

Winning Condition:  
The game ends immediately when a player has zero cards remaining in their deck. The other player, who still has cards, is declared the winner.

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
