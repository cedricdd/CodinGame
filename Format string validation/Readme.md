# Puzzle
**Format string validation** https://www.codingame.com/training/medium/format-string-validation

# Goal
You are given a line of text and a "string format". The format seems to be heavily inspired from LIKE clauses from SQL and uses two special characters, ? and ~:

* ?: Matches exactly one character.
* ~: Matches any number of characters, from zero (none) to the entire string.
* Any other characters: Matches exactly that character.

It seems that the format does not include escaping special characters (good for you!) so ? and ~ in text may only be matched by ? and ~ under the right circumstances.   
The backslash character will match only the backslash character itself.

The text is considered to MATCH if the format describes the text from start to end with no characters rejected by the pattern. If it does not match, write FAIL instead.

# Input
* Line 1: Text, a String
* Line 2: Format, a String

# Output
* One of either MATCH or FAIL, depending on whether Format describes Text fully.

# Constraints
* Text, Format are both composed of ASCII characters only
* 0 < Length of Text < 1000
* 0 < Length of Format < 100
