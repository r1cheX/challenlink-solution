<?php

declare(strict_types=1);

namespace Challenlink\Challenge01;

/**
 * Legacy function wrapper for backward compatibility
 * 
 * This function provides the exact interface expected by the challenge
 * while leveraging the optimized ArrayIntersectionSolver class.
 * 
 * @param array<string> $strArr Array containing 2 comma-separated number strings
 * @return string Comma-separated intersection or "false"
 */
function findPoint(array $strArr): string
{
    static $solver = null;
    
    if ($solver === null) {
        $solver = new ArrayIntersectionSolver();
    }
    
    return $solver->findPoint($strArr);
}

// Auto-execute if called directly (for backward compatibility)
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'] ?? '')) {
    echo findPoint(['1, 3, 4, 7, 13', '1, 2, 4, 13, 15']);
}
