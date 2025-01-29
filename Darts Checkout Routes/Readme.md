# Puzzle
**Darts Checkout Routes** https://www.codingame.com/training/easy/darts-checkout-routes

# Goal
In darts, it's important to know which segments to aim for in order to checkout (see definition below) and win the leg. There are some checkout routes that are considered better than others, but there are many ways to checkout a score using a given number of darts.

The goal is to calculate the number of routes to checkout a given score with a given number of darts.

*Dartboard:*  
A dartboard contains three different segments: singles, doubles and trebles. The values for each are:  
* Singles: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 25
* Doubles: D1, D2, D3, D4, D5, D6, D7, D8, D9, D10, D11, D12, D13, D14, D15, D16, D17, D18, D19, D20, D25
* Trebles: T1, T2, T3, T4, T5, T6, T7, T8, T9, T10, T11, T12, T13, T14, T15, T16, T17, T18, T19, T20
Double values are singles multiplied by 2. Treble values are singles multiplied by 3, except there is no treble 25 (E.g. D4 = 8, T4 = 12).

Some values are numerically the same but represent distinct throws on the board, as they're in different segments (e.g. 12, D6 and T4).

Throwing a dart costs 1 dart and MUST receive the value of any single, double or treble.

*Checkout:*  
In order to checkout, the total sum of the darts thrown MUST equal score and use LESS THAN OR EQUAL TO darts number of darts. The final dart in any checkout route MUST land in the double segment.

*Throw Order:*  
Given a valid route, swapping the order of two different darts is considered to be two separate routes.  
Two route example: T5 D10 D10 and D10 T5 D10 are two valid paths.  
Single route example: 10 D25 D25 - Swapping dart 2 and 3 is considered the same route.  

# Input
* Line 1: Integer score representing the remaining score.
* Line 2: Integer darts representing the number of darts remaining to throw.

# Output
* Integer of number of possible routes to reach score using at most darts number of darts.

# Constraints
* 1 ≤ score ≤ 170
* 0 ≤ darts ≤ 5
