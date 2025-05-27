<?php

declare(strict_types=1);

namespace Challenlink\Challenge03\Strategies;

/**
 * Aged Brie Strategy
 * 
 * Handles "Aged Brie" items that increase in quality over time.
 * Quality increases by 1 before sell date, by 2 after sell date.
 * 
 * @author Richard Braul
 * @version 1.0.0
 */
class AgedBrieStrategy extends AbstractItemStrategy
{
    private const ITEM_NAME = 'Aged Brie';
    
    /**
     * Update Aged Brie according to appreciation rules
     * 
     * @param int $quality Current quality
     * @param int $sellIn Current sellIn
     * @return array{quality: int, sellIn: int} Updated values
     */
    protected function doUpdate(int $quality, int $sellIn): array
    {
        $newSellIn = $sellIn - 1;
        $qualityIncrease = $this->isPastSellDate($newSellIn) ? 2 : 1;
        $newQuality = $quality + $qualityIncrease;
        
        return ['quality' => $newQuality, 'sellIn' => $newSellIn];
    }
    
    /**
     * Check if this strategy handles Aged Brie
     * 
     * @param string $itemName Name of the item
     * @return bool True if item is Aged Brie
     */
    public function canHandle(string $itemName): bool
    {
        return $itemName === self::ITEM_NAME;
    }
}
