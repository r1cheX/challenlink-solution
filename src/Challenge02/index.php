<?php

declare(strict_types=1);

namespace Challenlink\Challenge02;

/**
 * Legacy function wrapper for backward compatibility
 * 
 * This function provides the exact interface expected by the challenge
 * while leveraging the optimized MinimumWindowSubstringSolver class.
 * 
 * @param array<string> $strArr Array with 2 elements: [source_string, target_chars]
 * @return string Minimum window substring
 */
function noIterate(array $strArr): string
{
    static $solver = null;
    
    if ($solver === null) {
        $solver = new MinimumWindowSubstringSolver();
    }
    
    return $solver->noIterate($strArr);
}

// Auto-execute if called directly (for backward compatibility)
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'] ?? '')) {
    echo noIterate(["ahffaksfajeeubsne", "jefaa"]);
}
