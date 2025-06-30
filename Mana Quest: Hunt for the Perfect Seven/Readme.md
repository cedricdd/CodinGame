# Puzzle
**Mana Quest: Hunt for the Perfect Seven** https://www.codingame.com/contribute/view/1260094aef9b4c2531f4a456b97853de11b6d4

# Goal
You have a 60-card Magic: The Gathering deck. Each card is represented by a 3-character string of the form TCP, where:

T indicates the type of the card:  
* C = Creature
* I = Instant
* S = Sorcery
* E = Enchantment
* L = Land

C represents the mana cost of the card. It is an integer from 0 to 9.

P indicates the color of the card:  
* W = White
* U = Blue
* B = Black
* R = Red
* G = Green

For example:  
* C1R = a Red Creature card that costs 1 mana
* L0G = a Green Land card (cost 0)
* I3B = a Black Instant card costing 3 mana

You will draw a 7-card opening hand from the deck, chosen randomly without replacement. You must compute the probability that your hand matches all of a given set of patterns, i.e. your 7-card hand contains at least one card matching each pattern.

Each pattern is a 3-character string where each character may be a specific value or x, which matches any value in that position.

For example:  
* C1x = a Creature card of cost 1 and any color
* LxB = a Land card that is Black and of any cost
* Ixx = any Instant card

== Example ==
```
Input:
7
C1R 10
C2B 5
C3G 8
I2U 12
S4W 5
L0G 15
L0B 5
2
C1x
LxB

Output:
0.3334
```
== Explanation ==

There are 10 cards of category C1R in the deck. C1x matches all those 10 cards.  
There are 5 cards of category L0B in the deck. LxB matches all those 5 cards.  
The probability that a 7-card hand includes at least one card from each of those patterns is approximately 0.3334.  

# Input
* Line 1: An integer C — the number of distinct categories in the deck.
* Next C lines: Category Count — a 3-letter category code and the number of cards in that category separated by a space.
* Next line: An integer Q — the number of patterns.
* Next Q lines: Pattern — a 3-character string representing a pattern to match, and may contain any number of xs as wildcards.

# Output
* Output a single line: the probability (a decimal between 0 and 1) that a random 7-card hand includes at least one card matching each of the given patterns, rounded to four decimal places.

# Constraints
* 1 ≤ C ≤ 60
* The sum of all Count is exactly 60.
* 1 ≤ Q ≤ 8
