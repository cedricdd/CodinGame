# Puzzle 
**Advertisements** https://www.codingame.com/training/hard/advertisements

# Goal
Higher management of your local supermarket has implemented a variety of advertisements: X for the price of Y, for groups of products, product groups or brands. Nice and all - but as their neighborhood IT specialist it falls to you to upgrade their check-out system. During evaluating their advertisements, it seems some shady deals are going on ('2 apples for the price of 3?!') - but you are only the IT specialist, so you simply follow the assignment to the letter.

Based on scanning the advertisement(s) and a list of items, your program must output the total price to be paid for those items (after all price changes due to the advertisements), and the discount. Output the total price and discount as floats with two decimal places (cents).

Advertisement and shopping list formats  
All advertisements are in the following format: All S: X for the price of Y  
X and Y can be any integer, and S can be either a product, group or brand name. For example:  

All deodorant: 3 for the price of 2

Items in the item list are in the following format:  
product group brand price.  
For example:  
deodorant hygiene aks 4.95

- product: the type of item
- group: the product group an item belongs to, like hygiene, food, drinks, etcetera
- brand: a brand name

# Rules
* An advertisement always concerns either a product, a group or a brand.
* There will never be multiple advertisements for an identical product, group or brand.
* All names (product, group and brand) are unique.
* It is possible that for a certain advertisement there are no items in the list, or that for certain items there is no advertisement.
* In all situations of multiple options, calculations are applied for the benefit of the customer.
  - If of X items, Y need to be paid, and X>Y, the X-Y highest prices are waived. If X<Y, the lowest price is added Y-X times (for example: All seafood: 2 for the price of 3).
  - If items qualify for multiple advertisements, only one of the advertisements is applied: the one that results in the highest discount.

Specifics regarding qualifying for multiple advertisements  
* In none of the tests and validation cases an item will qualify for more than two advertisements.  
* In case of multiple advertisements, one advertisement is applied to the fullest, and only after that the next advertisement is applied .The order of advertisements needs to be such that it leads to the best result for the customer (see rule 5).  
  
For example, 10 items qualify for both advertisement A: 3 for 2, and B: 4 for 1. If advertisements are considered in order A -> B, then first A will be applied fully (3 * 3 for 2), leaving only 1 item (not enough for B). If instead the order of B -> A is considered, then first B will be applied (2 * 4 for 1), leaving only 2 items (not enough for A).

# Input
* Line 1: integer na: number of advertisements
* Next na lines: string advertisement, 'All S: X for the price of Y'. S can refer to an item's product, group or brand.
* Next line: integer ni: number of items on shopping list
* Next ni lines: four space separated strings: per item the product, group, brand and price. price is always a float.

# Output
* Line 1: float with two decimal places: price after discount
* Line 2: float with two decimal places: discount given

# Constraints
* 0 <= na <= 10
* 0 < =ni <= 50
* 0 <= X,Y <= 10
* 0.10 <= price <= 50.00
