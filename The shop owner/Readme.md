# Puzzle
**The shop owner** https://www.codingame.com/contribute/view/116967b60d7e510274f91136c11f9c95d38ac0

# Goal
You have to calculate the biggest final cash balance of a shop after d days. For that, you have the initial cash balance c and a list of goods with a length n.  
Each good has its unitCost, its unitRevenue and its quantity which represents the total stock available for your purchase for the entire simulation period and does not replenish. Each day, you buy first, and then, you sell all your goods and update your cash balance.  
You can only buy one type of good per day. The quantity you can buy is the maximum you can afford while staying within the remaining available quantity.

# Input
* First line : the number of days d
* Second line : the initial cash balance c
* Third line : the number of types of goods n
* The n next lines : 3 integers for the unitCost, the unitRevenue and the quantity for one type of good separated by spaces.

# Output
* First line : the biggest final cash balance possible.

# Constraints
* 0 < d ≤ 50
* 0 < c
* 0 ≤ n ≤ 10
