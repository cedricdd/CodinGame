# Puzzle
**Match DNA Sequence** https://www.codingame.com/training/easy/match-dna-sequence

# Goal
You must find a substring corresponding to a DNA sequence gene inside another DNA sequence chr.  
Because every individual is different, the gene can have delta differences with the aligned chr  

If the last characters of genes are out of the bounds of chr (chr is too short), it counts as a delta corresponding to the missing characters.  

For example if gene is AATTAATTAATT and you only have one chr which is GAATTAACCAATTGGGGGGGGGG and the authorized delta is 3 then the output should be:
- 0 because it is the first (and only) chr matching
- 1 because the gene starts at the 2nd character of the chr
- 2 because 2 errors (delta) exists in the match (CC instead of TT)

# Input
* Line 1: An integer delta for the maximum number of difference accepted with the reference
* Line 2: A string gene corresponding to the gene to search
* Line 3: An integer n for the number of chr
* Next n lines: A string chr corresponding to the DNA in which to search it

# Output
- The index of the chr the gene was found in
- The start index of gene in the chr
- The number of difference with the gene

Or in case of no match: NONE

# Constraints
* 0 <= delta <= 10
* length(gene) == 42
* 1 <= n <= 20
* length(chr) == 128
