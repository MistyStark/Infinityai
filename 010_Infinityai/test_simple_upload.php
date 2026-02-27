<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/upload_media.php';

$file_path = __DIR__ . '/a.png';
$title = 'a';

echo "Ultima Attempt with simple filename: $file_path ...\n";
$res = upload_to_wp($file_path, $title);

if ($res['code'] === 201) {
    echo "========================================\n";
    echo "🍵 MIRACLE! Success! NEW URL: " . $res['body']['source_url'] . "\n";
    echo "========================================\n";
} else {
    echo "Critical Error: HTTP Code: " . $res['code'] . "\n";
    echo "Response: " . $res['raw'] . "\n";
}
