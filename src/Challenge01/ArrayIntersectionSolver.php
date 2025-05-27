<?php

declare(strict_types=1);

namespace Challenlink\Challenge01;

/**
 * Array Intersection Solver
 * 
 * Efficiently finds the intersection of two sorted comma-separated number arrays
 * using the two-pointer technique for optimal O(n + m) performance.
 * 
 * This class demonstrates:
 * - Functional programming principles with pure functions
 * - Efficient algorithm implementation
 * - Proper error handling and validation
 * - Clean, readable code structure
 * 
 * @author Richard Braul
 * @version 1.0.0
 */
class ArrayIntersectionSolver
{
    /**
     * Find intersection of two sorted comma-separated number arrays
     * 
     * Algorithm: Two-pointer technique
     * Time Complexity: O(n + m) where n, m are array lengths
     * Space Complexity: O(min(n, m)) for the result array
     * 
     * @param array<string> $strArr Array containing exactly 2 comma-separated number strings
     * @return string Comma-separated intersection numbers or "false" if no intersection
     * 
     * @throws \InvalidArgumentException If input format is invalid
     */
    public function findPoint(array $strArr): string
    {
        $this->validateInput($strArr);
        
        $array1 = $this->parseNumberString($strArr[0]);
        $array2 = $this->parseNumberString($strArr[1]);
        
        $intersection = $this->findIntersectionOptimized($array1, $array2);
        
        return empty($intersection) ? 'false' : implode(',', $intersection);
    }
    
    /**
     * Find intersection using two-pointer technique (optimized for sorted arrays)
     * 
     * @param array<int> $arr1 First sorted array
     * @param array<int> $arr2 Second sorted array
     * @return array<int> Intersection array in sorted order
     */
    private function findIntersectionOptimized(array $arr1, array $arr2): array
    {
        $result = [];
        $i = $j = 0;
        $len1 = count($arr1);
        $len2 = count($arr2);
        
        // Two-pointer technique for sorted arrays
        while ($i < $len1 && $j < $len2) {
            if ($arr1[$i] === $arr2[$j]) {
                // Found intersection - avoid duplicates
                if (empty($result) || end($result) !== $arr1[$i]) {
                    $result[] = $arr1[$i];
                }
                $i++;
                $j++;
            } elseif ($arr1[$i] < $arr2[$j]) {
                $i++;
            } else {
                $j++;
            }
        }
        
        return $result;
    }
    
    /**
     * Parse comma-separated number string into sorted integer array
     * 
     * @param string $str Comma-separated number string
     * @return array<int> Sorted array of integers
     */
    private function parseNumberString(string $str): array
    {
        $numbers = array_map(
            fn(string $num): int => (int) trim($num),
            explode(',', $str)
        );
        
        // Ensure array is sorted (as per problem requirements)
        sort($numbers, SORT_NUMERIC);
        
        return $numbers;
    }
    
    /**
     * Validate input format
     * 
     * @param array<string> $strArr Input array to validate
     * @throws \InvalidArgumentException If validation fails
     */
    private function validateInput(array $strArr): void
    {
        if (count($strArr) !== 2) {
            throw new \InvalidArgumentException(
                'Input must contain exactly 2 elements, got ' . count($strArr)
            );
        }
        
        foreach ($strArr as $index => $str) {
            if (!is_string($str) || empty(trim($str))) {
                throw new \InvalidArgumentException(
                    "Element at index {$index} must be a non-empty string"
                );
            }
        }
    }
}
