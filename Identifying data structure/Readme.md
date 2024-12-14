# Puzzle
**Identifying data structure** https://www.codingame.com/training/medium/identifying-data-structure

# Goal
There is a mysterious data structure. This structure is like a bag which allows putting data in and taking data out.   
But it is a magic bag that sometimes behaves in ways you can hardly imagine.   
You have to guess, as far as possible, what structure it is by looking at its behaviors.  

To keep it simple, we limit our analysis to only three known data structures:  
Queue (First In First Out)  
Stack (First In Last Out)  
Priority Queue (Bigger data come out first)  

We use only two operators to try out the structure:  
* i - input data, similar to [add, put, push, insert, ...], for adding an element to structure.
* o - output data, similar to [pop, poll, pull, delete, ...], which will remove one element from the structure for output.

The data are simple integers.

At the beginning, the data structure is empty. A sequence of i/o operations is then done on the structure.   
Analyze the result then tell what data structure it is.  

# Input
* There are multiple data structures and operation sequences in each test case.
* Line 1: An integer N for the number of operation sequences for your analysis.
* Next N lines: each line represents one data structure and a sequence of operations carried out on it.
    * Operations are space separated.
    * Each operation starts with a character i or o, followed by an integer

For example,
i2 means input 2 into the structure
o2 means asking the structure to output a data, and we got 2 as the output.

Important for your analysis - we got NO ERROR in all the operations, and the structure is empty at the begining of each operation sequence.

# Output
* Output N lines, corresponding to the inputs.
* Each line shall be one of the options in the "answer" column below.
```
┌────────────────┬───────────────────────────────────────────────────┐
│ answer         │ meaning                                           │
├────────────────┼───────────────────────────────────────────────────┤
│ queue          │ it is a Queue                                     │
│ stack          │ it is a Stack                                     │
│ priority queue │ it is a Priority Queue (bigger data has priority) │
│ unsure         │ it can be two or more of the above options        │
│ mystery        │ it belongs to none of the above options           │
└────────────────┴───────────────────────────────────────────────────┘
```

# Constraints
* 1 ≤ N ≤ 100
* 0 ≤ value of data in each operation < 10
* 0 < number of operations in a sequence ≤ 100
