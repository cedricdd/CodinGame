# Puzzle
**Codongame** https://www.codingame.com/training/easy/codongame

# Goal
Your goal is to translate a genetic code into sequences of amino acids.

Let's name a triplet of characters in A, U, C, G a codon. Let's also name UAA, UAG and UGA the stop codons, and AUG the start codon.

You will be given n lines, each consisting of a string rna, and a codon_table in the stub comments. The codon_table contains every codon and their corresponding amino acid.

There are three possible translations. The translation process, for each of the three starting indices of rna: 0, 1 or 2, follows these steps:  
1. Start in CLOSED state.
2. If in CLOSED state and the current codon is a start codon, transition to OPENED.
3. If in OPENED state and the current codon is a stop codon, transition to CLOSED and store the current sequence.
4. If in OPENED state, add the current amino acid from codon_table to the back of the current sequence.
5. Move 3 positions forward.
6. Repeat steps 1-4 until the entire rna string is translated.

Note that the sequences are only stored when scanning a stop codon (step 2). That implies that if, for a given index, the translation process terminates in an OPENED state, the current sequence is lost.

For all three starting indices return the translation that yields the most amino acids. If that translation consists of multiple sequences, return them joined by a -.

Example:  
```
CCAUGCCCUAACCCA
  ---  |  |  |    # (AUG) start codon: start (sequence = M).
     ---  |  |    # (CCC) not a stop codon (sequence = MP).
        ---  |    # (UAA) is a stop codon, store sequence.
           ---    # (CCC) not a start codon: ignore.
```

Starting at index 0 or 1 yields no sequences.  
The answer is just one sequence: MP, obtained for index 2.

*NOTES:*  
- The given codon table follows the usual conventions and can be found here: https://en.wikipedia.org/wiki/DNA_and_RNA_codon_tables
- More detailed description: https://en.wikipedia.org/wiki/Translation_(biology)
- The cover picture is from: https://pdb101.rcsb.org/motm/121

# Input
* STUB: The codon_table, with every codon and their corresponding amino acid.
* Line 1: An integer n for the number of strings. Each string is a separate case.
* Next n lines: A string rna of characters in AUCG.

# Output
* n lines: The translated rna strings.

# Constraints
* 0 < n < 20
* 5 < length(rna) < 2048

For each rna string a (non empty) solution exists and is guaranteed to be unique.
