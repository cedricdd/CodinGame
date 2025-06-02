# Puzzle
**Key-value store** https://www.codingame.com/training/easy/key-value-store

# Goal
In this puzzle, your task is to implement a key-value store that supports the following commands:

➤SET key1=value1 key2=value2 ...  
Create a new key or update the value if the key already exists.  
Nothing to print.  

➤GET key1 key2 ...  
Print the corresponding value for each key, or null if it doesn't exist.  

➤EXISTS key1 key2 ...  
Print true or false for each key, depending on whether it exists.  

➤KEYS  
Print all stored keys in the same order they were first set or print EMPTY if no keys are present

Output should be space-separated for GET, EXISTS and KEYS.

# Input
* Line 1: An integer N— the number of instructions.
* Next N lines: Each line contains a single instruction S.

# Output
* Print the result of each command based on the rules above

# Constraints
* 3 < N < 30
* Keys and values in S do not contain spaces or =
