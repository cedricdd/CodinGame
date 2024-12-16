# Puzzle
**Kangaroo words** https://www.codingame.com/training/easy/kangaroo-words

# Goal
Given a thesaurus, consisting of words grouped by synonyms, you must identify all kangaroo words and their corresponding joey words.

A kangaroo word is a word that contains all the letters of one of its synonyms, called a joey word, arranged so that these letters appear in the same order in both words. For example, the word inflammable is a kangaroo word containing the joey word flammable; the words: action, healthiness, also, each include their own synonyms. In the kangaroo word, the letters may also be separated, as in masculine, which contains the letters of male scattered throughout. - From Wikipedia.

The program must output all kangaroo words contained in the given thesaurus followed by : and their corresponding joey words, separated by comma and a space. The output should be in alphabetical order.  
If no words in the given thesaurus are kangaroo words the program should output NONE instead.

Example:  
Given a thesaurus with 2 groups of synonyms:
```
detect, examine, inspect, note, see, observe
bag, box, can, container, tank, tin
```

Output the 2 kangaroo words on separate lines in alphabetical order. After each kangaroo output : followed by all corresponding joeys, in alphabetical order, separated by ,
```
container: can, tin
observe: see
```

# Input
* Line 1: An integer N for the number of groups of synonomous words to check.
* Next N lines: A string containing words that are synonyms, separated by ,

# Output
* For each kangaroo word a line containing: Kangaroo word: First joey, /.../ Last joey
* OR: NONE

# Constraints
* 1 ≤ N ≤ 10
* All words contain only lowercase letters.
* All words are considered synonyms with all words in the same thesaurus group (one input-line) and with no other words.
