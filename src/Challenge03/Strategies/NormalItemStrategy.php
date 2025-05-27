<?php

declare(strict_types=1);

namespace Challenlink\Challenge03\Strategies;

/**
 * Normal Item Strategy
 * 
 * Handles standard items that degrade in quality over time.
 * Quality decreases by 1 before sell date, by 2 after sell date.
 * 
 * @author Richard Braul
 * @version 1.0.0
 */
class NormalItemStrategy extends AbstractItemStrategy
{
    /**
     * Update normal item according to standard degradation rules
     * 
     * @param int $quality Current quality
     * @param int $sellIn Current sellIn
     * @return array{quality: int, sellIn: int} Updated values
     */
    protected function doUpdate(int $quality, int $sellIn): array
    {
        $newSellIn = $sellIn - 1;
        $qualityDecrease = $this->isPastSellDate($newSellIn) ? 2 : 1;
        $newQuality = $quality - $qualityDecrease;
        
        return ['quality' => $newQuality, 'sellIn' => $newSellIn];
    }
    
    /**
     * Check if this strategy can handle the given item
     * 
     * @param string $itemName Name of the item
     * @return bool True for normal items (default fallback)
     */
    public function canHandle(string $itemName): bool
    {
        // This is the default strategy for items not handled by specific strategies
        return true;
    }
}
