# Puzzle
**Blood Types** https://www.codingame.com/training/medium/blood-types

# Goal
Your blood type is comprised of two blood groups: ABO (A, B, AB, or O) and Rh (+ or -), which are inherited from parents.

Inheritance is closely related to the genes pairing mechanism. Each person has two genes to determine his/her ABO blood type, as listed below:
```
AA = A blood type
AO = A blood type
BB = B blood type
BO = B blood type
OO = O blood type
AB = AB blood type
```

Each biological parent donates one of two ABO genes to their child. For example, a parent of O blood type with genes OO and a parent of A blood type with genes AA will have a child with one A gene and one O gene (AO), which is an A blood type.

Suppose the A blood type parent in the above example is having genes AO, it is possible to have a child of blood type either A or O.

Rh Factor  
Rh factor refers to a protein that may be found on the covering of red blood cells. If your red blood cells have this protein, you are Rh+. Otherwise, you are Rh-.

Just as everyone inherits ABO genes, every person inherits one Rh gene from each biological parent, which finally determines whether the Rh protein is present.
```
++ = Rh+
+- = Rh+
-- = Rh-
```

Combining ABO type and Rh factor, there are eight blood types:  
A+, A-, B+, B-, AB+, AB-, O+, O-

We use this expression to describe the blood type inheritance relationship:  
parent + parent = child

There are 3 variables in the equation. Two variables will be given. You are going to determine all possible values in the unknown variable.

```
For example, A- + O+ = ?  
Answer is A+, A-, O+, O-
```

# Input
* Line 1: N, the number of lines to follow
* The following N lines: Each line contains 3 strings, space separated.
* The first 2 strings are the blood types of parents. The third string is the blood type of their child.
* One of these strings will be a question mark (?) which is the unknown variable.

# Output
* Write N lines.
* For each line of input, write a line of output showing all possible blood types, separated by a space, to fit in the unknown variable.
* When there are more than one possible blood type as answer, sort them by ASCII order. If there is no blood type fitting the equation, write output as: impossible

# Constraints
* 1 ≤ N ≤ 100
