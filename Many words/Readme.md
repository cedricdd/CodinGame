# Puzzle
**Many words** https://www.codingame.com/contribute/view/108288800a26973b2a6423e44327ffd46ecfce

# Goal
Consider the following conditions to build a string of length characters:
* Must contain only characters from the given alphabet.
* The same character may appear twice or more.
* The resulting string does not need to have a meaning in English or any other language.
* Must satisfy the given set of rules. The rules are given in a code of 3 symbols:
   * The first one denotes if a given character must exist or not.
      * \+ means must exist.
      * \- means must not exist.
   * The second one is the character which must or must not exist.
   * The third one is the position where the character must exist or not.

0 (zero) means somewhere/anywhere. Possible values other than 0 are 1 to length (inclusive).

Please answer the number of strings that satisfy all these conditions.

# Input
* Line 1: An integer a_len for the length of the alphabet.
* Line 2: A string alphabet for the alphabet.
* Line 3: An integer length for the length of the word to generate.
* Line 4: An integer rule_n the number of rules.
* Next rule_n lines: A string rules for the rules to satisfy.

# Output
* Line 1: A single line containing the number of strings that you are able to create.

# Constraints
* 0 < a_len ≤ 30
* 1 ≤ length ≤ 8
* 0 ≤ rule_n ≤ 6
