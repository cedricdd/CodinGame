# Puzzle
**Musical Intervals** https://www.codingame.com/training/hard/musical-intervals

# Goal
A musical interval is a measure of the distance between two notes' pitches. You are given pitch pairs and asked to describe the musical interval between them.

Note: This puzzle describes tuning-independent interval identification. If you know another recipe, it's perfectly valid too, and you can safely skip to the I/O format description.

In western musical formalism, an interval is a combination of a type and a quality.

The type describes the distance between the two unaltered pitches that compose it, ranging from the prime between two notes of the same pitch, to the second, third, fourth, fifth, sixth, seventh, and octave between two same-named notes a full scale apart.

Qualities are, in increasing order of span: diminished, minor, perfect, major and augmented.  
Second, third, sixth and seventh intervals can be any quality but perfect. Primes, fourths, fifths and octaves can be any quality but major and minor.

Using English names, the unaltered pitches are A, B, C, D, E, F and G. The distance between B and C is a semitone; the distance between E and F is a semitone; all other consecutive pitches are a tone apart, including from G up to A.
Natural intervals from A to:
* B: major second
* C: minor third
* D: perfect fourth
* E: perfect fifth
* F: minor sixth
* G: minor seventh
* next A: perfect octave

Here's one way to find an interval's quality:
* Take the reference interval of the same type from the list above
* Shift it step by step until the pitches match.
  * shifting both pitches over a tone or semitone doesn't change the quality.
  * shifting pitches one over a tone and the other over a semitone expands or shrinks the quality to the next available one for that type.
* Sharps and flats, when present, also expand or reduce the quality to the next. Sharp (traditional notation ♯ represented as a + in the inputs) raises a pitch, and flat (traditionally ♭, here -) lowers it.

Identifying the interval from C to E: the pitches are two steps apart (CDE), so the interval is a third. What's its quality? The provided reference third, A to C, is minor. Shifting it one step up makes it B to D; the A to B step is a tone, C to D is a tone too; so the interval quality doesn't change and is still minor. Shifting one more step reaches the goal C to E; the B to C step is a semitone, D to E a tone; so we're raising the bottom pitch less than the upper one, and the interval expands to the next available quality: major. So C to E is a major third.

What's the interval between B♭ and F♯? They're four steps apart, so it's a fifth. The reference fifth, A to E, is perfect. Shifting up once raises the bottom pitch by a tone and the top one a semitone, so B to F is a diminished fifth. Lowering B to B♭ expands that to a perfect fifth, and raising the F to F♯ expands that to an augmented fifth.

# Input
* Line 1: the number N of intervals
* Next N lines: two space-separated pitches from and to
* A pitch is a letter from A to G, optionally followed by a + for sharp or a - for flat.

# Output
* N lines: a fully-qualified interval

# Constraints
* from and to describe the smallest strictly rising interval between the two pitches. There are no edge cases.
* No other interval types and qualities than those mentioned in the statement are needed.
* Semitones are assumed to be smaller than tones. No other assumption is needed on the tuning system used, or on sharps', flats', tones' and semitones' relative extents.
