# Puzzle
**Organic Compound** https://www.codingame.com/training/easy/organic-compound

# Goal
This problem aims to determine the chemical name of an organic compound, given a chemical formula.

An organic compound is made of at least one carbon (C) atom, typically bonded with hydrogen (H) and oxygen (O) atoms. Suppose n is the number of carbon atoms in a molecule of organic compound.

Prefix  
Depending on the amount of carbon, a different prefix is used.
```
Prefix | No. of Carbon Atoms (n)
-------+-------------------------
meth-  |       1       
eth-   |       2       
prop-  |       3       
but-   |       4       
pent-  |       5       
hex-   |       6       
hept-  |       7       
oct-   |       8       
non-   |       9       
dec-   |      10    
```

Suffix
- Alkane contains 2n+2 hydrogen atoms and ends with -ane. Alkanes do NOT contain oxygen atoms.
- Alkene contains 2n hydrogen atoms and ends with -ene. Alkenes do NOT contain oxygen atoms.
- Alcohol contains a -OH functional group at the end of the formula AND contains 2n+2 hydrogen atoms. The chemical name ends with -anol.
- Carboxylic acid contains a -COOH functional group at the end of the formula AND 2n hydrogen atoms. The chemical name ends with -anoic acid.
- Aldehyde (also known as alkanal) contains 2n hydrogen atoms AND contains an aldehyde functional group (appear as -CHO at the end of the formula). The chemical name ends with -anal.
- Ketone (also known as alkanone) contains 2n hydrogen atoms. The carbonyl functional group -CO- appears in the middle of the chemical formula exactly ONCE. The chemical name ends with -anone.

Chemical Formulae  
In this puzzle, chemical formulae refer to molecular formulae and condensed formulae only. Molecular formulae show the actual number of atoms in a compound, and condensed formulae are a shorthand way to show how atoms are connected in a molecule. In the context of this puzzle, chemical formulae should ONLY contain C, H or O and numbers. The number after the letter (it may consist of two digits) signifies the number of atoms of the element represented by that letter (see example). If there is no number after the letter, there is exactly ONE atom of the corresponding element.

If the chemical formula does not fit the criteria for any compound type mentioned above, output OTHERS.  

Example

1. C2H6
- It has 2 carbon atoms which means the prefix is eth-
- It is an alkane as it has 6 hydrogen atoms, which means the suffix is -ane.
- Knowing the above information, this molecule is ethane.

2. CH3CH2COOH
- It has 3 carbon atoms which means the prefix is prop-
- It has 6 hydrogen atoms and contains functional group -COOH, which means it is a carboxylic acid and has the suffix -anoic acid.
- This is propanoic acid.

3. HCOOCH3
- It has 2 carbon atoms and 4 hydrogen atoms, which means it could be an alkene, an aldehyde, or a ketone.
- HOWEVER, it has TWO oxygen atoms which do not fit the criteria for all of them.
- You then output OTHERS (this is methyl methanoate).
- Why this is not ethanoic acid (CH3COOH)? The functional group -COOH always appears at the end of the formula. Even though they have the same amount of hydrogen, carbon and oxygen atoms, the functional group not being at the end of the formula makes it a different compound.

# Input
* Line 1: Chemical formula consists of capital letters and may contain positive integers (possibly consisting of more than one digit) to indicate the number of atoms.

# Output
* Line 1: Chemical name of the organic compound in lowercase or OTHERS.

# Constraints
* n, the number of carbon atoms in the compound, is an integer.
* n ≤ 10
* If the organic compound is an alkene, n > 1.
* If the organic compound is a ketone, n ≥ 3.
