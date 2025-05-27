<?php

declare(strict_types=1);

namespace Challenlink\Challenge03\Strategies;

use Challenlink\Challenge03\Contracts\ItemUpdateStrategyInterface;

/**
 * Abstract Base Strategy
 * 
 * Provides common functionality and quality constraints for all item strategies.
 * Implements Template Method pattern for consistent quality boundary enforcement.
 * 
 * @author Richard Braul
 * @version 1.0.0
 */
abstract class AbstractItemStrategy implements ItemUpdateStrategyInterface
{
    protected const MIN_QUALITY = 0;
    protected const MAX_QUALITY = 50;
    
    /**
     * Template method that enforces quality constraints
     * 
     * @param int $quality Current quality
     * @param int $sellIn Current sellIn
     * @return array{quality: int, sellIn: int} Updated values with enforced constraints
     */
    final public function updateItem(int $quality, int $sellIn): array
    {
        $result = $this->doUpdate($quality, $sellIn);
        
        // Enforce quality constraints
        $result['quality'] = $this->constrainQuality($result['quality']);
        
        return $result;
    }
    
    /**
     * Perform item-specific update logic (to be implemented by concrete strategies)
     * 
     * @param int $quality Current quality
     * @param int $sellIn Current sellIn
     * @return array{quality: int, sellIn: int} Updated values before constraint enforcement
     */
    abstract protected function doUpdate(int $quality, int $sellIn): array;
    
    /**
     * Enforce quality boundaries
     * 
     * @param int $quality Quality value to constrain
     * @return int Quality value within valid bounds
     */
    protected function constrainQuality(int $quality): int
    {
        return max(self::MIN_QUALITY, min(self::MAX_QUALITY, $quality));
    }
    
    /**
     * Check if item has passed its sell date
     * 
     * @param int $sellIn Current sellIn value
     * @return bool True if item is past sell date
     */
    protected function isPastSellDate(int $sellIn): bool
    {
        return $sellIn < 0;
    }
}
