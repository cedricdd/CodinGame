# Puzzle
**Shipping costs** https://www.codingame.com/contribute/view/147030a191f51b9de27a8622899d57a78d1e15

# Goal
You work at a shipping company, and are tasked with automating the shipping cost computation for an e-commerce platform! In order to do so, you are provided with a set of business rules and customer order details, and for every such order, you must compute the shipping cost.

Business rules are composed of a set of conditional rules, which only apply if the associated condition is met, and a default rule to apply if none of the conditional rules have applied.

Each conditional rule consists of a condition to match and a cost formula to apply if the condition matches, and as such, is composed of the following properties:
* The quantity to consider, among pallets (number of wooden pallets), parcels (number of parcels) and kg (total weight in kilograms).
* The operator, among <=, <, >= or >, representing the operation between the quantity of the order on the left and the condition value on the right.
* The value, as an integer.
* Whether the cost is a unit cost (unit) or a fixed cost (fixed), i.e. whether the cost must be multiplied by the quantity or not.
* The cost in euros.

For example:
* kg < 2 fixed 5 means "If the weight in kilograms in the order is strictly less than 2, then the cost will be a fixed cost of 5 euros".
* parcels >= 5 fixed 20 means "If the number of parcels in the order is greater than or equal to 5, then the cost will be a fixed cost of 20 euros".
* pallets <= 3 unit 50 means "If the number of pallets in the order is less than or equal to 3, then the cost will be 50 euros multiplied by the number of pallets".

The default rule provided after the conditional rules consists of the following properties:

* The quantity to consider, among pallets, parcels and kg; only considered if the cost is a unit cost.
* Whether the cost is a unit cost (unit) or a fixed cost (fixed), i.e. whether the cost must be multiplied by the quantity or not.
* The cost in euros.

For example:
* pallets fixed 200 means "The order will have a shipping cost of 200 euros".
* parcels unit 20 means "The order will have a shipping cost of 20 euros multiplied by the number of parcels in that order".

Each order consists of the following properties:
* A number of pallets.
* A number of parcels.
* The total weight in kilograms.

For every order, you must compute the cost according to the first matching conditional rule for that order, or using the default rule if none of the conditional rules have matched that order.

# Input
* First line: An integer conditionalRuleCount for the number of conditional rules.
* Next conditionalRuleCount lines: Each line is a conditional rule, composed of conditionalRuleQuantity, conditionalRuleOperator, conditionalRuleValue, conditionalRuleCostType and conditionalRuleCost, separated by spaces.
* Next line: Default rule, composed of defaultRuleQuantity, defaultRuleCostType and defaultRuleCost, separated by spaces.
* Next line: An integer orderCount for the number of orders.
* Next orderCount lines: Each line is an order, composed of orderPallets, orderParcels and orderKg, separated by spaces.

# Output
* orderCount lines: orderShippingCost in euros, one line per order.

# Constraints
* 0 <= conditionalRuleCount < 10
* 1 <= orderCount < 10
* All numeric quantities in the input and expected output can be represented as 31-bit unsigned integers.
