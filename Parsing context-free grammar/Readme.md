# Puzzle
**Parsing context-free grammar** https://www.codingame.com/training/hard/parsing-context-free-grammar

# Goal
Topic: Context-free grammars, CYK algorithm, dynamic programming

Given the context-free grammar and a set of words, your task is to decide which words belong to the language defined by that grammar.

The grammar is presented in Chomsky normal form, without epsilon-rules. Non-terminal symbols are always uppercase letters, terminal symbols are always lowercase letters.

# Input
* Line 1: the number N of rules in the grammar
* Line 2: the character START indicating the start symbol
* Next N lines: rules of the grammar
* Next line: the number T of testcases
* Next T lines: words to parse

# Output
* T lines containing true if word can be successfully parsed by the grammar, false otherwise.
  
# Constraints
* 0 < number of terminal symbols < 25
* 0 < number of nonterminal symbols < 25
* 0 < N < 100
* 0 < T < 100
* 0 < length of word < 100
