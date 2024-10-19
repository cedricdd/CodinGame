# Puzzle
**Artificial Emotional Intelligence** https://www.codingame.com/training/easy/artificial-emotional-intelligence

# Goal
You've been tasked to build an A.I. machine that can sense the essence and future of its human-partner/user. But that seems way too hard. What to do?

Then you remember that people are all pretty much the same, so using generic adjectives and destinies will perfectly fit most people most of the time.  
So you create 3 lists, shown below:  
* adjList = 20 Adjectives to generically describe a person
* goodList = 6 phrases for common Good things that happen to a person
* badList = 6 phrases for common Bad things that happen to a person

There are 6 vowels (a,e,i,o,u,y) and 20 consonants in the alphabet.  
You decide you will use the first 3 unique consonants and the first 2 vowels in a person's name to create a customized Greeting to that person.

Here is an example for someone named "Missy Marie":  
The first 3 unique consonants are: M, S, and R  
"M" is the 10th consonant in the alphabet, "S" is the 15th, and "R" is the 14th.  
The first 2 vowels are: I and Y  
"I" is the 3rd vowel in the alphabet, and "Y" is the 6th.  

So your mock-A.I. greets her like this:  
It's so nice to meet you, my dear [10th word in adjList] name.  
I sense you are both [15th word in adjList] and [14th word in adjList].  
May our future together have much more [3rd phrase in goodList] than [6th phrase in badList].  

... which becomes ...

It's so nice to meet you, my dear gregarious Missy Marie.  
I sense you are both non-judgmental and honest.  
May our future together have much more friendship than investment loss.  

If a name doesn't have the letters required for this (like "John" or "Paw Paw") then output this basic greeting: "Hello name." (for example "Hello John.")

About the name:  
~Names often have spaces, hyphens, periods (and sometimes symbols and numbers) in them: Ignore all those. We only care about letters.  
~It's fine if both of the first two vowels are the same, for example: if both are "A", as in "Lamar"  

adjList = "Adaptable Adventurous Affectionate Courageous Creative Dependable Determined Diplomatic Giving Gregarious Hardworking Helpful Hilarious Honest Non-judgmental Observant Passionate Sensible Sensitive Sincere"  
goodList = "Love, Forgiveness, Friendship, Inspiration, Epic Transformations, Wins"  
badList = "Crime, Disappointment, Disasters, Illness, Injury, Investment Loss"  

# Input
* Name

# Output
* The customized Greeting that is either 1-line or 3-lines long.
* If it's the 3-line greeting, make sure it reads as normal sentences (adjust capitalization and spacing as needed).

# Constraints
* Name can be upper or lower case or any combination thereof.
* Name can contain letters, numbers, and symbols.
* Name is at least 1 character long.
