# Puzzle
**Organic Compound** https://www.codingame.com/contribute/view/125118491192c0f39633e7bd638caedf52179a

# Goal
This problem aims to determine the chemical name of an organic compound, given a chemical formula.

An organic compound is made of at least one carbon (C) atom, typically bonded with hydrogen (H) and oxygen (O) atoms. Suppose n is the number of carbon atoms in a molecule of organic compound.

*Prefix*  
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

Suffix:  
- Alkane contains 2n+2 hydrogen atoms and ends with -ane.
- Alkene contains 2n hydrogen atoms and ends with -ene.
- Alcohol contains a -OH functional group at the end of the formula AND contains 2n+2 hydrogen atoms. The chemical name ends with -anol.
- Carboxylic acid contains contains a -COOH functional group at the end of the formula AND 2n hydrogen atoms. The chemical name ends with -anoic acid.
- Aldehyde (also known as alkanal) contains 2n hydrogen atoms AND contains an aldehyde functional group (appear as -CHO at the end of the formula). The chemical name ends with -anal.
- Ketone (also known as alkanone) contains 2n hydrogen atoms. The carbonyl functional group -CO- appears in the middle of the chemical formula. The chemical name ends with -anone.
```
+----------------------+--------+------------+-----------+---------------------------+-------------+
| Compound Type        |   C    |     H      |     O     | Functional Group          | Suffix      |
+----------------------+--------+------------+-----------+---------------------------+-------------+
| Alkanes              |   n    |   2n + 2   |     0     | N/A                       | -ane        | 
| Alkenes              |   n    |     2n     |     0     | N/A                       | -ene        | 
| Carboxylic Acids     |   n    |     2n     |     2     | Carboxyl group (R-COOH)   | -anoic acid | 
| Alcohols             |   n    |   2n + 2   |     1     | Hydroxyl group (R-OH)     | -anol       | 
| Aldehydes            |   n    |     2n     |     1     | Aldehyde group (R-CHO)    | -anal       | 
| Ketones              |   n    |     2n     |     1     | Carbonyl group (R-CO-R)   | -anone      | 
+----------------------+--------+------------+-----------+---------------------------+-------------+
```

*Note: R represents the carbon chain (alkyl group) or a single hydrogen atom.

Chemical Formula  
In this puzzle, it contains a series of capital letters (only C, H or O) and numbers. The number after the letter (it may consist of two digits) signifies the number of atoms of the element represented by that letter (see example). If there is no number after the letter, there is exactly ONE atom of the corresponding element.

If the chemical formula does not fit the criteria for alkane, alkene, alcohol, carboxylic acid, aldehyde or ketone, output INVALID.

Alkenes vs Aldehydes vs Ketones  
All of them contains 2n hydrogen atoms.  
Alkenes only contain carbon (C) and hydrogen (H) atoms.  
Aldehydes and ketones both contain an oxygen atom, but the aldehyde group (-CHO) is located at the end of the formula in aldehydes and the carbonyl group (-CO-) is in the middle for ketones . Let's use the 'prop-' prefix as an example:  

(I) CH3CH2CH3, (II) CH3COCH3, (III) CH3CH2CHO  
1) is propane as it only contains carbon and hydrogen atoms.
2) is propanone as it contains the -CO- functional group in the middle of the formula.
3) is propanal as it contains -CHO functional group at the end of the formula.

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
- You then output INVALID (this is methyl methanoate).
  
# Input
* Line 1: Chemical formula consists of capital letters C, H, O and may contain positive integers (possibly consisting of more than one digit) to indicate the number of atoms.

# Output
* Line 1: Chemical name of the organic compound in lowercase.

# Constraints
* n, the number of carbon atoms in the compound, is an integer.
* n ≤ 10
* If the organic compound is an alkene, n > 1.
* If the organic compound is a ketone, n ≥ 3.
