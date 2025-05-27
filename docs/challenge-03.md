# Challenge 03 - Gilded Rose Refactoring

## Problem Statement

Refactor the legacy "spaghetti code" in the Gilded Rose inventory system and add support for "Conjured" items. The original code contains deeply nested conditionals and violates multiple SOLID principles.

## Architecture Analysis

### Design Patterns Applied

1. **Strategy Pattern**: Different update behaviors for different item types
2. **Factory Pattern**: Centralized strategy creation and selection
3. **Template Method Pattern**: Common quality constraint enforcement
4. **Dependency Injection**: Flexible strategy factory injection

### SOLID Principles Compliance

- **Single Responsibility**: Each strategy handles one item type
- **Open/Closed**: Easy to add new item types without modifying existing code
- **Liskov Substitution**: All strategies are interchangeable
- **Interface Segregation**: Focused interfaces for specific behaviors
- **Dependency Inversion**: Depends on abstractions, not concretions

## Implementation Details

### Class Hierarchy

```
ItemUpdateStrategyInterface
├── AbstractItemStrategy (Template Method)
    ├── NormalItemStrategy
    ├── AgedBrieStrategy
    ├── SulfurasStrategy
    ├── BackstagePassStrategy
    └── ConjuredItemStrategy

ItemStrategyFactory (Factory Pattern)
GildedRose (Context using Strategy)
```

### Strategy Behaviors

| Item Type | Quality Change | Special Rules |
|-----------|----------------|---------------|
| Normal | -1 (-2 after sell date) | Standard degradation |
| Aged Brie | +1 (+2 after sell date) | Improves with age |
| Sulfuras | No change | Legendary item (quality: 80) |
| Backstage Pass | +1/+2/+3 (0 after concert) | Complex appreciation curve |
| Conjured | -2 (-4 after sell date) | Degrades twice as fast |

### Key Improvements

1. **Eliminated Complex Conditionals**: Replaced nested if-else with polymorphism
2. **Improved Readability**: Clear, self-documenting code structure
3. **Enhanced Maintainability**: Easy to modify individual item behaviors
4. **Better Testability**: Each strategy can be tested independently
5. **Extensibility**: New item types require only new strategy classes

## Example Usage

```php
use Challenlink\Challenge03\GildedRose;

// Create items
$items = [
    GildedRose::of('Normal Item', 10, 5),
    GildedRose::of('Aged Brie', 8, 3),
    GildedRose::of('Sulfuras, Hand of Ragnaros', 80, 5),
    GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 15, 8),
    GildedRose::of('Conjured Mana Cake', 12, 4),
];

// Update all items
foreach ($items as $item) {
    $item->tick();
    echo $item->toString() . "\n";
}
```

## Performance Analysis

### Time Complexity: O(1)
- Strategy selection: O(1) with factory pattern
- Item update: O(1) for each strategy
- No loops or recursive calls

### Space Complexity: O(1)
- Fixed number of strategy instances
- No additional data structures
- Constant memory usage per item

## Code Quality Metrics

### Before Refactoring (Original Code)
- **Cyclomatic Complexity**: 15+
- **Lines of Code**: 74 lines in single method
- **Nested Conditionals**: 6+ levels deep
- **Maintainability Index**: Low

### After Refactoring (Solution)
- **Cyclomatic Complexity**: 2-3 per class
- **Lines of Code**: 20-40 lines per strategy
- **Nested Conditionals**: 1-2 levels maximum
- **Maintainability Index**: High

## Testing Strategy

### Unit Tests Coverage
- ✅ All existing behavior preserved
- ✅ Conjured items functionality added
- ✅ Edge cases handled (quality boundaries)
- ✅ Strategy pattern functionality verified
- ✅ Factory pattern tested

### Test Categories
1. **Regression Tests**: Ensure original behavior unchanged
2. **New Feature Tests**: Verify Conjured items work correctly
3. **Boundary Tests**: Quality limits (0-50, except Sulfuras)
4. **Integration Tests**: Strategy factory selection logic

## Extension Examples

Adding a new item type is straightforward:

```php
class MagicItemStrategy extends AbstractItemStrategy
{
    protected function doUpdate(int $quality, int $sellIn): array
    {
        // Custom magic item logic
        return ['quality' => $newQuality, 'sellIn' => $newSellIn];
    }
    
    public function canHandle(string $itemName): bool
    {
        return stripos($itemName, 'Magic') !== false;
    }
}
```

Just add to the factory's strategy list - no changes to existing code required!
