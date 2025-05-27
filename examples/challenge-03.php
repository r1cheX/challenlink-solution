<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Challenlink\Challenge03\GildedRose;

// Challenge 03 - Gilded Rose Demo
echo "=== Challenge 03: Gilded Rose Refactored ===\n\n";

// Create sample items
$items = [
    GildedRose::of('Normal Item', 10, 5),
    GildedRose::of('Aged Brie', 10, 5),
    GildedRose::of('Sulfuras, Hand of Ragnaros', 80, 5),
    GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, 15),
    GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, 10),
    GildedRose::of('Backstage passes to a TAFKAL80ETC concert', 10, 5),
    GildedRose::of('Conjured Mana Cake', 10, 5),
    GildedRose::of('Conjured Healing Potion', 8, 2),
];

echo "Initial State:\n";
echo str_repeat("-", 80) . "\n";
foreach ($items as $i => $item) {
    echo sprintf("%2d. %s\n", $i + 1, $item->toString());
}

// Simulate several days
for ($day = 1; $day <= 10; $day++) {
    echo "\n\nDay {$day} - After tick():\n";
    echo str_repeat("-", 80) . "\n";
    
    foreach ($items as $i => $item) {
        $item->tick();
        echo sprintf("%2d. %s\n", $i + 1, $item->toString());
    }
}

echo "\n\n=== Strategy Pattern Demonstration ===\n";
echo "Different item types use different update strategies:\n\n";

// Demonstrate different strategies
$demoItems = [
    ['Normal Item', 'NormalItemStrategy - Degrades by 1 (2 after sell date)'],
    ['Aged Brie', 'AgedBrieStrategy - Improves by 1 (2 after sell date)'],
    ['Sulfuras, Hand of Ragnaros', 'SulfurasStrategy - Never changes (legendary)'],
    ['Backstage passes to a TAFKAL80ETC concert', 'BackstagePassStrategy - Complex appreciation'],
    ['Conjured Mana Cake', 'ConjuredItemStrategy - Degrades by 2 (4 after sell date)'],
];

foreach ($demoItems as [$itemName, $description]) {
    echo "• {$itemName}:\n";
    echo "  Strategy: {$description}\n\n";
}

echo "=== Performance Benefits ===\n";
echo "• Strategy Pattern: O(1) item type resolution\n";
echo "• Factory Pattern: Centralized strategy creation\n";
echo "• SOLID Principles: Easy to extend with new item types\n";
echo "• Clean Code: Eliminated complex conditional logic\n";
