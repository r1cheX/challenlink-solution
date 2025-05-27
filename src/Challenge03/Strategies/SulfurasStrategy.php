<?php

declare(strict_types=1);

namespace Challenlink\Challenge03\Strategies;

/**
 * Sulfuras Strategy
 * 
 * Handles "Sulfuras, Hand of Ragnaros" - legendary items that never change.
 * Quality and sellIn remain constant as these are legendary artifacts.
 * 
 * @author Richard Braul
 * @version 1.0.0
 */
class SulfurasStrategy extends AbstractItemStrategy
{
    private const ITEM_NAME = 'Sulfuras, Hand of Ragnaros';
    private const LEGENDARY_QUALITY = 80;
    
    /**
     * Update Sulfuras (no changes - legendary item)
     * 
     * @param int $quality Current quality (always 80 for Sulfuras)
     * @param int $sellIn Current sellIn (never changes)
     * @return array{quality: int, sellIn: int} Unchanged values
     */
    protected function doUpdate(int $quality, int $sellIn): array
    {
        // Legendary items never change
        return ['quality' => self::LEGENDARY_QUALITY, 'sellIn' => $sellIn];
    }
    
    /**
     * Override quality constraint for legendary items
     * 
     * @param int $quality Quality value
     * @return int Always returns legendary quality (80)
     */
    protected function constrainQuality(int $quality): int
    {
        // Sulfuras is exempt from normal quality constraints
        return self::LEGENDARY_QUALITY;
    }
    
    /**
     * Check if this strategy handles Sulfuras
     * 
     * @param string $itemName Name of the item
     * @return bool True if item is Sulfuras
     */
    public function canHandle(string $itemName): bool
    {
        return $itemName === self::ITEM_NAME;
    }
}
