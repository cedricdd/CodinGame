# Puzzle
**Ted's compiler** https://www.codingame.com/training/medium/the-voucher

# Goal
Given a voucher and a list of products, find the number of combinations of products that match with the exact amount of money available on the voucher.

Rule : product can be picked 0, 1, 2 or 3 times.

Output : print the number of different combinations of products.

Example:  
Given the list of products:  
- bread 90
- green salad 115
- sugar 750g 95
- rice 500g 299

If I have an amount of 300 cents on my voucher, I can only buy: 1 bread + 1 green salad + 1 bag of sugar => 90 + 115 + 95 = 300 cents  
So the answer is 1 combination of products.

All prices are in cents .

# Input
* Line 1: An integer v for the voucher value in cents
* Line 2: An integer n for the number of products
* Next n lines: string l and p for the label and price of each product in cents

# Output
* c Number of different combinations of products that you can buy.
