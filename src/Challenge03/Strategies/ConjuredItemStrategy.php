<?php

declare(strict_types=1);

namespace Challenlink\Challenge03\Strategies;

/**
 * Conjured Item Strategy
 * 
 * Handles "Conjured" items that degrade twice as fast as normal items.
 * Quality decreases by 2 before sell date, by 4 after sell date.
 * 
 * @author Richard Braul
 * @version 1.0.0
 */
class ConjuredItemStrategy extends AbstractItemStrategy
{
    /**
     * Update Conjured item with accelerated degradation
     * 
     * @param int $quality Current quality
     * @param int $sellIn Current sellIn
     * @return array{quality: int, sellIn: int} Updated values
     */
    protected function doUpdate(int $quality, int $sellIn): array
    {
        $newSellIn = $sellIn - 1;
        $qualityDecrease = $this->isPastSellDate($newSellIn) ? 4 : 2;
        $newQuality = $quality - $qualityDecrease;
        
        return ['quality' => $newQuality, 'sellIn' => $newSellIn];
    }
    
    /**
     * Check if this strategy handles Conjured items
     * 
     * @param string $itemName Name of the item
     * @return bool True if item name contains "Conjured"
     */
    public function canHandle(string $itemName): bool
    {
        return stripos($itemName, 'Conjured') !== false;
    }
}
