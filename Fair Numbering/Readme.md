# Puzzle
**Fair Numbering** https://www.codingame.com/training/medium/fair-numbering

# Goal
Alice and Bob are preparing printed notes for their CEO to use in a product launch event.   
However, at the last moment they found that they forgot to add page numbers into some pages.  

They have no time and no ink in the printer to print the notes all over again.   
They opted to handwrite the needed page numbers at the bottom of each unnumbered page.  

The unnumbered pages are in a continuous range. Alice will handwrite the numbers in the first half of the range. Bob will do the rest.

Half and half. Is this division of labor fair? Nonono.

Suppose they have to write from page 1 to page 200. According to this simple division, Alice will write 1, 2, 3... until 100.   
Bob will write 101, 102, 103... to 200. Bob will have to write a lot more digits than Alice!

Could you help them find a fair way to split the task? Find the number of the last page that should be numbered by Alice, so that both of them will write the same number of digits.   
If it turns out to be impossible, find the last page for Alice such that Alice's digit-writing count will be as far as possible close to and not more than Bob's.

☀ A page number has to be written by either Alice or Bob. They cannot jointly write one number.  
☀ Page numbers are all decimal integers count from 1. The missing number pages can start from page 1 or anywhere in the middle of the notes.  

# Input
* There are multiple tests in each test case.
* Line 1: Integer N, the number of tests to follow.
* Following N lines: Each line has two integers, st ed, for the starting and ending page numbers (inclusive) defining the range of pages that needs handwritten numbering.

# Output
* N Lines: For each test in the input, write the corresponding last page number that should be responsible by Alice to write the needed page number on.

# Constraints
* 1 ≤ N ≤ 200
* 1 ≤ st < ed ≤ 10,000,000
