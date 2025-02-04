# Puzzle
**Cascade of Taxes** https://www.codingame.com/contribute/view/1170992f5ef05c9c2bf128b2cdf400edff4742

# Goal
You've just won a substantial lottery prize! As a generous person, you decide to share your good fortune with your friends. You give a portion of your winnings to your closest friends. Your friends, inspired by your generosity, decide to share a portion of what they received with their own other friends. This cascading effect of sharing continues through multiple levels of friends. Remember, both your winnings and the gifts received by your friends and their friends are subject to taxation.

There is a minimum gift amount, where the individuals are not willing to share a portion of what they received when they received less than that amount.

Your task is to write a code that calculate the total amount of taxes paid to the government across all levels of gift-giving, :


*For example:*  
- You win a $1.000.000 lottery prize.
- Tax rate: 30%.
- You gift 20% to each of 3 close friends.
- Each friend gifts 20% to 3 of their other friends.
- Levels of gift-giving to consider is 4.
- $100.000 is the minimum gift amount to continue the cascading effect.

Initial Tax: $1.000.000 * 30% = $300.000.  
After-Tax Income = $700.000.  

Your Friends' Gifts (level 1):  
Each friend receives 20% of $700.000: $140.000.  
tax for each one: $140.000*30% = $42.000.  
After-Tax Income: $98.000.  
Total tax for 3 friends: $126.000.  

Friends of Friends' Gifts (level 2):  
Each friend of your friend receives 20% of $98.000: $19.600.  
tax for each one: $19.600*30% = $5.880.  
After-Tax Income: $13.720.  
Total tax for 9 friends (3 friends * 3 friends each): $52.920.  

Where $19.600 is what individuals received in this level, lower than the minimum gift amount of $100.000, we stop here. (otherwise we could continue).

Total Taxes: $300.000 + $126.000 + $52.920 = $478.920

# Input
* Line 1: w The amount of your lottery winnings.
* Line 2: t The applicable tax rate on lottery winnings and gifts received.
* Line 3: f The number of friends each person shares their portion with.
* Line 4: s The percentage of winnings each individual shares with their friends.
* Line 5: l The number of levels of gift-giving to consider (e.g., yourself, your friends, your friends' friends, etc.).
* Line 6: g The minimum gift amount.

# Output
* Line 1: "The total taxes paid are: amount." (where amount is the calculated total taxes.

# Constraints
* 0 ≤ w ≤ 2^31, (Integer)
* 0 ≤ t ≤ 1, (Decimal)
* 1 < f ≤ 10, (Integer)
* 0 ≤ s ≤ 1, (Decimal)
* 1 ≤ l ≤ 100, (Integer)
* 1 ≤ g ≤ 2^31, (Integer)
