# Puzzle
**Guessing digits** https://www.codingame.com/training/medium/guessing-digits

# Goal
Three bright students, Maggie, Burt and Sarah, are playing a little game: guessing a couple of digits.

Maggie picks two digits a and b between 1 and 9, possibly equal.  
She writes their sum on a blue piece of paper and gives it to Burt.  
She writes their product on a red piece of paper and gives it to Sarah.  

She first asks Burt if he knows a and b. If he doesn't, she asks Sarah. If she doesn't, she asks Burt again, and so on until one of them knows.

You must output the two digits picked by Maggie, the name of the first person who guessed them, and the number of rounds that were needed. (One round is asking both Burt and Sarah.)

# Input
* Line 1: the digits' sum s, visible to Burt only
* Line 2: the digits' product p, visible to Sarah only

# Output
One line: space separated:
* (a,b) in ascending order
* the name of the first person to guess: BURT or SARAH
* the number of rounds Example: (1,2) SARAH 1
* If the two digits cannot be guessed, just output IMPOSSIBLE.

# Constraints
* 1 ≤ a, b ≤ 9
* s = a + b
* p = a × b
