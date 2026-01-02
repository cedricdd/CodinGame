# Puzzle
**Simple Diff Tool** https://www.codingame.com/training/easy/simple-diff-tool

# Goal
A product owner was asked to develop a text diff tool. Unfortunately he was a bit confused because there is no id on text lines.  
So after a short time he discovered only two ways to identify lines: by their number or by their content.  
As he did not know which one is better, he asked his developer team to add the identifier method as a configuration parameter of the tool.  

The behavior of the tool is defined as follows :  
It tries to match lines from the revised file to the ones in the original file based on the configuration parameter value.  
* If set to BY_NUMBER, two lines are considered the same if they have the same line number and contents.
* If set to BY_CONTENT, two lines are considered the same if their contents are identical, regardless of their line numbers.
  
After identifying all matched lines, all unmatched lines are classified under one of the three categories:
* If a line only exists in the original file, the tool shall output a DELETE.
* If a line only exists in the revised file, the tool shall output an ADD.
* If a line exists at the same line number in both files but their contents are not equal, the tool shall output a CHANGE. CHANGE is applicable to BY_NUMBER only.

# Input
* Line 1 : The configuration parameter value (BY_NUMBER or BY_CONTENT)
* Line 2 : An integer nbLinesV1 for the number of lines in the original file
* Next nbLinesV1 lines : The lines of the original file
* Next line : An integer nbLinesV2 for the number of lines in the revised file
* Next nbLinesV2 lines : The lines of the revised file

# Output
* If there are no differences you must write No Diffs.
* Otherwise, you must write a line for each difference found in alphabetical order.
* A difference shall be displayed as follows:
  * for a deleted line: DELETE: deleted line
  * for an added line: ADD: added line
  * for a changed line: CHANGE: original line ---> revised line
* The alphabetical comparison process shall compare the entire line (including the difference kind).

# Constraints
* 0 ≤ nbLinesV1, nbLinesV2 ≤ 20
* Within a given version of a file, every line will be unique.
* The diff tool has to support ADD, DELETE and CHANGE differences only.
