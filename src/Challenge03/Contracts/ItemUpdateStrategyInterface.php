<?php

declare(strict_types=1);

namespace Challenlink\Challenge03\Contracts;

/**
 * Item Update Strategy Interface
 * 
 * Defines the contract for different item update behaviors in the Gilded Rose system.
 * This interface enables the Strategy pattern for polymorphic item handling.
 * 
 * @author Richard Braul
 * @version 1.0.0
 */
interface ItemUpdateStrategyInterface
{
    /**
     * Update item quality and sellIn values according to item-specific rules
     * 
     * @param int $quality Current item quality
     * @param int $sellIn Current sellIn days
     * @return array{quality: int, sellIn: int} Updated quality and sellIn values
     */
    public function updateItem(int $quality, int $sellIn): array;
    
    /**
     * Check if this strategy can handle the given item name
     * 
     * @param string $itemName Name of the item to check
     * @return bool True if this strategy can handle the item
     */
    public function canHandle(string $itemName): bool;
}
