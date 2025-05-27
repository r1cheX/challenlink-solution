<?php

declare(strict_types=1);

namespace Challenlink\Challenge03\Factories;

use Challenlink\Challenge03\Contracts\ItemUpdateStrategyInterface;
use Challenlink\Challenge03\Strategies\{
    AgedBrieStrategy,
    BackstagePassStrategy,
    ConjuredItemStrategy,
    NormalItemStrategy,
    SulfurasStrategy
};

/**
 * Item Strategy Factory
 * 
 * Creates appropriate update strategies based on item names using the Factory pattern.
 * Provides centralized strategy selection logic with priority-based matching.
 * 
 * @author Richard Braul
 * @version 1.0.0
 */
class ItemStrategyFactory
{
    /** @var array<ItemUpdateStrategyInterface> */
    private array $strategies;
    
    /** @var ItemUpdateStrategyInterface */
    private ItemUpdateStrategyInterface $defaultStrategy;
    
    public function __construct()
    {
        $this->initializeStrategies();
    }
    
    /**
     * Create appropriate strategy for the given item name
     * 
     * @param string $itemName Name of the item
     * @return ItemUpdateStrategyInterface Strategy for handling the item
     */
    public function createStrategy(string $itemName): ItemUpdateStrategyInterface
    {
        // Check specialized strategies first (order matters for priority)
        foreach ($this->strategies as $strategy) {
            if ($strategy->canHandle($itemName)) {
                return $strategy;
            }
        }
        
        // Fallback to default strategy
        return $this->defaultStrategy;
    }
    
    /**
     * Initialize all available strategies in priority order
     */
    private function initializeStrategies(): void
    {
        // Order is important: more specific strategies should be checked first
        $this->strategies = [
            new SulfurasStrategy(),      // Legendary items (highest priority)
            new ConjuredItemStrategy(),  // Conjured items (before normal items)
            new AgedBrieStrategy(),      // Aged Brie
            new BackstagePassStrategy(), // Backstage passes
        ];
        
        // Default strategy for items not handled by specific strategies
        $this->defaultStrategy = new NormalItemStrategy();
    }
    
    /**
     * Get all available strategy types
     * 
     * @return array<string> List of strategy class names
     */
    public function getAvailableStrategies(): array
    {
        $strategyNames = array_map(
            fn(ItemUpdateStrategyInterface $strategy): string => get_class($strategy),
            $this->strategies
        );
        
        $strategyNames[] = get_class($this->defaultStrategy);
        
        return $strategyNames;
    }
}
