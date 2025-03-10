# Puzzle
**Cooking passion** https://www.codingame.com/training/medium/cooking-passion

# Goal
You love cooking. Therefore, you often go to the shop to buy ingredients for your recipes. Sometimes, you can't, so you ask your dog to go.  
But he can't read numbers, so he doesn't buy the quantities you need. Given the recipe and the list of ingredients your dog bought, with their respective quantities, find how many times you can cook this meal before you run out of an ingredient.  
Output the first ingredient that will be running out, how many times you can cook, and how much of each ingredient you will have left.

# Input
* First line: Two integers num_recipe and num_ingredients, respectively the number of lines of the recipe and the number of ingredients your dog bought
    * num_recipe following lines: A line of the recipe, either an ingredient (beginning with -, then its quantity and its name) or a line to ignore (not beginning with -)
    * num_ingredients following lines: An ingredient (its name and its quantity) your dog bought

Each quantity is either an integer in g / cl or a float in kg (1000g = 1.0kg) / L (100cl = 1.0L)

# Output
* First line: limiting_ingredient The ingredient that will run out first
* Second line: num_cooking How many times you can cook the meal before you run out of limiting_ingredient
* num_ingredients-1 following lines: An ingredient, followed by the quantity remaining, expressed as an integer in grams (respectively centiliters) if it is <1kg (respectively <1L), a float in kg or L otherwise (with at least one digit after the decimal point).
* Ingredients must be ordered by quantity, in ascending order, beginning with solid ingredients (in g/kg). Don't output the limiting_ingredient.

# Constraints
* 1 < num_ingredients ⩽ num_recipe < 50
* 0 < length of a line < 500
* The quantity of limiting_ingredient in grams is a multiple of the quantity needed in the recipe, therefore num_cooking is an integer.
* There is only one limiting_ingredient.
