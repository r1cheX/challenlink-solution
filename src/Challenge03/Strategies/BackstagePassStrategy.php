<?php

declare(strict_types=1);

namespace Challenlink\Challenge03\Strategies;

/**
 * Backstage Passes Strategy
 * 
 * Handles "Backstage passes to a TAFKAL80ETC concert" with complex appreciation rules.
 * Quality increases more rapidly as the concert approaches, then drops to 0 after.
 * 
 * @author Richard Braul
 * @version 1.0.0
 */
class BackstagePassStrategy extends AbstractItemStrategy
{
    private const ITEM_NAME = 'Backstage passes to a TAFKAL80ETC concert';
    private const MODERATE_URGENCY_DAYS = 10;
    private const HIGH_URGENCY_DAYS = 5;
    
    /**
     * Update Backstage Pass with concert proximity rules
     * 
     * @param int $quality Current quality
     * @param int $sellIn Current sellIn
     * @return array{quality: int, sellIn: int} Updated values
     */
    protected function doUpdate(int $quality, int $sellIn): array
    {
        $newSellIn = $sellIn - 1;
        
        // After concert (sellIn < 0), quality drops to 0
        if ($this->isPastSellDate($newSellIn)) {
            return ['quality' => 0, 'sellIn' => $newSellIn];
        }
        
        // Calculate quality increase based on proximity to concert
        $qualityIncrease = $this->calculateQualityIncrease($newSellIn);
        $newQuality = $quality + $qualityIncrease;
        
        return ['quality' => $newQuality, 'sellIn' => $newSellIn];
    }
    
    /**
     * Calculate quality increase based on days until concert
     * 
     * @param int $sellIn Days remaining until concert
     * @return int Quality increase amount
     */
    private function calculateQualityIncrease(int $sellIn): int
    {
        if ($sellIn <= self::HIGH_URGENCY_DAYS) {
            return 3; // Very close to concert: +3
        }
        
        if ($sellIn <= self::MODERATE_URGENCY_DAYS) {
            return 2; // Moderately close: +2
        }
        
        return 1; // Far from concert: +1
    }
    
    /**
     * Check if this strategy handles Backstage Passes
     * 
     * @param string $itemName Name of the item
     * @return bool True if item is Backstage Pass
     */
    public function canHandle(string $itemName): bool
    {
        return $itemName === self::ITEM_NAME;
    }
}
