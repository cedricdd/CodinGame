# Puzzle
**Cheat Solving** https://www.codingame.com/training/hard/cheat-solving

# Goal
Can a Rubik's cube be solved by Reassembly™?  
A popular method to solve a Rubik's cube when you don't know any algorithms is to disassemble it and reassemble it directly into a solved state. It doesn't damage the stickers and is guaranteed to always work... provided the stickers haven't been messed with, that is!  
Seung-Hyuk had left his cube solved on the table, but when he came back from his break a few minutes later, he noticed that his cube was now scrambled, and there was an evil grin on Hyo-Min's face. Obviously Hyo-Min had scrambled it, but had he been moving stickers around as well, rendering it unsolvable using the Reassembly™ method? Help Seung-Hyuk by telling him whether or not he can disassemble the pieces and assemble them back together into a solved cube state.  
You are given a cube state in pattern format. A solved cube looks like this:

```
    UUU
    UUU
    UUU

LLL FFF RRR BBB
LLL FFF RRR BBB
LLL FFF RRR BBB

    DDD
    DDD
    DDD
```

Letters ULFRBD mean “this sticker belongs on the Up/‌Left/‌Front/‌Right/‌Back/‌Down face”.  
A cube with an edge flip or a corner twist is obviously solvable using the Reassembly™ method: simply pop the piece out and insert it back with the correct orientation.  
A cube where a corner has two stickers exchanged out of three cannot be solved using the Reassembly™ method: there is no way that corner can be placed where it has more than one sticker on the right face. Similarly, any piece with two stickers of the same color would render the cube unsolvable, as there is no reassembly that would put those two stickers back on the same face.  
A cube where any regular disassembly-free scramble has been applied is obviously solvable using the Reassembly™ method. One is given in example below.  

# Input
* 11 lines (including 2 blank): a cube pattern
  
# Output
* SOLVABLE if it is possible to disassemble the cube and assemble it back in a solved state.
* UNSOLVABLE otherwise.

# Constraints
* Apart from the stickering, all cubes are standard 3×3×3 Rubik's cubes.
* Only valid sticker colors are provided.
* No extra stickers have been used — all cubes here could be solved using the Restickering™ method.

*A cube is made of:*  
* 6 unisticker center pieces
* 12 bisticker edge pieces
* 8 tristicker corner pieces

In this problem's context, you can assume center caps can be exchanged freely.
