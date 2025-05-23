# Puzzle
**Personal Best** https://www.codingame.com/training/easy/personal-best

# Goal
The puzzle input provides one or more gymnasts' names and competition categories, for example "Simone Biles" and "bars", following which will be a set of competition records.   
Each record contains a gymnast's name and the points they scored on the bars, the balance beam, and for floor work.   
There may be more than one competition record per gymnast.  

The puzzle requires that you read through all the records, and find the highest score for each of the given gymnast/s in the given category/categories.

# Input
* Line 1: The name of one or more gymnasts for whom to provide a personal best
* Line 2: One or more categories for which to find the personal best; these can be "bars", "beam", or "floor"
* Line 3: An integer N for the number of competition records provided
* Next N lines: One string and three floating point values, separated by commas, representing a gymnast and the number of points they scored in each category. 
* These values represent a gymnast's name, and their score on the bars, beam, and floor work in a competition.

# Output
* One or more lines, each one a comma-separated list of the maximum points for the given gymnasts for the requested categories, in the same order.

For example, given the input:
```
Paris Berelc,Ariana Berlin
bars,floor
```

The output would be:  
```
bars score for Paris Berelc,floor score for Paris Berelc
bars score for Ariana Berlin,floor score for Ariana Berlin
```

# Constraints
* 1 ≤ N ≤ 40
* 6 ≤ bars, beam, floor < 10
* Each of the gymnasts in gymnasts will always have their name included in the competition records.
* Points scores (bars, beam, floor) will have between 0 and 2 decimal places, sometimes mixed.
