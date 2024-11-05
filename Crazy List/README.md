# Puzzle
**Crazy List** https://www.codingame.com/training/easy/crazy-list

# Goal
The Crazy List Machine produces crazy lists of integers. Each time the Crazy Machinist creates a new crazy list, he chooses an initial value.   
Then, he chooses as many crazy operators as he wants and apply all of them on the last value of the crazy list to calculate next value.   
He repeats the crazy operators application (all the operators with the same order) growing the crazy list until his coffee machine rings.  

Each crazy operator can be:  
- Add/Subtract an integer number
- Multiply by an integer number

Examples:  
Start with 1 and apply operator +3 at each iteration will give the crazy list
```
1 4 7 10 13 ...
```
Start with 2 and apply operators +1, x3, -1, x2 at each iteration will give the crazy list
```
2 16 100 604 3628 ...
```
When the Crazy Machinist gives you a list he created, you have to predict the next number (the uniqueness of such next number is guaranteed).

# Input
* Line 1: A list of integers separated by spaces

# Output
* Line 1: The prediction of the next number
