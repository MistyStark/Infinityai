<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/upload_media.php';

$file_path = __DIR__ . '/agy_login_0070.png';
$title = 'agy_login_0070';

echo "Mission: Escape WAF! Uploading: $file_path ...\n";
$res = upload_to_wp($file_path, $title);

if ($res['code'] === 201) {
    echo "========================================\n";
    echo "🍵 Success! 100-Billion Point URL: " . $res['body']['source_url'] . "\n";
    echo "========================================\n";
} else {
    echo "Error: HTTP Code: " . $res['code'] . "\n";
    echo "Response: " . $res['raw'] . "\n";
}
