<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Challenlink\Challenge01\ArrayIntersectionSolver;

// Challenge 01 - Array Intersection Demo
echo "=== Challenge 01: Array Intersection ===\n\n";

$solver = new ArrayIntersectionSolver();

$testCases = [
    ['1, 3, 4, 7, 13', '1, 2, 4, 13, 15'],
    ['1, 3, 9, 10, 17, 18', '1, 4, 9, 10'],
    ['5, 7, 9', '1, 2, 3'],
    ['1, 2, 3', '1, 2, 3'],
    ['10, 20, 30', '15, 25, 35'],
];

foreach ($testCases as $i => $testCase) {
    echo "Test Case " . ($i + 1) . ":\n";
    echo "Input: [\"" . implode('", "', $testCase) . "\"]\n";
    
    try {
        $result = $solver->findPoint($testCase);
        echo "Output: " . $result . "\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

// Performance demonstration
echo "=== Performance Test ===\n";
$largeArray1 = implode(', ', range(1, 1000, 2)); // Odd numbers 1-999
$largeArray2 = implode(', ', range(2, 1000, 2)); // Even numbers 2-1000

$start = microtime(true);
$result = $solver->findPoint([$largeArray1, $largeArray2]);
$end = microtime(true);

echo "Large arrays (500 elements each): " . ($result === 'false' ? 'No intersection' : 'Found intersection') . "\n";
echo "Execution time: " . number_format(($end - $start) * 1000, 2) . " ms\n";
echo "Algorithm complexity: O(n + m) - Linear time\n";
