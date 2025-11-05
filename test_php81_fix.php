<?php
/**
 * Test script to verify the PHP 8.1 setAttribute() deprecation fix
 *
 * This script demonstrates the issue and the fix without requiring WordPress.
 * Run with: php test_php81_fix.php
 */

echo "PHP Version: " . PHP_VERSION . "\n\n";

// Simulate the old problematic code
echo "=== Testing OLD code (would trigger deprecation warning) ===\n";
try {
    // Simulate wp_get_attachment_image_src() returning false
    $result = false;

    // Old code approach
    list($logo_url, $logo_width, $logo_height) = $result;

    $d = new DOMDocument();
    $img = $d->createElement('img');
    $img->setAttribute('class', 'pnty-logo');

    // This would trigger: "Passing null to parameter #2 ($value) of type string is deprecated"
    $img->setAttribute('src', $logo_url);
    $img->setAttribute('width', $logo_width);

    echo "Old code executed (no error in PHP < 8.1, deprecation warning in PHP 8.1+)\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== Testing NEW code (with fix) ===\n";
try {
    // Simulate wp_get_attachment_image_src() returning false
    $result = false;

    // New code approach with validation
    if ($result !== false) {
        list($logo_url, $logo_width, $logo_height) = $result;

        $d = new DOMDocument();
        $img = $d->createElement('img');
        $img->setAttribute('class', 'pnty-logo');
        $img->setAttribute('src', $logo_url);
        $img->setAttribute('width', $logo_width);

        echo "Image created successfully\n";
    } else {
        echo "✓ Correctly skipped image creation when wp_get_attachment_image_src() returns false\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== Testing NEW code with valid data ===\n";
try {
    // Simulate wp_get_attachment_image_src() returning valid data
    $result = ['https://example.com/logo.png', 500, 500, false];

    // New code approach with validation
    if ($result !== false) {
        list($logo_url, $logo_width, $logo_height) = $result;

        $d = new DOMDocument();
        $img = $d->createElement('img');
        $img->setAttribute('class', 'pnty-logo');
        $img->setAttribute('src', $logo_url);
        $img->setAttribute('width', $logo_width);
        $img->setAttribute('alt', 'Client logotype');
        $d->appendChild($img);

        echo "✓ Image created successfully with valid data\n";
        echo "Generated HTML: " . $d->saveHTML() . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== Summary ===\n";
echo "The fix adds a check for 'false' return value before destructuring,\n";
echo "preventing null values from being passed to setAttribute().\n";
echo "This resolves PHP 8.1+ deprecation warnings.\n";
