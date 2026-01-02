# Puzzle
**Simple Diff Tool** https://www.codingame.com/training/easy/simple-diff-tool

# Goal
A product owner was asked to develop a text diff tool. Unfortunately he was a bit confused because there is no id on text lines.  
So after a short time he discovered only two ways to identify lines: by their number or by their content.  
As he did not know which one is better, he asked his developer team to add the identifier method as a configuration parameter of the tool.  

The behavior of the tool is defined as follows:

Step 1: The tool matches lines from the revised file to the ones in the original file, based on the configuration parameter value.  
* If set to BY_NUMBER, lines are considered matched if they have the same line number, regardless of their contents.
* If set to BY_CONTENT, lines are considered matched if their contents are identical, regardless of their line numbers.

Step 2: The tool processes differences between matched lines, based on the configuration parameter value.  
* If set to BY_NUMBER, the tool shall output CHANGE for each pair of matched lines with unequal content.
* If set to BY_CONTENT, the tool shall output MOVE for each pair of matched lines with unequal line numbers.

Step 3: The tool processes differences between unmatched lines, regardless of the configuration parameter value.  
* The tool shall output DELETE for every unmatched line that exists only in the original file.
* The tool shall output ADD for every unmatched line that exists only in the revised file.

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
  * for a moved line: MOVE: original line @:original line number >>> @:revised line number
* The alphabetical comparison process shall compare the entire line (including the difference kind).
* The line numbers displayed shall be 1-indexed (i.e., the line numbers start at 1, not 0)

# Constraints
* 0 ≤ nbLinesV1, nbLinesV2 ≤ 20
* Within a given version of a file, every line will be unique.
* The diff tool has to support ADD, DELETE, CHANGE and MOVE differences only.
