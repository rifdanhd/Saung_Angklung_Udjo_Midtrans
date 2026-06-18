<?php
require __DIR__ . '/vendor/autoload.php';
try {
    $qr = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)->generate('test');
    echo "PNG OK\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
