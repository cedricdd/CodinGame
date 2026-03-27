# Puzzle
**Cistercian addition** https://www.codingame.com/contribute/view/144852b400619739005aed6c805568c1060848

# Goal
You simply need to provide the result of an addition between two numbers.

However, these numbers are given in the form of the Cistercian numeral system! (https://en.wikipedia.org/wiki/Cistercian_numerals)  
This system allows you to encode numbers from 1 to 9999 using a single symbol.  

The result of this addition must also be in Cistercian notation.  

Those symbols are used to build the visual representation of Cistercian numbers : space, _, ‾, |, /, \  
Be aware that the ‾ is not an ASCII character, it's an overline (U+203E → https://en.wikipedia.org/wiki/Overline)  

Basic symbols:
```
┌─────┬─────┬─────┬─────┬─────┬─────┬─────┬─────┬─────┐
│   _ │     │     │     │   _ │     │   _ │     │   _ │
│  |  │  |_ │  |\ │  |/ │  |/ │  | |│  | |│  |_|│  |_|│
│  |  │  |  │  |  │  |  │  |  │  |  │  |  │  |  │  |  │
│  |  │  |  │  |  │  |  │  |  │  |  │  |  │  |  │  |  │
│     │     │     │     │     │     │     │     │     │
│  1  │  2  │  3  │  4  │  5  │  6  │  7  │  8  │  9  │
├─────┼─────┼─────┼─────┼─────┼─────┼─────┼─────┼─────┤
│ _   │     │     │     │ _   │     │ _   │     │ _   │
│  |  │ _|  │ /|  │ \|  │ \|  │| |  │| |  │|_|  │|_|  │
│  |  │  |  │  |  │  |  │  |  │  |  │  |  │  |  │  |  │
│  |  │  |  │  |  │  |  │  |  │  |  │  |  │  |  │  |  │
│     │     │     │     │     │     │     │     │     │
│  10 │  20 │  30 │  40 │  50 │  60 │  70 │  80 │  90 │
├─────┼─────┼─────┼─────┼─────┼─────┼─────┼─────┼─────┤
│     │     │     │     │     │     │     │     │     │
│  |  │  |  │  |  │  |  │  |  │  |  │  |  │  |  │  |  │
│  |  │  |_ │  |  │  |  │  |  │  |  │  |  │  |_ │  |_ │
│  |_ │  |  │  |/ │  |\ │  |\ │  | |│  |_|│  | |│  |_|│
│     │     │     │     │   ‾ │     │     │     │     │
│ 100 │ 200 │ 300 │ 400 │ 500 │ 600 │ 700 │ 800 │ 900 │
├─────┼─────┼─────┼─────┼─────┼─────┼─────┼─────┼─────┤
│     │     │     │     │     │     │     │     │     │
│  |  │  |  │  |  │  |  │  |  │  |  │  |  │  |  │  |  │
│  |  │ _|  │  |  │  |  │  |  │  |  │  |  │ _|  │ _|  │
│ _|  │  |  │ \|  │ /|  │ /|  │| |  │|_|  │| |  │|_|  │
│     │     │     │     │ ‾   │     │     │     │     │
│ 1000│ 2000│ 3000│ 4000│ 5000│ 6000│ 7000│ 8000│ 9000│
└─────┴─────┴─────┴─────┴─────┴─────┴─────┴─────┴─────┘
```

Some examples:
```
┌─────┬─────┬─────┬─────┬─────┐
│ _   │     │ _ _ │   _ │     │
│|_|\ │ _|\ │ \|_|│|_|/ │ /|\ │
│  |_ │  |  │  |_ │  |  │ _|  │
│ _|_|│ /|_|│| | |│|_|  │|_|\ │
│     │     │     │     │     │
│ 1993│ 4723│ 6859│ 7085│ 9433│
└─────┴─────┴─────┴─────┴─────┘
```

# Input
* First 5 lines: A loop of 5 strings of 5 characters, visually forming the Cistercian numeral a.
* Next 5 lines: A loop of 5 strings of 5 characters, visually forming the Cistercian numeral b.
* List of different characters that can be found in a line: space, _, ‾, |, /, \

# Output
* 5 lines: The result of the addition between a and b displayed in Cistercian numerals. Each line should contain 5 characters.

# Constraints
* 1 ≤ a, b ≤ 9998
* 2 ≤ a + b ≤ 9999
