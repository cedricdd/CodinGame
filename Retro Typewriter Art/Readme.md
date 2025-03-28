# Puzzle
**Retro Typewriter Art** https://www.codingame.com/training/easy/retro-typewriter-art

# Goal
Back in the day, people had fun turning "recipes" into surprise images using typewriters.

Use the provided recipe to create a recognizable image.

Chunks in the recipe are separated by a space.  
Each chunk will tell you either  
nl meaning NewLine (aka Carriage Return)  
~or~  
how many of the character and what character  

For example:  
4z means ```zzzz```  
1{ means ```{```  
10= means ```==========```  
5bS means ```\\\\\``` (see Abbreviations list below)  
27 means ```77```  
123 means ```333333333333```
(If a chunk is composed only of numbers, the character is the last digit.)  

So if part of the recipe is  
2* 15sp 1x 4sQ nl  
...that tells you to show  
```
**               x''''

```

Abbreviations used:  
* sp = space ``` ```
* bS = backSlash ```\```
* sQ = singleQuote ```'```
* nl = NewLine

# Input
* string recipe

# Output
* string (multiple lines) to show the image the recipe creates

# Constraints
* 5 ≤ Length of recipe ≤ 1000
* There won't be any double quotes (") in the recipe
* recipe will contain at least 1 nl
