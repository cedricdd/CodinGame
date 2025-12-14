# Puzzle
**Source Code Analyser** https://www.codingame.com/training/medium/source-code-analyser

# Goal
You are given a source code and you have to analyse it: Output the names of all the called library functions & methods, with the number of occurrences for each of them.

Detailed rules: (if you are lazy reading this much, skip it and check the example & test cases...)  
* Source might contain multiple whitespaces: space, tab (\t), new line (\n) or linefeed (\r).
* Anything within string literals (within pair of single (') or double (") quotes) shall be omitted.
* Anything after single line comments (starting with //) or within multi-line comments (between /* and */ ) shall be omitted.
* A function call can be identified by a valid name, immediately followed by an opening paranthesis (
* Valid function names might contain upper and lower case letters, digits and underscore _.
* Function names shall be treated case sensitively.
* Following reserved words shall be not treated as function calls and omitted from output: "and", "array", "echo", "else", "elseif", "if", "for", "foreach", "function", "or", "return", "while", "new" (regardless of lower, upper or mixed case)
* If a function name is immediately preceded by a $, it shall be omitted (a PHP-specific rule, call of function with a name stored in a variable).
* Class names and user-defined functions shall be excluded. If the source contains "function name(" or "new name(", then the "name" shall be omitted from output.
* Output lines shall be sorted by the function names (by ascending ascii values).
* If no library call encountered, output NONE

Notes:  
* While the provided test cases are PHP source files, knowledge of PHP is no pre-requisite at all. Of course, you can solve the puzzle in any language.
* Solution would be very similar for analysing C, C++, C#, Java and Javascript source (only difference is the set of reserved keywords and how user-defined functions can be detected). 
* You can easily adapt your solution to analyze your languages of choice and analyze your own source files. 
* Analysing Python or Haskell might need a bit more change though...
* Useless fun fact: my toplist in 98k source lines of PHP: fscanf, error_log, strlen, isset, ord
* Puzzle was inspired by this blog post: https://thephp.website/en/issue/most-used-php-functions/

# Input
* Line 1: An integer N for the number of source lines.
* Next N lines: the source code to analyse (string, might contain whitespaces)
* IMPORTANT: Unlike in many other puzzles, you might need to read and process also the linefeeds at end of each line. 
* If your input reader strips the \n from the string, you might want to add it back manually.

# Output
* ?? lines: separate lines for each library function/method encountered: the name of the function and the count number of calls, space separated.
* Output lines shall be sorted by the function names (by ascending ascii values).
* If no library call encountered, output NONE

# Constraints
* 1 ≤ N ≤ 200
