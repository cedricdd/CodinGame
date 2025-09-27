# Puzzle
**Hill Notation and Hill Order** https://www.codingame.com/training/medium/hill-notation-and-hill-order

# Goal
Given a number of chemical formulas, convert them all to Hill Notation and then sort them into Hill Order while eliminating duplicates.

Hill Notation is used to succinctly express chemical formulas in precisely one way.  
Hill Order is a way to sort compounds that make them easy to index.  
For more information — https://en.wikipedia.org/wiki/Hill_system  

Hill Notation consists of condensing any parenthesis group, counting the total number of each element and reordering them according to the following rules:  
* If the compound contains Carbon (C), then it is always listed first, followed by Hydrogen (H) if present. All other elements are then sorted alphabetically and appended. For example, CH3CH2OH becomes C2H6O.
* Else sort all elements (including Hydrogen) alphabetically.

Hill Order sorts elements in Hill Notation according to the following rules:  
* Compounds are sorted alphabetically by element. So Al2O3 comes before CH4.
* If the elements are in the same order, the one with fewer of the element is sorted first.

The following compounds are in Hill Order:  
```
BrF5 → CCl → C2H6 → C3H8 → C60 → CaO → ClH
```

# Input
* Line 1: An integer N representing the number of compounds to sort
* Next N lines: A chemical formula consisting of uppercase and lowercase letters, parentheses, and numbers.

# Output
* Up to N lines: of compounds expressed in Hill Notation and sorted in Hill Order

# Constraints
* 1 ≤ N ≤ 20
