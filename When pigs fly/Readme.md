# Puzzle
**When pigs fly** https://www.codingame.com/training/expert/when-pigs-fly

# Goal
Given a set of universal truths, determine whether All, Some, or No pigs can fly.

Each of N lines contains a logical statement S in the following general form:
```
    OBJECTA (are OBJECTB | have TRAIT | can ABILITY)
        or
    TRAITA are TRAITB$
```
where parentheses contain options separated by pipes ( | ). Furthermore, OBJECTS can be expanded like so:
```
    OBJECT [with TRAITA [and TRAITB ...]] [that can ABILITYA [and ABILITYB ...]]
```
where brackets [ ] denote optional text.

Below are sample statements.
1) MICE are RODENTS
2) MICE with WINGS are BATS
3) MICE that can FLY are ANIMALS with SUPERPOWERS
4) BATS are RODENTS
5) RODENTS with FEET and NOSES that can EAT are POPSICLES

To clarify, statement (1) means that all MICE are RODENTS, but only some RODENTS are MICE. Furthermore, it cannot be assumed from statements (1) and (4) that some MICE are BATS.
Note for logicians and mathematicians: The statement (2) is not an hypothetical proposition, it implies that MICE with WINGS do exist. In a nutshell: All objects evoked are supposed to exist.

The task is to determine what can be concluded about pigs flying: must it be true for all pigs, some pigs, or none?

# Input
* Line 1: An integer N representing the number of statements.
* Next N lines: A logical statement S written as described in the prompt.

# Output
* A string stating what can be concluded from the input about pigs flying:
  1) All pigs can fly
  2) Some pigs can fly
  3) No pigs can fly

# Constraints
* 2 ≤ N ≤ 15
* 1 ≤ Length of S ≤ 256
* PIGS appears in at least one statement
* FLY appears in at least one statement
* Statements are composed of letters and spaces
* OBJECTS, TRAITS, and ABILITIES are written in uppercase, and everything else is in lowercase.
