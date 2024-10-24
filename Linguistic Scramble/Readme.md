# Puzzle
**Linguistic Scramble** https://www.codingame.com/contribute/view/10927847b0d993b9733416113429dd01e93726

# Goal
A quotation from a classic literary work has been translated into a dozen different European languages. However, the translations have all been shuffled in some arbitrary order. With the original mixed in, that's 13 languages altogether. What bad luck!

Given an excerpt in every one of these 13 languages, determine the order they're in by matching a unique language to each.

As a rule in this puzzle, English will use the 26 letters without diacritics as in résumé and naïve, nor ligatures as in Cæsar and amœba. Alphabets for other languages have further restrictions strictly adhered to, and other possibilities for alphabetic characters as detailed below:

```
Language  Exclusions   Inclusions
━━━━━━━━  ━━━━━━━━━━━  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Danish         q    z   ø  æ  å
Estonian   cf  q wxy     šž  õ            ä  öü
Finnish   b f  q wx                       ä  ö
French                 ç   œ    é    àè  ù ëï ü âêîôû
German                  ß                 ä  öü
Irish        jkqvwxyz          áéíóú
Italian       k  wxy            é    àèìòù
Portuguese    k  w     ç    ãõ áéíóú à          âê ô
Spanish       k  w      ñ      áéíóú          ü
Swedish        q w            å           ä  ö
Turkish        q wx    çğş İı                öü
Welsh        jkqv x z    ŵŷ                     âêîôû
```

While this information is sufficient to solve the puzzle, it should be noted that language in general is highly patterned, so there are other approaches that can be used to discriminate the texts. For instance, the stop words they, who and only are exclusively found in English, and others are highly correlated. This and alternative ideas can similarly lead to valid solutions.

# Input
* Lines 1 to 13: A string excerpt in UTF-8 encoding

# Output
* Lines 1 to 13: Danish, English, Estonian, Finnish, French, German, Irish, Italian, Portuguese, Spanish, Swedish, Turkish, or Welsh

# Constraints
* Length of excerpt is less than 500 bytes. Each of 13 is in a unique language.
