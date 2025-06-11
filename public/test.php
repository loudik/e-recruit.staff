<?php
$path = '/home/projectanp/project_recruitment/writable/uploads/formapplicant';
$testFile = $path . '/__write_test.txt';

echo "<pre>";
echo "is_dir: " . (is_dir($path) ? '✅ yes' : '❌ no') . PHP_EOL;
echo "is_writable: " . (is_writable($path) ? '✅ yes' : '❌ no') . PHP_EOL;

try {
    $result = file_put_contents($testFile, "test");
    if ($result === false) {
        echo "❌ file_put_contents FAILED\n";
    } else {
        echo "✅ file_put_contents SUCCESS\n";
        unlink($testFile); // hapus jika sukses
    }
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . PHP_EOL;
}
echo "</pre>";
