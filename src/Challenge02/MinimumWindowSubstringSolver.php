<?php

declare(strict_types=1);

namespace Challenlink\Challenge02;

/**
 * Minimum Window Substring Solver
 * 
 * Efficiently finds the smallest substring containing all target characters
 * using the sliding window technique for optimal O(n) performance.
 * 
 * This class demonstrates:
 * - Advanced string processing algorithms
 * - Sliding window technique mastery
 * - Optimal time and space complexity
 * - Robust edge case handling
 * 
 * @author Richard Braul
 * @version 1.0.0
 */
class MinimumWindowSubstringSolver
{
    /**
     * Find the smallest substring of N that contains all characters in K
     * 
     * Algorithm: Sliding Window with character frequency tracking
     * Time Complexity: O(n) where n is the length of the source string
     * Space Complexity: O(k) where k is the number of unique characters in target
     * 
     * @param array<string> $strArr Array with 2 elements: [source_string, target_chars]
     * @return string Smallest substring containing all target characters
     * 
     * @throws \InvalidArgumentException If input format is invalid
     */
    public function noIterate(array $strArr): string
    {
        $this->validateInput($strArr);
        
        $source = $strArr[0];
        $target = $strArr[1];
        
        return $this->findMinimumWindowSubstring($source, $target);
    }
    
    /**
     * Find minimum window substring using optimized sliding window technique
     * 
     * @param string $source Source string to search in
     * @param string $target Target characters that must be included
     * @return string Minimum window substring
     */
    private function findMinimumWindowSubstring(string $source, string $target): string
    {
        if (empty($source) || empty($target)) {
            return '';
        }
        
        // Build target character frequency map
        $targetFreq = $this->buildCharacterFrequencyMap($target);
        $requiredChars = count($targetFreq);
        
        // Sliding window variables
        $left = $right = 0;
        $formedChars = 0;
        $windowCounts = [];
        
        // Result tracking
        $minLength = PHP_INT_MAX;
        $minStart = 0;
        
        $sourceLength = strlen($source);
        
        while ($right < $sourceLength) {
            // Expand window by including character at right pointer
            $rightChar = $source[$right];
            $windowCounts[$rightChar] = ($windowCounts[$rightChar] ?? 0) + 1;
            
            // Check if current character frequency matches target requirement
            if (isset($targetFreq[$rightChar]) && 
                $windowCounts[$rightChar] === $targetFreq[$rightChar]) {
                $formedChars++;
            }
            
            // Contract window from left while it's valid
            while ($left <= $right && $formedChars === $requiredChars) {
                $leftChar = $source[$left];
                
                // Update minimum window if current is smaller
                $currentLength = $right - $left + 1;
                if ($currentLength < $minLength) {
                    $minLength = $currentLength;
                    $minStart = $left;
                }
                
                // Remove leftmost character from window
                $windowCounts[$leftChar]--;
                if (isset($targetFreq[$leftChar]) && 
                    $windowCounts[$leftChar] < $targetFreq[$leftChar]) {
                    $formedChars--;
                }
                
                $left++;
            }
            
            $right++;
        }
        
        return $minLength === PHP_INT_MAX ? '' : substr($source, $minStart, $minLength);
    }
    
    /**
     * Build character frequency map for target string
     * 
     * @param string $str Input string
     * @return array<string, int> Character frequency map
     */
    private function buildCharacterFrequencyMap(string $str): array
    {
        $freq = [];
        $length = strlen($str);
        
        for ($i = 0; $i < $length; $i++) {
            $char = $str[$i];
            $freq[$char] = ($freq[$char] ?? 0) + 1;
        }
        
        return $freq;
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
            if (!is_string($str)) {
                throw new \InvalidArgumentException(
                    "Element at index {$index} must be a string"
                );
            }
        }
        
        if (empty($strArr[0])) {
            throw new \InvalidArgumentException('Source string cannot be empty');
        }
        
        if (empty($strArr[1])) {
            throw new \InvalidArgumentException('Target string cannot be empty');
        }
    }
}
