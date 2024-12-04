# Puzzle
**Genetics and Computers** https://www.codingame.com/training/easy/genetics-and-computers---part-1

You will be given the genotypes of 2 parent plants as parent_1 and parent_2 respectively. We are using a Dihybrid Cross, where 2 characteristics of each parent plant will be taken. Your code must determine the genes of their possible progeny by using Checkerboard method. By checkerboard method or Punnett Square method, you can cross the genes of the parents and find the possible characteristics of its seedlings.

Let us for example take RrYy and RrYy to be the parent plants. By Checkerboard method:  
In RrYy, multiply R with Y and y, and r with Y and y. You will get RY, Ry, rY and ry as the genes. Represent them in the top column. Do the same for the second parent and represent them in the first row. Now multiply the rows and columns. For example, in the first row, RY is both the column as well as the row. Multiplying them, you get RYRY. Now, arrange it by the rule specified below.
```
_______RY ________ Ry __________ rY __________ ry

RY___RRYY_______ RRYy_______RrYY_______RrYy

Ry___RRYy________RRyy______ RrYy_______ Rryy

rY___RrYY_________RrYy_______rrYY________rrYy

ry___RrYy_________Rryy_______rrYy________ rryy
```

These are the 16 possible genotypes of the seeds. The same genotype can appear more than once if it can be made by different parental genes. For example, RrYy appears four times in this table. (Note: Dominant genes are written in capital and recessive ones are written in lowercase. A dominant gene is always placed before a recessive gene. For example: r,R,y,Y must be written as RrYy.)

Cross the parent genes using this method and count the number of progeny with the genotypes requested in the input. Add a colon (:) in between the counts. Also note that a gene, for eg. rryy cannot be produced by crossing RRYY and RRYY, even though rryy can be mentioned in ratio as RRYY:rryy. In that case, return 0 in its place, that is, ratio is 16:0. Also you must output a simplified form of the ratio.   So the final output becomes 1:0.  

# Input
* Line 1: The genes of parent_1 and parent_2
* Line 2: The format of genotypic ratio

# Output
* Line 1: The genotypic ratio as per the format provided in second line of input

# Constraints
* Length of parent_a = Length of parent_b = 4
* Length of ratio < 50
