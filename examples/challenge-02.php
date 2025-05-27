<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Challenlink\Challenge02\MinimumWindowSubstringSolver;

// Challenge 02 - Minimum Window Substring Demo
echo "=== Challenge 02: Minimum Window Substring ===\n\n";

$solver = new MinimumWindowSubstringSolver();

$testCases = [
    ["ahffaksfajeeubsne", "jefaa"],
    ["aaffhkksemckelloe", "fhea"],
    ["aaabaaddae", "aed"],
    ["aabdccdbcacd", "aad"],
    ["ADOBECODEBANC", "ABC"],
    ["a", "a"],
    ["a", "aa"], // Edge case: impossible
];

foreach ($testCases as $i => $testCase) {
    echo "Test Case " . ($i + 1) . ":\n";
    echo "Source: \"" . $testCase[0] . "\"\n";
    echo "Target: \"" . $testCase[1] . "\"\n";
    
    try {
        $start = microtime(true);
        $result = $solver->noIterate($testCase);
        $end = microtime(true);
        
        echo "Output: \"" . $result . "\"\n";
        echo "Length: " . strlen($result) . "\n";
        echo "Time: " . number_format(($end - $start) * 1000, 3) . " ms\n";
        
        // Verify result contains all target characters
        if (!empty($result)) {
            $targetChars = array_unique(str_split($testCase[1]));
            $resultChars = array_unique(str_split($result));
            $containsAll = empty(array_diff($targetChars, $resultChars));
            echo "Valid: " . ($containsAll ? "✓" : "✗") . "\n";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

// Performance demonstration with larger strings
echo "=== Performance Test ===\n";
$largeSource = str_repeat("abcdefghijklmnopqrstuvwxyz", 100); // 2600 chars
$target = "xyz";

$start = microtime(true);
$result = $solver->noIterate([$largeSource, $target]);
$end = microtime(true);

echo "Large string (" . strlen($largeSource) . " chars): \"" . $result . "\"\n";
echo "Execution time: " . number_format(($end - $start) * 1000, 2) . " ms\n";
echo "Algorithm complexity: O(n) - Linear time with sliding window\n";
