# Puzzle
**Next car license plate?** https://www.codingame.com/training/easy/next-car-license-plate

# Goal
French car license plates look like CG-123-BJ.  
They are of the form "ab-cde-fg", where ab and fg range from AA to ZZ, and cde ranges from 001 to 999.  

The license plates are generated in alphabetical order:  
```
AA-001-AA, AA-002-AA, AA-003-AA, ..., AA-999-AA,
AA-001-AB, AA-002-AB, AA-003-AB, ..., AA-999-AB,
...,
AA-001-ZZ, AA-002-ZZ, AA-003-ZZ, ..., AA-999-ZZ,
AB-001-AA, AB-002-AA, AB-003-AA, ..., AB-999-AA,
...,
ZY-001-ZZ, ZY-002-ZZ, ZY-003-ZZ, ..., ZY-999-ZZ,
ZZ-001-AA, ZZ-002-AA, ZZ-003-AA, ..., ZZ-999-ZZ.
```

Given the license plate of a car and the number of cars that were registered after that car, calculate the license plate of the last registered car.

# Input
* x : starting license plate
* n : number of subsequent registered cars

# Output
* y : license plate of the last car registered

# Constraints
* 1 ≤ n ≤ 100 000 000
