# Puzzle
**Score a Bridge deal** https://www.codingame.com/training/easy/score-a-bridge-deal

# Goal
The game of Bridge (https://en.wikipedia.org/wiki/Contract_bridge) is arguably the richest game of cards widely played nowadays. While difficult to master, the basic rules are relatively simple, except for the scoring part, which is quite convoluted. Scoring is obviously important for the strategy, but the details don't matter that much though, so we can let a program handle that !

The game involves a bidding phase, where an auction takes place between the two sides.   
The bids represent a contract, which means trying to win a certain number of tricks during the card play phase, with a given suit as trump (or without trumps at all).   
The highest bidder will then be the declaring side, and try to succeed in the final contract that was bid.  
With four player (two versus two) and a deck of 52 cards, there will be 13 tricks to win.   
A contract is described as the number of tricks over 6 (because you must always aim for more tricks than the opponent !), followed by the suit abbreviation (C for Clubs, D for Diamonds, H for Hearts, S for Spades), or NT for No Trump.   
For example "2S" means that you will try to win at least 8 of the 13 tricks, with Spades as trump. When nobody wants to bid, the hand is "passed out", a Pass contract, with a score of 0. Else the card play takes place, and the score depends on the actual number of tricks won, as well as two other factors : the vulnerability (V for vulnerable and NV for non-vulnerable), which is set for each side before the bidding starts, and the fact that the final contract has been doubled by the non-declaring side (noted X) or even redoubled by the declaring side, if they have been doubled (noted XX).  

Here is how the score is computed:  
If the contract was won, meaning that at least the contracted number of tricks has been won by the declaring side, the score is positive:
* If the trump is a minor suit (Clubs or Diamonds), contracted tricks (over 6 !) are worth 20 points each, for a major suit (Hearts or Spades), it is 30 points each, and for No Trump, the first trick is worth 40 points, and the next ones 30 points. If the contract is doubled, then so is the value of each trick, and if it is redoubled, the value is multiplied by 4.
* If the total value of the tricks contracted for reaches 100 points, then there is a game bonus : 300 points if not vulnerable, and 500 points if vulnerable. Else you get a 50 points bonus for having succeeded.
* If the contract is at the 6 level (contracting for all the tricks except one), there is an additional small slam bonus, worth 500 points if non-vulnerable, and 750 points if vulnerable.
* If the contract is at the 7 level (contracting for all the tricks !), there is an additional grand slam bonus, worth 1000 points if non-vulnerable, and 1500 points if vulnerable.
* If there were tricks won in excess of what was contracted, these overtricks are worth their nominal value for normal contracts, but if the contract was doubled, then overtricks are worth 100 points when non-vulnerable, and 200 points when vulnerable. These numbers are themselves doubled for redoubled contracts.
* If the contract was doubled or redoubled, there is an additional bonus for making it, 50 points for doubled contracts, 100 points for redoubled contracts.

If the contract was lost, the score is negative, and depends on the number of undertricks:
* for normal contracts, 50 points per undertrick if non-vulnerable, 100 points if vulnerable
* for non-vulnerable doubled contracts, the first undertrick costs 100, the second and third 200 each, then 300 for each additional one.
* for vulnerable doubled contracts, the first undertrick costs 200, then 300 for each additional one.
* for redoubled contracts, the values are double those of doubled undertricks.

# Input
* Line 1: An integer nbTests for the number of test cases
* Next nbTests lines: one line describing a deal : the vulnerability, either V or NV, a space, then the contract, either Pass or a number in the range 1-7 followed by C, D, H, S or NT, followed by X if the contract is doubled, or XX if it is redoubled, then (if not passed out) a space followed by the number of tricks won.

# Output
* One line per test case: the score achieved by the declaring side (either positive or negative)

# Constraints
* 1 <= nbTests <= 20
