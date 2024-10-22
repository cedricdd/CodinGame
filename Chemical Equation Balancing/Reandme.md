# Puzzle
**Chemical Equation Balancing** https://www.codingame.com/training/expert/chemical-equation-balancing

# Goal
Given a chemical formula, balance the elements present and print out the balanced equation.

Molecules will be given in a simplified molecular formula. Elements are recorded as either a single uppercase letter or as an uppercase and lowercase letter together, followed by a number if greater than 1:  
H - 1 atom of Hydrogen  
He - 1 atom of Helium  
C6H12O6 - 6 atoms of Carbon, 12 atoms of Hydrogen, and 6 atoms of Oxygen  
H2O - 2 atoms of Hydrogen, 1 atom of Oxygen  

Different molecules on a single side of the equation are separated by a plus sign surrounded by spaces:  
H2 + O2  
C6H12O6 + H20 + O2

Each side of the equation is split by an ASCII arrow (hyphen-greater than) surrounded by spaces: ->

A full equation may look like:  
C6H12O6 + O2 -> CO2 + H2O

A balanced equation where each molecule is prefixed with the coresponding coefficient when greater than 1. Ratios of coefficients should be reduced to the smallest whole integers. Molecules should be in the same order given.  
C6H12O6 + 6O2 -> 6CO2 + 6H20

The equation string will only contain letters, numbers, spaces, and the symbols for plus and an arrow. [A-Za-z0-9+-> ] There will be no parenthesis.

# Input
* Line 1: One line consisting of a chemical equation that can be balanced in only one way.

# Output
* The corresponding balanced equation.

# Constraints
* Each input will have only one way to balance the equation.
