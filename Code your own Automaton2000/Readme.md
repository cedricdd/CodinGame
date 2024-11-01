# Puzzle
**Code your own Automaton2000** https://www.codingame.com/training/hard/code-your-own-automaton2000-step-1

# Goal
Do you know Automaton2000? You don't? Okay, so, let's join the chat. Look at the right of the website and join the general channel.  
If you are level 3, just say "Hi Automaton2000" and the bot Automaton2000 will answer you.

The behavior of Automaton2000 is pretty simple. It learns from what it reads on the channel.  
It is always here, listening. When you poke him by writing its name, it will build a sentence using what it has read on the channel.

Your goal here is to code your own Automaton2000 !  
Important note: The real Automaton2000 has a random behavior because there's no fun at all in a bot repeating the same sentence again and again.  
But for this puzzle, there's will be no random at all in the expected output. 

Automaton2000 captures all the words in every sentence in the chat and builds a tree with the words.   
To build a new sentence, it browses the tree, concatenating the words one by one until the end of the sentence (represented by an __END__ node in the tree).

For instance, take the following chat log:
```
(21:52:18) Magus: Hey MadKnight
(21:53:05) MadKnight: Hey Magus. How is your CSB?
```
Automaton2000 will first ignore the part (21:52:18) Magus:. The rest is split on the space character.  
Then the words are used to build the tree. With the given example, Automaton2000 will build the following tree:
```
__START__
    Hey 2

Hey
    MadKnight 1
    Magus. 1

MadKnight
    __END__ 1

Magus.
    How 1

How
    is 1

is
    your 1

your
    CSB? 1

CSB?
    __END__ 1
```

__START__ is a special node representing the start of a sentence.  
__END__ is a special node representing the end of a sentence.

Your program will receive a chat log in input. It should try to build the same tree as Automaton2000.  
Each time you read the word Automaton2000 at least one time in a sentence, you have to print a sentence.  
Your program must output the most likely sentence possible according to the tree. You have to browse your tree, selecting the most powerful word each time.  

Don't forget that you must output the sentence using the tree in its current state after the string Automaton2000 appears.  
So you should first read the sentence, update your tree, and then print a phrase when you have to.

With the given example, your program should print Hey MadKnight

Don't forget these specific points:  
* Automaton2000 ignores the word Automaton2000. But Automaton2000_ is a valid word, for example.
* Automaton2000 does not read its own sentences.
* Automaton2000 ignores empty sentences.
* If you must choose between multiple words with the same weight, choose according to the alphabetical order (case sensitive, uppercase first).
* Automaton2000 has a security and stops at 30 words at maximum. You don't want to do an infinite loop !
* Symbols like , and . are read as letters.

# Input
* Line 1: An integer n.
* Next n lines: A chat line like

# Output
* X lines One line each time a chat line contains the string Automaton2000

# Constraints
* 1 ≤ n ≤ 100
