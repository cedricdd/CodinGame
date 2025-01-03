# Puzzle
**May the Triforce be with you!** https://www.codingame.com/training/easy/may-the-triforce-be-with-you

# Goal
Link has been sent to the Secret Realm to find the Triforce and save Hyrule.  
But the vile Ganondorf followed Link into the Temple of Time, trapped him, and took the Triforce for himself.  

The Temple of Time has been closed for a thousand years now, but the Sages finally found you, one of the greatest Nerds ever born, and they need your help to open the Temple of Time's door and join Link in the ultimate battle!

The Temple of Time's surface contains several incrusted Triforces of different sizes, and the Sages believe that by creating Triforces of the corresponding sizes, the door will open. 
Even though no magic has worked until now, your programming skills will surely make the difference.


You must create a program that echoes a Triforce of a given size N.
- A triforce is made of 3 identical triangles
- A triangle of size N should be made of N lines
- A triangle's line starts from 1 star, and earns 2 stars each line
- Take care, a . must be located at the top/left to avoid automatic trimming

For example, a Triforce of size 3 will look like:
```
.    *
    ***
   *****
  *     *
 ***   ***
***** *****
```

Another example, a Triforce of size 5 will look like:
```

.        *
        ***
       *****
      *******
     *********
    *         *
   ***       ***
  *****     *****
 *******   *******
********* *********
```

Don't forget: you're Hyrule's only hope!  
Good luck!

# Input
* Line 1: An Integer N is the size of one triangle of the expected triforce.

# Output
* 2xN lines: The expected Triforce

# Constraints
* 1 ≤ N ≤ 100
