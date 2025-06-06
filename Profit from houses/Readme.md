# Puzzle
**Profit from houses** https://www.codingame.com/contribute/view/74595c455c1d7471c104d5fbd92a504a58da0

# Goal
You are a Real Estate investor looking for houses-for-sale where the price is significantly less than expected, with the hopes that this will help you make a profit.

*Your task:*  
expectedPrice is calculated using the averagePriceForSqFoot for the State that house is located in. (This info for each State is provided in the stub.)

A house is "undervalued" if its price is less than expectedPrice.  
Output each house that is undervalued (undervaluedAmount) by at least $25,000.  
Print in descending order of that undervaluedAmount.  

Then print the total of all those undervaluedAmounts, which is your potential profit.

Notes:  
* Some States are two words, like New York.
* When calculating expectedPrice, round to nearest dollar amount.

Source: https://finance.yahoo.com/news/study-reveals-average-cost-per-195736142.html

# Input
* Line 1: An integer, numOfHouses to follow
* Next numOfHouses Lines: A string, a description of a house in the following format:  
Example: (1) 967 sqFt house for $423,460 in New York

# Output
* Multiple Lines: Each house that is undervalued at least $25,000 in the format of: "Id is undervalued by undervaluedAmount"
* Sorted in descending order of that undervaluedAmount
* Next Line: Total potential profit is total of above listed undervaluedAmounts
* All dollar amounts should be formatted with a $ and commas as needed for thousand-separators.

# Constraints
* There are no "ties"; i.e., each house in output has a unique undervaluedAmount
