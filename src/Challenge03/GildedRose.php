<?php

declare(strict_types=1);

namespace Challenlink\Challenge03;

use Challenlink\Challenge03\Factories\ItemStrategyFactory;

/**
 * Refactored Gilded Rose Class
 * 
 * Clean, maintainable implementation using Strategy pattern for different item behaviors.
 * Replaces the original spaghetti code with SOLID principles and design patterns.
 * 
 * Key improvements:
 * - Strategy pattern for polymorphic item handling
 * - Single Responsibility Principle compliance
 * - Open/Closed Principle support for new item types
 * - Dependency Injection ready architecture
 * - Comprehensive error handling and validation
 * 
 * @author Richard Braul
 * @version 1.0.0
 */
class GildedRose
{
    public string $name;
    public int $quality;
    public int $sellIn;
    
    private ItemStrategyFactory $strategyFactory;
    
    /**
     * Create a new Gilded Rose item
     * 
     * @param string $name Item name
     * @param int $quality Item quality (0-50, except legendary items)
     * @param int $sellIn Days until sell date
     * @param ItemStrategyFactory|null $strategyFactory Optional factory injection
     * 
     * @throws \InvalidArgumentException If parameters are invalid
     */
    public function __construct(
        string $name, 
        int $quality, 
        int $sellIn, 
        ?ItemStrategyFactory $strategyFactory = null
    ) {
        $this->validateConstructorArguments($name, $quality, $sellIn);
        
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
        $this->strategyFactory = $strategyFactory ?? new ItemStrategyFactory();
    }
    
    /**
     * Static factory method for backward compatibility
     * 
     * @param string $name Item name
     * @param int $quality Item quality
     * @param int $sellIn Days until sell date
     * @return static New GildedRose instance
     */
    public static function of(string $name, int $quality, int $sellIn): self
    {
        return new static($name, $quality, $sellIn);
    }
    
    /**
     * Update item properties based on item-specific rules
     * 
     * Uses Strategy pattern to delegate update logic to appropriate strategy.
     * This replaces the original complex conditional logic with clean polymorphism.
     * 
     * @return void
     */
    public function tick(): void
    {
        $strategy = $this->strategyFactory->createStrategy($this->name);
        $result = $strategy->updateItem($this->quality, $this->sellIn);
        
        $this->quality = $result['quality'];
        $this->sellIn = $result['sellIn'];
    }
    
    /**
     * Get item information as formatted string
     * 
     * @return string Human-readable item description
     */
    public function toString(): string
    {
        return sprintf(
            '%s, quality: %d, sellIn: %d',
            $this->name,
            $this->quality,
            $this->sellIn
        );
    }
    
    /**
     * Get item information as array
     * 
     * @return array{name: string, quality: int, sellIn: int} Item data
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'quality' => $this->quality,
            'sellIn' => $this->sellIn,
        ];
    }
    
    /**
     * Validate constructor arguments
     * 
     * @param string $name Item name
     * @param int $quality Item quality
     * @param int $sellIn Sell in days
     * @throws \InvalidArgumentException If validation fails
     */
    private function validateConstructorArguments(string $name, int $quality, int $sellIn): void
    {
        if (empty(trim($name))) {
            throw new \InvalidArgumentException('Item name cannot be empty');
        }
        
        // Allow legendary items to have quality above normal limits
        if (!$this->isLegendaryItem($name) && ($quality < 0 || $quality > 50)) {
            throw new \InvalidArgumentException(
                'Quality must be between 0 and 50 for non-legendary items'
            );
        }
        
        // No specific validation for sellIn as negative values are valid (past sell date)
    }
    
    /**
     * Check if item is legendary (exempt from normal quality constraints)
     * 
     * @param string $name Item name
     * @return bool True if item is legendary
     */
    private function isLegendaryItem(string $name): bool
    {
        return $name === 'Sulfuras, Hand of Ragnaros';
    }
}
