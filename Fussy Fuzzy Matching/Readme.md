# Puzzle
**Fussy Fuzzy Matching** https://www.codingame.com/training/easy/fussy-fuzzy-matching

# Goal
Determine which candidate strings (if any) match the given template string according to the stated rules.  
The following rules must be applied in order to match:

*letterCase*  
false = case doesn't matter - Abc matches abc, aBc, ABC, etc.  
true = case must match

*letterFuzz*  
The alphabetical distance a letter character in template is permitted to stray from its counterpart in candidate. If letterFuzz=0, the letters must match precisely.  
For example, if letterFuzz=1, ejk can match any of fjk, dil, etc, but not ejm, since m is 2 letters away from k.  
Note: Fuzziness does not wrap around the ends of the alphabet - if letterFuzz=3, B only matches any of { A,B,C,D,E } but not Y or Z  

*numberFuzz*  
The maximum permitted difference between an integer value - not the individual digits - in template and its counterpart in candidate.  
If numberFuzz=1, p25q matches p24q, p25q and p26q but not p27q or p35q; also note that e99f matches e100f.  
Numbers are never negative, and never have leading zeroes or decimal places.  

*otherFuzz*  
false = positions of non-alphanumeric characters (i.e. not a-zA-Z0-9) must match in both strings, but the specific character in each position doesn't matter, as long as it's not alphanumeric. ab,c matches ab c but not a,bc, abc or ab,,c.  
true = the exact non-alphanumeric characters must match in both strings  

*Example:*  
```
false
2
1
false
Apple10,Orange9
1
apple9?pramed7
```

```
A v a: matches (letterCase is false; alphabetical distance = 0)
p v p: matches (exact match)
p v p: matches (exact match)
l v l: matches (exact match)
e v e: matches (exact match)
10 v 9: matches (numberFuzz=1, difference = 1)
, v ?: matches (otherFuzz=false, both characters are non-alphanumeric)
O v p: matches (letterCase is false; letterFuzz=2, alphabetical distance = 1)
r v r: matches (exact match)
a v a: matches (exact match)
n v m: matches (case matches; letterFuzz=2, alphabetical distance = 1)
g v e: matches (case matches; letterFuzz=2, alphabetical distance = 2)
e v d: matches (case matches; letterFuzz=2, alphabetical distance = 1)
9 v 7: does not match (numberFuzz=1, difference = 2)
```

# Input
* Line 1: string letterCase
* Line 2: integer letterFuzz
* Line 3: integer numberFuzz
* Line 4: string otherFuzz
* Line 5: string template, the string to compare other strings against
* Line 6: integer n, the number of strings to compare to template
* Next n lines: string candidate

# Output
* n lines: true (if template matches candidate according to the rules), or false

# Constraints
* letterCase = true or false
* 0 <= letterFuzz <= 25
* 0 <= numberFuzz <= 100
* otherFuzz = true or false
* 1 <= n <= 20
* 1 <= length of template, length of candidate <= 100
* 0 <= (any number value in template or candidate) < 2^31
