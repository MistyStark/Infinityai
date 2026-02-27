<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/upload_media.php';

$file_path = __DIR__ . '/0020_Assets/0010_Image/0070_GoogleLogin.png';
$title = '0070_GoogleLogin';

echo "Attempting upload: $file_path ...\n";
$res = upload_to_wp($file_path, $title);

if ($res['code'] === 201) {
    echo "Success! NEW URL: " . $res['body']['source_url'] . "\n";
} else {
    echo "Error: HTTP Code: " . $res['code'] . "\n";
    echo "Response: " . $res['raw'] . "\n";
}
