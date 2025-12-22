# Puzzle
**Markov Text Generation** https://www.codingame.com/training/easy/markov-text-generation

# Goal
You have made a game, and want the NPCs to talk, even if it is non-sensical.   
Being lazy you don't want to write out all the non-sensical statements so you've decided to create a text generator.   
Fortunately you have a bunch of text to use as training data.  

You will build a classic n-gram Markov chain using sample text.   
Researching online what a Markov chain is, what an n-gram is, and how to apply this to text is part of your quest.  

*EXAMPLE ONE*  
Given the text t= one fish is good and no fish is bad and that is it

And an n-gram depth d=2 we iterate over the text and generate the Markov chain like so:
* Step 1 : 'one fish' => ['is']
* Step 2 : 'fish is' => ['good']
* Step 3 : 'is good' => ['and']
* Step 4 : 'good and' => ['no']
* Step 5 : 'and no' => ['fish']
* Step 6 : 'no fish' => ['is']
* We saw  'fish is' in step 2, so in step 7 we append the new value
* Step 7 : 'fish is' => ['good','bad']
* Step 8 : 'is bad => ['and']
* and so on until all the text is processed and added to the lookup

We now can generate text. For a phrase of output length l=5 starting with the seed text s= fish is

We may generate one of the two follow phrases randomly:
* fish is good and no
* fish is bad and that

Because when 'fish is' looked up, we choose either 'good' or 'bad' randomly. All the rest of the text is deterministic.

*REPRODUCIBILITY*  
For random selection you will use the following pseudo code for 'randomly' picking from options for the next state even if there only exists 1 options.
```
--------------------------------------------------------
random_seed = 0
function pick_option_index( num_of_options ) {
    random_seed += 7
    return random_seed % num_of_options
}
--------------------------------------------------------
```

In the above example, the first lookup returns ['good','bad']. There are 2 options.  
Call pick_option_index(2) which will return 7%2 = 1.   
Therefor we append 'bad' to our output sentence and continue from there calling pick_option_index for every lookup even if there is only 1 option.  

# Input
* Line 1: The text which contains only the letters from a-z and spaces.
* Line 2: n-gram depth , an integer value from 1 to 10
* Line 3: The desired output length , an integer value from 1 to 100
* Line 4: The seed text

# Output
* Line 1: The text starting with the seed text and in total will have length words separated by spaces

# Constraints
* text length in characters ≤ 1000
* 1 ≤ depth ≤ 10
* depth ≤ length ≤ 100
* seed length in characters ≤ 1000
