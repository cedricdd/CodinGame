<?php

// Convert a note (e.g., "C", "F+", "B-") into a semitone value (0–11)
function parseNote($note) {
    // Base semitone values for natural notes
    $base = ['C' => 0, 'D' => 2, 'E' => 4, 'F' => 5, 'G' => 7, 'A' => 9, 'B' => 11];

    $value = $base[$note[0]];

    // Apply accidental:
    // '+' = sharp (+1 semitone)
    // '-' = flat  (-1 semitone)
    if (strlen($note) > 1) {
        if ($note[1] === '+') $value += 1;
        if ($note[1] === '-') $value -= 1;
    }

    // Normalize to range [0, 11]
    return ($value + 12) % 12;
}

// Map note letters to indices for interval calculation
function letterIndex($letter) {
    return ['C' => 0,'D' => 1,'E' => 2,'F' => 3,'G' => 4,'A' => 5,'B' => 6][$letter];
}

// Compute the interval between two notes
function getInterval($from, $to) {

    // Interval names by number
    $intervalNames = [1 => "prime", 2 => "second", 3 => "third", 4 => "fourth", 5 => "fifth", 6 => "sixth", 7 => "seventh", 8 => "octave"];

    // Expected semitone counts for major/perfect intervals
    $expected = [1 => 0, 2 => 2, 3 => 4, 4 => 5, 5 => 7, 6 => 9, 7 => 11, 8 => 12];

    // Intervals that use "perfect" instead of "major/minor"
    $perfectType = [1, 4, 5, 8];

    // Convert notes to semitone values
    $fromVal = parseNote($from);
    $toVal = parseNote($to);

    // Compute semitone distance (always positive, modulo 12)
    $dist = ($toVal - $fromVal + 12) % 12;

    // Compute interval number (1–7 initially)
    $num = (letterIndex($to[0]) - letterIndex($from[0]) + 7) % 7 + 1;

    // Special handling when both notes have the same letter (unison vs octave ambiguity)
    if ($num == 1) {
        if ($dist == 0) {
            // Same pitch → treat as perfect octave (per problem rules)
            $num = 8;
            $dist = 12;
        } 
        elseif ($dist == 1) $num = 1; // Small upward movement → augmented prime
        elseif ($dist == 11) $num = 8; // Small downward movement → diminished octave
    }

    // Expected semitone count for this interval
    $exp = $expected[$num];

    // Difference between actual and expected
    $diff = $dist - $exp;

    // Normalize difference to range [-6, +6]
    // This converts values like 11 → -1, 10 → -2, etc.
    if ($diff > 6) $diff -= 12;
    if ($diff < -6) $diff += 12;

    // Determine interval quality
    if (in_array($num, $perfectType)) {
        // Perfect-type intervals: 1, 4, 5, 8
        if ($diff == 0) $quality = "perfect";
        elseif ($diff == 1) $quality = "augmented";
        elseif ($diff == -1) $quality = "diminished";
    } else {
        // Major-type intervals: 2, 3, 6, 7
        if ($diff == 0) $quality = "major";
        elseif ($diff == -1) $quality = "minor";
        elseif ($diff == 1) $quality = "augmented";
        elseif ($diff == -2) $quality = "diminished";
    }

    // Return final result
    return $quality . " " . $intervalNames[$num];
}

// Number of test cases
fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    // Read two notes
    fscanf(STDIN, "%s %s", $from, $to);

    // Output the computed interval
    echo getInterval($from, $to) . PHP_EOL;
}
