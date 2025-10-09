# Puzzle
**Turing machine** https://www.codingame.com/training/hard/turing-machine

# Goal
A Turing machine is an abstract machine that manipulates symbols on a strip of tape according to a table of rules.  
It was invented by Alan Turing in 1936, and, despite its simplicity, can simulate any computer algorithm.  
A Turing machine consists of the following elements:
1. A tape divided into cells, one next to the other. Each cell contains a symbol from some finite alphabet. 
In the mathematical model, the tape is infinitely long, but we will restrict it to some fixed size. The symbols are represented by integers.
2. A head that can read and write symbols on the tape and move left and right one cell at a time.
3. A state register that stores the state of the Turing machine, one of finitely many. One of these states is the special start state with which the state register is initialized.
4. A finite table of instructions that, given the state the machine is currently in and the symbol it is reading on the tape, 
tells the machine to do the following in sequence:
   - Either erase or write a symbol, then
   - Move the head left or right, and then
   - Go to a specified state

The alphabet consists of S symbols: 0, 1, ... , S-1. The tape is initially filled with 0s.  
The tape has T cells. Its initial position is X, with 0 being the left edge.  
There are N states. Each state has S actions, one for each symbol. An action is represented by:  
W M NEXT
where W is the symbol the machine will write, M is the direction the head will move (L and R for left and right, respectively), and NEXT is the state the machine will go to. NEXT can be HALT, in which case the machine will stop the simulation upon performing this action.  
The action the machine will perform depends on the symbol it is currently reading. For example, if the current symbol is 0, it will perform the first action associated with the current state, if it's 1 - the second action, etc.  
The machine will start in the state START (provided in the input).  
Your task is to simulate the machine until it halts or goes out of bounds of the tape, and output the number of actions it has performed, the position of the head after the last move (or -1 if it went out of bounds to the left, T (the number of cells on the tape, not letter 'T') if to the right), as well as the contents of the tape after the simulation.  

# Input
* Line 1: S T X - space separated integers - number of symbols, tape length, and the initial position of the head.
* Line 2: START - the initial state the machine is in.
* Line 3: N - number of states.
* Next N lines: STATE: ACTIONS - the name of the state and S actions separated by semicolon. 
* An action has the format W M NEXT - symbol to write, direction to move, and state to go to.

# Output
* Line 1: The number of actions the machine has performed before halting.
* Line 2: The position of the head after the last move.
* Line 3: T characters representing the tape after the simulation.

# Constraints
* S ≤ 5
* 0 ≤ X < T ≤ 500
* N ≤ 100
