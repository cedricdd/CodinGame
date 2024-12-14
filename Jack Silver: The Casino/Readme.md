# Puzzle
**Jack Silver: The Casino** https://www.codingame.com/training/easy/jack-silver-the-casino

# Goal
Jack Silver is a spy from the international spy agency.

In his current mission he observes his targets at a roulette table at the Great Grand Casino in Villan City.   
He needs to know how much money his targets have at the end of the game.

The target plays as follows:  
- He always bets 1/4 of the cash he currently has. If it is a fractional value, he always rounds up.
- The target's calls, CALL, can be one of the three possibilities:  
  - EVEN - He bets on an EVEN (non-zero) number
  - ODD - He bets on an ODD number
  - PLAIN - He bets on a specific number: NUMBER

NOTE: Since the odds of winning are much lower for PLAIN bets, the payout for a win is higher: 35 to 1.   
For EVEN and ODD, the payout is 1 to 1. As an example, if the ball comes up as 23, and the target bets 100, the payouts would be as follows:  
- If he called EVEN, then he would lose his 100 bet.
- If he called ODD, then he would get his 100 bet back, plus an extra 100.
- If he called PLAIN and specified any number other than 23, he would lose his 100 bet.
- If he called PLAIN and specified 23 as his number, he would get back his 100 bet plus an extra 3500.

# Input
* Line 1: An integer, ROUNDS, for the number of rounds the target is playing
* Line 2: An integer, CASH, for the amount of cash the target starts with
* Next ROUNDS lines: The target's PLAY for that round, consisting of either 2 or 3 space separated variables:
  1) an integer, BALL, which represents the roulette table result
  2) a string, CALL, which represents the call the target made
  3) (optional) an optional integer, NUMBER, which represents the selected number when the target's call is PLAIN

# Output
* The amount of money, MONEY, the target has after ROUNDS of playing

# Constraints
* 1 ≤ ROUNDS ≤ 100
* 50000 ≤ CASH ≤ 100000
* CALL can be the text EVEN, ODD or PLAIN with an integer NUMBER
* If NUMBER is set 0 ≤ NUMBER ≤ 36
* 1 ≤ MONEY ≤ 1 000 000
