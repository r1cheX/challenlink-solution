<?php

// Simple autoloader for testing without Composer
spl_autoload_register(function ($class) {
    $prefix = 'Challenlink\\';
    $base_dir = __DIR__ . '/src/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Test Challenge 01
echo "=== Testing Challenge 01 ===\n";
try {
    $solver = new Challenlink\Challenge01\ArrayIntersectionSolver();
    
    $testCases = [
        [['1, 3, 4, 7, 13', '1, 2, 4, 13, 15'], '1,4,13'],
        [['1, 3, 9, 10, 17, 18', '1, 4, 9, 10'], '1,9,10'],
        [['5, 7, 9', '1, 2, 3'], 'false'],
    ];
    
    foreach ($testCases as $i => [$input, $expected]) {
        $result = $solver->findPoint($input);
        $status = $result === $expected ? '✓' : '✗';
        echo "Test " . ($i + 1) . ": {$status} Expected: {$expected}, Got: {$result}\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== Testing Challenge 02 ===\n";
try {
    $solver = new Challenlink\Challenge02\MinimumWindowSubstringSolver();
    
    $testCases = [
        [["ahffaksfajeeubsne", "jefaa"], "aksfaje"],
        [["aaffhkksemckelloe", "fhea"], "affhkkse"],
        [["aaabaaddae", "aed"], "dae"],
    ];
    
    foreach ($testCases as $i => [$input, $expected]) {
        $result = $solver->noIterate($input);
        $status = $result === $expected ? '✓' : '✗';
        echo "Test " . ($i + 1) . ": {$status} Expected: {$expected}, Got: {$result}\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== Testing Challenge 03 ===\n";
try {
    // Test normal item
    $item = Challenlink\Challenge03\GildedRose::of('Normal Item', 10, 5);
    $item->tick();
    $status = ($item->quality === 9 && $item->sellIn === 4) ? '✓' : '✗';
    echo "Normal Item: {$status} Quality: {$item->quality}, SellIn: {$item->sellIn}\n";
    
    // Test Aged Brie
    $item = Challenlink\Challenge03\GildedRose::of('Aged Brie', 10, 5);
    $item->tick();
    $status = ($item->quality === 11 && $item->sellIn === 4) ? '✓' : '✗';
    echo "Aged Brie: {$status} Quality: {$item->quality}, SellIn: {$item->sellIn}\n";
    
    // Test Sulfuras
    $item = Challenlink\Challenge03\GildedRose::of('Sulfuras, Hand of Ragnaros', 80, 5);
    $item->tick();
    $status = ($item->quality === 80 && $item->sellIn === 5) ? '✓' : '✗';
    echo "Sulfuras: {$status} Quality: {$item->quality}, SellIn: {$item->sellIn}\n";
    
    // Test Conjured
    $item = Challenlink\Challenge03\GildedRose::of('Conjured Mana Cake', 10, 5);
    $item->tick();
    $status = ($item->quality === 8 && $item->sellIn === 4) ? '✓' : '✗';
    echo "Conjured: {$status} Quality: {$item->quality}, SellIn: {$item->sellIn}\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== All Tests Complete ===\n";
