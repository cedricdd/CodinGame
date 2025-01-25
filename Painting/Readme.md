# Puzzle
**Painting** https://www.codingame.com/contribute/view/4945053de5ace0071b0e7152228f2ef1f288b

# Goal
You have R1 liters of red paint, G1 liters of green paint and B1 liters of blue paint.  
In this universe the laws of chromatis do not work the same as in our world. So you are given a list of possible combinations.  
For example you may combine 2 liters of red paint and 5 liters of green paint and end up with 1 liter of blue paint and 1 liter of red paint.  
For that exact combination, before mixing the colors you will need at least 2 liters of Red paint and 5 liters of green paint, even though you will gain another liter of red paint. You may never have more than 30 liters of paint of any color at a time, this is due to the small deposit space of your home.  
Given the initial quantities and the list of possible combinations you want to ask yourself if you can end up at exactly R2, G2, B2 liters of red, green and blue paint? 

# Input
* Line 1 : 3 space-separated integers R1, G1 and B1 for the volumes (in liters) of red, green and blue paint respectively.
* Line 2 : 3 space-separated integers R2, G2 and B2 for the volumes (in liters) of red, green and blue paint respectively.
* Line 3 : A number N, the number of possible paint combinations.
* Next N lines : 6 numbers, in this format

"R3 G3 B3 R4 G4 B4" with the meaning of combining R3, G3 and B3 liters of red green and blue paint, you will end up with R4, G4 and B4 liters of red, green and blue paint.

# Output
* If you can end up with R2, G2 and B2 liters of red, green and blue paint then output YES else NO

# Constraints
* 1 ≤ R1,G1,B1,R2,G2,B2 ≤ 30
* 1 ≤ N ≤ 10
* 1 ≤ R3,G3,B3,R4,G4,B4 ≤ 30
* The only colors existing in this universe are red, green and blue.
