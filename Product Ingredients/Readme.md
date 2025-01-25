# Puzzle
**Product Ingredients**

# Goal
European Union laws require producers to list the ingredients of their food products in a specific way:  
All ingredients must be listed in decreasing order of proportion (each ingredient is present in at least as much proportion as the one below), however the explicit percentage may or may not be given, depending on the ingredient.

Some producers take advantage of this by not explicitly writing out the proportion of ingredients they're not that proud of using. Your goal is to write a code that takes a list of ingredients as input, and outputs the possible percentage values for each ingredient. The input and output abide to the following rules:  
- All proportions are integer percentages
- The total of ingredients adds up to 100%
- If an ingredient has a range of solutions, output the inclusive lower and upper values, separated by a space
- If an ingredient has one solution, output it as a single number

# Input
* Line 1: An integer N for the number of ingredients present
* Next N lines: A string containing the name of each ingredient, optionally followed by a space then the percentage of that ingredient

# Output
* N Lines: A string starting with the name of each product and followed by its percentage, or the inclusive upper and lower bounds of its possible percentage range

# Constraints
* 1 ≤ N ≤ 100
