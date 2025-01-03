# Puzzle
**Guessing n Cheating** https://www.codingame.com/training/medium/guessing-n-cheating

# Goal
Alice and Bob are playing a guessing game. Alice thinks of a number between 1 and 100 (both inclusive).  
Bob guesses what it is. Alice then replies "too high", "too low" or "right on".  
After repeated rounds of guessing and replying, Bob should be able to hit right on the number. 

After some games, Bob suspects Alice is cheating - that she changed the number in the middle of the game, or just gave a false response.   
To collect evidence against Alice, Bob recorded the transcripts of several games. You are invited to help Bob to determine whether Alice cheated in each game.

An example game between Bob and Alice:

A game of 3 rounds
```
┌───┬──────────┐
│ B │    A     │
├───┼──────────┤
│ 5 │ too high │
│ 1 │ too high │<-- round 2
│ 2 │ right on │
└───┴──────────┘
```

Alice cheated in round 2

(...because numbers below 1 are not allowed in the game)

# Input
* Line 1 An integer R for the number of rounds in the transcript
* Next R lines: Each line is a conversation between Bob and Alice, to form one round in the game.

The conversation lines format is given by this example:  
50 too low  
=> Bob says "50", followed by Alice saying "too low".  

# Output
* If there is no evidence showing Alice was dishonest, write No evidence of cheating.
* As soon as you can prove Alice was cheating, write Alice cheated in round X where X is the first round number indicating Alice did cheat.
* Round number counts from 1, to 2, to 3, and so on.

# Constraints
* R ≤ 50
